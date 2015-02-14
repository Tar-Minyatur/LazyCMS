<?php
namespace LazyCMS;

class LazyCMS {
    
    private $page;
    private $config;
    private $passwordUtil;
    
    public function __construct ($config, PasswordUtil $passwordUtil) {
        session_start();
        $this->config = $config;
        $this->passwordUtil = new PasswordUtil();
        $this->initializePageVariables();
    }
    
    private function initializePageVariables () {
        $this->page = new \StdClass;
        $this->page->rootDir = dirname($_SERVER['PHP_SELF']);
        $this->page->formAction = $_SERVER['PHP_SELF'];
        $this->page->error = null;
        $this->page->confirmation = null;
        $this->page->loggedIn = $this->isLoggedIn();
        $this->page->fields = array();
        $this->page->generatorLog = null;
        $this->page->extractorLog = null;
        $this->page->homepageURL = $this->config->homepageURL;
        $this->page->currentPage = "content";
    }    
    
    public function render () {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->handlePostAction();
        }
        $this->preparePageData();
        $page = $this->page;
        require(ROOT_DIR . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'index.template.php');
    }
    
    private function handlePostAction () {
        switch ($_POST['action']) {        
            case 'login':
                $this->login(isset($_POST['password']) ? $_POST['password'] : null);                
                break;
            
            case 'logout':
                $this->logout();
                break;
            
            case 'updateData':
                if ($this->isLoggedIn()) {
                    $this->updateData(isset($_POST['fields']) ? $_POST['fields'] : array());
                } else {
                    $this->page->error = "You are not logged in!";
                }
                break;
            
            case 'generateFiles':
                if ($this->isLoggedIn()) {
                    $this->page->currentPage = "generator";
                    $this->generateFiles();
                } else {
                    $this->page->error = "You are not logged in!";
                }
                break;
            
            case 'extractLabels':
                if ($this->isLoggedIn()) {
                    $this->page->currentPage = "extractor";
                    $this->extractLabels();
                } else {
                    $this->page->error = "You are not logged in!";
                }
                break;
            
            case 'replaceDataFile':
                if ($this->isLoggedIn()) {
                    $this->replaceDataFile(isset($_POST['json']) ? $_POST['json'] : null);
                } else {
                    $this->page->error = "You are not logged in!";
                }
                break;
        }
    }
    
    private function preparePageData () {
        if ($this->isLoggedIn()) {
            if ($this->page->currentPage == "content") {
                $lazyDAO = new LazyDAO($this->config->dataFile);
                $data = $lazyDAO->getTextLabels();
                if (!is_array($data)) {
                    $this->page->error = $data;
                } else {
                    $this->page->fields = $data;
                }
            }
        }
    }

    private function isLoggedIn () {
        return isset($_SESSION['password']) &&
               ($this->passwordUtil->passwordMatchesHash($_SESSION['password'], $this->config->adminPasswordHash));
    }
    
    private function login ($password) {
        if (is_null($password) || (strlen($password) < 1)) {
            $this->page->error = "You did not enter a password.";
        } else {
            if ($this->passwordUtil->passwordMatchesHash($this->config->adminPasswordHash, $password)) {
                $_SESSION['password'] = $this->passwordUtil->hashPassword($this->config->adminPasswordHash);
                $this->page->confirmation = "You have been logged in.";
            } else {
                $this->page->confirmation = "Wrong password.";
            }
        }
        $this->page->loggedIn = $this->isLoggedIn();
    }
    
    private function logout () {
        unset($_SESSION['password']);
        $this->page->confirmation = "You have been logged out.";
        $this->page->loggedIn = false;
    }
    
    private function updateData (array $fields) {
        $success = true;
        if (!$this->backup()) {
            $this->page->error = sprintf("Could not write backup to folder %s", $this->config->backupDir);
            $success = false;
        }
        if (count($fields) < 1) {
            $this->page->error = "Something went wrong. Changes could not be saved.";
            $success = false;
        } 
        $json = json_encode($fields, defined('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : 0);
        if (file_put_contents($this->config->dataFile, $json) !== false) {
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
        $this->page->newFields = $lazyEx->extractFields();
        $this->page->extractorLog = $lazyEx->getLog();
        $this->page->confirmation = 'Fields extracted from the input files';
    }
    
    private function replaceDataFile ($json) {
        if (is_null($json)) {
            $this->page->error = 'No JSON was provided. Could not update the data file.';
        } else {
            $data = json_decode($json, true, 3);
            if (is_null($data)) {
                $this->page->error = 'Provided data is not valid JSON. Could not update the data file.';
            } else {
                $this->updateData($data);
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
        $backupFile = sprintf('%s%s_backup_%s', $this->config->backupDir, basename($this->config->dataFile), date('Y-m-d_H-i-s'));
        return @copy($this->config->dataFile, $backupFile);
    }
    
}