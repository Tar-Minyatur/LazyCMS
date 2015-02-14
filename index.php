<?php
define('IN_LAZY_CMS', true);

define('ROOT_DIR', dirname(__FILE__));

if (!file_exists('config.inc.php')) {
    die("You need to create the config file at config.inc.php first.<br /><br />
        Just rename config-sample.inc.php and customize the settings in there as necessary.");
}
require 'config.inc.php';
require 'vendor/autoload.php';

error_reporting(E_ALL | E_NOTICE);

$lazyCMS = new LazyCMS\LazyCMS($lazyConfig, new \LazyCMS\PasswordUtil());
$lazyCMS->render();