<?php
class LazyCMS {
    
    private $page;
    private $dataFile;
    private $adminPassword;
    
    public function __construct ($dataFile, $adminPassword) {
        session_start();
        $this->dataFile = $dataFile;
        $this->adminPassword = $adminPassword;
        $this->initializePageVariables();
    }
    
    private function initializePageVariables () {
        $this->page = new stdClass;
        $this->page->formAction = $_SERVER['PHP_SELF'];
        $this->page->error = null;
        $this->page->confirmation = null;
        $this->page->loggedIn = $this->isLoggedIn();
        $this->page->fields = array();
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
        }
    }
    
    private function preparePageData () {
        if ($this->isLoggedIn()) {
            $json = file_get_contents("text_labels.json");
            if ($json === false) {
                $this->page->error = sprintf('Could not read from file %s! Make sure it exists and is readable!', DATA_FILE);
            } else {
                $data = json_decode($json, true, 2);
                if (is_null($data)) {
                    $this->page->error = sprintf('JSON in file %s is invalid!', DATA_FILE);
                } else {
                    $this->page->fields = $data;
                }
            }
        }
    }

    private function isLoggedIn () {
        return isset($_SESSION['password']) && ($_SESSION['password'] === $this->adminPassword);
    }
    
    private function login ($password) {
        if (is_null($password) || (strlen($password) < 1)) {
            $this->page->error = "You did not enter a password.";
        } else {
            if (sha1($password) === $this->adminPassword) {
                $_SESSION['password'] = sha1($password);
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
        $this->backup();
        if (count($fields) < 1) {
            $this->page->error = "Something went wrong. Changes could not be saved.";
        } else {
            if (file_put_contents($this->dataFile, json_encode($fields)) !== false) {
                $this->page->confirmation = "Changes have been saved.";
            } else {
                $this->page->error = sprintf('Changes could not be saved. Maybe file %s is not writable?', $this->dataFile);
            }
        }
    }
    
    private function backup () {
        @copy($this->dataFile, sprintf('%s_backup_%s', $this->dataFile, date('Y-m-d_H-m-s')));
    }
    
}