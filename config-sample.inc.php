<?php
if (!defined('IN_LAZY_CMS')) {
    die('Security violation.');
}

$lazyConfig = new stdClass;

/**
 * Admin Password.
 * Use a SHA1 hash here! (Default password is "admin".)
 * To create a new one, you can use $ php -r 'echo sha1("password");'
 */
$lazyConfig->adminPassword = 'd033e22ae348aeb5660fc2140aec35850c4da997';

/**
 * The JSON file with text labels to display and save to
 */
$lazyConfig->dataFile = ROOT_DIR . '/example/data/text_labels.json';

/**
 * Backup folder.
 * In this directoy old versions of the data file will be kept.
 */
$lazyConfig->backupDir = ROOT_DIR . '/backup';

/**
 * Homepage URL.
 */
$lazyConfig->homepageURL = dirname($_SERVER['PHP_SELF']) . '/example/output';

/**
 * Code Generator File Mapping.
 * Add all files you want to generate like this:
 * 'inputFile' => 'outputFile'
 * The paths need to be relative to the root dir of LazyCMS.
 */
$lazyConfig->fileMapping = array(
    'example/input/index.html' => 'example/output/index.html',
    'example/input/page2.html' => 'example/output/page2.html'
);

/**
 * Text Label Delimiter.
 * These will be prepended /appended to all text labels.
 * Default: {{ and }}
 * Example: {{my_textlabel}}
 */
$lazyConfig->labelDelimiterLeft = '{{';
$lazyConfig->labelDelimiterRight = '}}';

/**
 * Label Extractor RegEx.
 * This is used to find labels in source files.
 * There should (theoretically) be no reason to change this.
 */
$lazyConfig->labelRegEx = sprintf('/%s(?<label>[^%s]+)%s/U', 
                                  preg_quote($lazyConfig->labelDelimiterLeft),
                                  preg_quote($lazyConfig->labelDelimiterRight),
                                  preg_quote($lazyConfig->labelDelimiterRight));