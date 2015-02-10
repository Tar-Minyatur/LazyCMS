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

$lazyConfig = new stdClass;

/**
 * Code Generator File Mapping.
 * Add all files you want to generate like this:
 * 'inputFile' => 'outputFile'
 * The paths need to be relative to the root dir of LazyCMS.
 */
$lazyConfig->fileMapping = array(
    'input/index.html' => 'output/index.html'
);

/**
 * Text Label Delimiter.
 * This will be prepended and appended to all text labels.
 * Default: !
 * Example: !my_textlabel!
 */
$lazyConfig->labelDelimiter = '!';