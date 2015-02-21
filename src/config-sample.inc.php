<?php
if (!defined('IN_LAZY_CMS')) {
    die('Security violation.');
}

$lazyConfig = new \StdClass;

/************************
 *  BASIC CONFIGURATION *
 ************************/

/**
 * Admin Password.
 * Open /createPassword.php in your browser to create hash for your password.
 * Default password is "admin". Don't forget to change it!
 */
$lazyConfig->adminPasswordHash = '$2a$10$i993/Xjkfn.D.m.0Gz7fdOKUZ8BNxjtPqRVQ.RpQXS0ZUOd.Rlv0W';

/**
 * The directory where the JSON files with the text labels will be stored.
 * If you want to keep this flexible, use ROOT_DIR as application root.
 */
$lazyConfig->dataDirectory = dirname(ROOT_DIR) . '/example/data/';

/**
 * Backup folder.
 * In this directoy old versions of the data files will be kept.
 * If you want to keep this flexible, use ROOT_DIR as application root.
 */
$lazyConfig->backupDir = ROOT_DIR . '/backup';

/**
 * Homepage URL.
 * This is where you will be lead to when you click "Open Homepage" in the CMS.
 */
$lazyConfig->homepageURL = dirname(dirname($_SERVER['PHP_SELF'])) . '/example/output';

/**
 * Code Generator File Mapping.
 * Add all files you want to generate like this:
 * 'inputFile' => 'outputFile'
 * Don't use relative paths here. If you need to reference the application
 * root, use ROOT_DIR.
 */
$lazyConfig->fileMapping = array(
    ROOT_DIR . '/example/input/index.html' => ROOT_DIR . '/example/output/index.html',
    ROOT_DIR . '/example/input/page2.html' => ROOT_DIR . '/example/output/page2.html'
);

/*********************
 * ADVANCED FEATURES *
 *********************/

/**
 * Debug Mode.
 * Should be deactivated on production systems!
 */
$lazyConfig->debugMode = false;

/**
 * Text Label Delimiter.
 * These will be prepended/appended to all text labels.
 * Default: {{ and }}
 * Example: {{my_textlabel}}
 */
$lazyConfig->labelDelimiterLeft = '{{';
$lazyConfig->labelDelimiterRight = '}}';

/**
 * Scope Operator.
 * This string is used to separate the scope fro the text label name.
 * Default: /
 * Example: {{global/textlabel}}
 */
$lazyConfig->labelScopeOperator = '/';

/**
 * Text Label Default Value Delimiter.
 * Appending a value after a label surrounded by these delimiters will
 * define a default value for the label.
 * Default: ( and )
 * Example: {{my_textlabel(Default Value)}}
 */
$lazyConfig->labelDefaultDelimiterLeft = '(';
$lazyConfig->labelDefaultDelimiterRight = ')';

/**
 * Label Extractor RegEx.
 * This is used to find labels in source files.
 * There should (theoretically) be no reason to change this.
 */
$lazyConfig->labelRegEx = sprintf('_%1$s(?:(?<scope>[^%2$s]+)%2$s)?(?<label>[^%2$s%3$s%4$s]+)(?:%4$s(?<default>[^%5$s]+)%5$s)?%3$s_U',
    /* %1$s */  preg_quote($lazyConfig->labelDelimiterLeft, '_'),
    /* %2$s */  preg_quote($lazyConfig->labelScopeOperator, '_'),
    /* %3$s */  preg_quote($lazyConfig->labelDelimiterRight, '_'),
    /* %4$s */  preg_quote($lazyConfig->labelDefaultDelimiterLeft),
    /* %5$s */  preg_quote($lazyConfig->labelDefaultDelimiterRight));