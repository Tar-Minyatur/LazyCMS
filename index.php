<?php
define('IN_LAZY_CMS', true);

define('ROOT_DIR', dirname(__FILE__));

require('config.inc.php');
require('classes/autoload.inc.php');

$lazyCMS = new LazyCMS($lazyConfig);
$lazyCMS->render();