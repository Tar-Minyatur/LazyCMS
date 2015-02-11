<?php
if (!defined('IN_LAZY_CMS')) {
    die('Security violation.');
}

$lazyConfig = new stdClass;

/**
 * Admin Password.
 * Use a SHA1 hash here!
 * To create a new one, you can use $ php -r 'echo sha1("password");'
 */
$lazyConfig->adminPassword = 'd033e22ae348aeb5660fc2140aec35850c4da997';

/**
 * The JSON file with text labels to display and save to
 */
$lazyConfig->dataFile = ROOT_DIR . DIRECTORY_SEPARATOR . 'text_labels.json';

/**
 * Backup folder.
 * In this directoy old versions of the data file will be kept.
 */
$lazyConfig->backupDir = ROOT_DIR . DIRECTORY_SEPARATOR . 'backup';

/**
 * Homepage URL.
 */
$lazyConfig->homepageURL = dirname($_SERVER['PHP_SELF']) . DIRECTORY_SEPARATOR . 'output';

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
$lazyConfig->labelDelimiterLeft = '!';
$lazyConfig->labelDelimiterRight = '!';