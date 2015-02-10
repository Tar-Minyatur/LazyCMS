<?php
if (!defined('IN_LAZY_CMS')) {
    die('Security violation.');
}

/**
 * Admin Password.
 * Use a SHA1 hash here!
 * To create a new one, you can use $ php -r 'echo sha1("password");'
 */
define('ADMIN_PASSWORD', 'd033e22ae348aeb5660fc2140aec35850c4da997');

/**
 * The JSON file with text labels to display and save to
 */
define('DATA_FILE', ROOT_DIR . DIRECTORY_SEPARATOR . 'text_labels.json');