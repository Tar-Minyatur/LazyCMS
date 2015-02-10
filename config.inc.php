<?php
if (!defined('IN_LAZY_CMS')) {
    die('Security violation.');
}

// Use a SHA1 hash here!
// $ php -r 'echo sha1("password");'
define('ADMIN_PASSWORD', 'd033e22ae348aeb5660fc2140aec35850c4da997');

// The JSON file with text labels to display and save to
define('DATA_FILE', 'text_labels.json');