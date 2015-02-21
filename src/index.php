<?php
define('IN_LAZY_CMS', true);

define('ROOT_DIR', dirname(__FILE__));

if (!file_exists('config.inc.php')) {
    die("You need to create the config file at config.inc.php first.<br /><br />
        Just rename config-sample.inc.php and customize the settings in there as necessary.");
}
require 'config.inc.php';
require 'vendor/autoload.php';

if ($lazyConfig->debugMode) {
    error_reporting(E_ALL);
}

use LazyCMS\Utils\PasswordUtil;
use League\Plates;

$lazyCMS = new LazyCMS\LazyCMS($lazyConfig, new PasswordUtil(), new Plates\Engine());
$lazyCMS->handleRequest(\LazyCMS\Utils\HttpRequest::getDefaultInstance());