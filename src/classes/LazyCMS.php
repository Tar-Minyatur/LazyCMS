<?php
namespace LazyCMS;

use LazyCMS\Utils\FileSystemUtil;
use LazyCMS\Utils\HttpRequest;
use LazyCMS\Utils\PasswordUtil;
use \League\Plates;

class LazyCMS {
    
    private $page;
    private $config;
    private $passwordUtil;
    private $templates;
    
    public function __construct ($config, PasswordUtil $passwordUtil, Plates\Engine $templates) {
        session_start();
        $this->config = $config;
        $this->passwordUtil = new PasswordUtil();
        $this->templates = $templates;
        $this->templates->addFolder('cms', ROOT_DIR . '/templates/cms');
        $this->initializePageVariables();
    }
    
    private function initializePageVariables () {
        $this->page = new \StdClass;
        $this->page->rootDir = dirname($_SERVER['PHP_SELF']);
        $this->page->formAction = $_SERVER['PHP_SELF'];
        $this->page->error = null;
        $this->page->confirmation = null;
        $this->page->loggedIn = false;
        $this->page->homepageURL = $this->config->homepageURL;
        $this->page->currentPage = "content_management";
    }    
    
    public function handleRequest (HttpRequest $request) {
        $this->interceptAuthenticationActions($request);

        if (!$this->isLoggedIn($request)) {
            $this->page->loggedIn = false;
            $template = 'login';
        } else {
            $this->page->loggedIn = true;
            if ($request->server->request_method == 'POST') {
                $this->handlePostAction($request);
            }
            $template = $this->page->currentPage;
            $this->preparePageData();
        }
        $this->templates->addData(get_object_vars($this->page));
        echo $this->templates->render('cms::' . $template);
    }
    
    private function handlePostAction (HttpRequest $request) {
        if (!$this->isLoggedIn($request)) {
            $this->page->error = "You are not logged in!";
        } else {
            switch ($_POST['action']) {
                case 'updateData':
                    if (!isset($request->post->files) ||
                        !isset($request->post->fields) ||
                        (count($request->post->fields) !== count($request->post->files))) {
                        $this->page->error = 'The submitted data was invalid. Changes could not be saved.';
                    } else {
                        for ($i = 0; $i < count($request->post->files); ++$i) {
                            $targetFile = $this->config->dataDirectory . DIRECTORY_SEPARATOR . $request->post->files[$i];
                            if (!$this->updateDataFile($targetFile, $request->post->fields[$i])) {
                                $this->page->error = sprintf('Could not save to file %s.',
                                                             $targetFile);
                                break;
                            }
                        }
                        $this->page->confirmation = 'Changes have been saved successfully';
                    }
                    break;

                case 'generateFiles':
                    $this->page->currentPage = "generator_log";
                    $this->generateFiles();
                    break;

                case 'extractLabels':
                    $this->page->currentPage = "label_extractor";
                    $this->extractLabels();
                    break;

                case 'replaceDataFile':
                    $this->replaceDataFiles(
                        isset($request->post->files) && is_array($request->post->files) ? $request->post->files : null,
                        isset($request->post->jsons) && is_array($request->post->jsons) ? $request->post->jsons : null);
                    break;
            }
        }
    }
    
    private function preparePageData () {
        if ($this->page->currentPage == "content_management") {
            $lazyDAO = new LazyDAO($this->config->dataDirectory);
            $files = $lazyDAO->getDataFiles();
            $this->page->dataFiles = array();
            foreach ($files as $file) {
                $fields = json_decode(file_get_contents($file));
                if (!is_null($fields)) {
                    $file = str_replace($this->config->dataDirectory . DIRECTORY_SEPARATOR, '', $file);
                    $this->page->dataFiles[$file] = $fields;
                } else {
                    $this->page->error = 'Could not read all data files. Some may be corrupted.';
                }
            }
        }
    }

    private function isLoggedIn (HttpRequest $request) {
        return isset($request->session->password) &&
               ($this->passwordUtil->passwordMatchesHash($request->session->password, $this->config->adminPasswordHash));
    }

    public function interceptAuthenticationActions(HttpRequest $request) {
        if ($request->server->request_method == 'POST') {
            if (isset($request->post->action) && ($request->post->action == 'login')) {
                $this->login(isset($request->post->password) ? $request->post->password : null);
            }
            else if (isset($request->post->action) && ($request->post->action == 'logout')) {
                $this->logout();
            }
        }
    }

    private function login ($password) {
        $this->page->loggedIn = false;
        if (is_null($password) || (strlen($password) < 1)) {
            $this->page->error = "You did not enter a password.";
        } else {
            if ($this->passwordUtil->passwordMatchesHash($this->config->adminPasswordHash, $password)) {
                $_SESSION['password'] = $this->passwordUtil->hashPassword($this->config->adminPasswordHash);
                $this->page->confirmation = "You have been logged in.";
            } else {
                $this->page->error = "Wrong password.";
            }
        }
    }

    private function logout () {
        unset($_SESSION['password']);
        $this->page->confirmation = "You have been logged out.";
    }

    private function updateDataFile ($file, array $fields) {
        $success = true;
        if (!$this->backup($file)) {
            $this->page->error = sprintf("Could not write backup to folder %s", $this->config->backupDir);
            $success = false;
        }
        if (count($fields) < 1) {
            $this->page->error = "Something went wrong. Changes could not be saved.";
            $success = false;
        }
        $json = json_encode($fields, defined('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : 0);
        $directory = dirname($file);
        if (!file_exists($directory) || !is_dir($directory)) {
            if (!mkdir($directory, 0777, true)) {
                $this->page->error = sprintf('Could not create directory %s. Changes could not be saved.', $directory);
                return false;
            }
        }
        if (file_put_contents($file, $json) !== false) {
            $this->page->confirmation = "Changes have been saved.";
        } else {
            $this->page->error = sprintf('Changes could not be saved. Maybe file %s is not writable?', $this->config->dataFile);
            $success = false;
        }
        return $success;
    }

    private function generateFiles () {
        $lazyGen = new LazyGenerator($this->config);
        $errorCount = $lazyGen->generate();
        $this->page->generatorLog = $lazyGen->getLog();
        if ($errorCount > 0) {
            $this->page->error = 'File generation finished with errors';
        } else {
            $this->page->confirmation = 'All files generated successfully';
        }
    }

    private function extractLabels () {
        $lazyEx = new LazyExtractor($this->config);
        $newFields = array();
        foreach ($lazyEx->extractFields() as $file => $fields) {
            $file = $this->config->dataDirectory . $file . '.json';
            $newFields[$file] = json_encode($fields, defined('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : 0);
        }
        $this->page->newFields = $newFields;
        $this->page->extractorLog = $lazyEx->getLog();
        $this->page->confirmation = 'Fields extracted from the input files';
    }

    private function replaceDataFiles (array $files, array $jsons) {
        if (is_null($jsons) || is_null($files) || (count($files) != count($jsons))) {
            $this->page->error = 'Something went wrong. Could not update the data files.';
        } else {
            for ($i = 0; $i < count($files); ++$i) {
                $data = json_decode($jsons[$i], true, 2);
                if (is_null($data)) {
                    $this->page->error = sprintf('Data provided for file %s is not valid JSON. Could not update the data files.',
                                                 $files[$i]);
                } else {
                    $this->updateDataFile($files[$i], $data);
                }
            }
        }
    }

    private function backup () {
        if ($this->config->backupDir{strlen($this->config->backupDir)-1} !== DIRECTORY_SEPARATOR) {
            $this->config->backupDir .= DIRECTORY_SEPARATOR;
        }
        if (!is_dir($this->config->backupDir)) {
            if (!mkdir($this->config->backupDir, 0777, true)) {
                return false;
            }
        }
        $backupDirectory = sprintf('%sbackup_%s/', $this->config->backupDir, date('Y-m-d_H-i-s'));
        $fsUtil = new FileSystemUtil();
        return $fsUtil->recursiveCopy($this->config->dataDirectory, $backupDirectory);
    }

}