<?php
error_reporting(E_ALL | E_NOTICE);
define('IN_LAZY_CMS', true);

define('ROOT_DIR', dirname(__FILE));

require('config.inc.php');
require('classes/autoload.inc.php');

$lazyCMS = new LazyCMS(DATA_FILE, ADMIN_PASSWORD);
$lazyCMS->render();