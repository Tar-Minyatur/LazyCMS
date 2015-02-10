<?php
define('IN_LAZY_CMS', true);

require('config.inc.php');

session_start();

$page = new stdClass;
$page->formAction = $_SERVER['PHP_SELF'];
$page->error = null;
$page->confirmation = null;

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'login':
            if (!isset($_POST['password'])) {
                $page->error = "You did not enter a password.";
            } else {
                if (sha1($_POST['password']) === ADMIN_PASSWORD) {
                    $_SESSION['password'] = sha1($_POST['password']);
                    $page->confirmation = "You have been logged in.";
                } else {
                    $page->confirmation = "Wrong password.";
                }
            }
            break;
        case 'logout':
            unset($_SESSION['password']);
            $page->confirmation = "You have been logged out.";
            break;
        case 'updateData':
            @copy(DATA_FILE, sprintf('%s_backup_%s', DATA_FILE, date('Y-m-d_H-m-s')));
            if (isset($_POST['field'])) {
                $page->error = "Something went wrong. Changes could not be saved.";
            } else {
                if (file_put_contents(DATA_FILE, json_encode($_POST['fields'])) !== false) {
                    $page->confirmation = "Changes have been saved.";
                } else {
                    $page->error = sprintf('Changes could not be saved. Maybe file %s is not writable?', DATA_FILE);
                }
            }
            break;
    }
}

$page->loggedIn = isset($_SESSION['password']) && ($_SESSION['password'] === ADMIN_PASSWORD);

if ($page->loggedIn) {
    $json = file_get_contents("text_labels.json");
    if ($json === false) {
        $page->error = sprintf('Could not read from file %s! Make sure it exists and is readable!', DATA_FILE);
    } else {
        $data = json_decode($json, true, 2);
        if (is_null($data)) {
            $page->error = sprintf('JSON in file %s is invalid!', DATA_FILE);
        } else {
            $page->fields = $data;
        }
    }
}

require('templates/index.template.php');