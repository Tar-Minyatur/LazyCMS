<?php
define('IN_LAZY_CMS', true);

define('ROOT_DIR', dirname(__FILE__));

if (!file_exists('config.inc.php')) {
    die("You need to create the config file at config.inc.php first.<br /><br />
        Just rename config-sample.inc.php and customize the settings in there as necessary.");
}
require('config.inc.php');
require('classes/autoload.inc.php');

$lazyCMS = new LazyCMS($lazyConfig);
$lazyCMS->render();