<?php
namespace LazyCMS;

class LazyExtractor {

    const SCOPE_GLOBAL = 'global';

    private $labelDelimiterLeft;
    private $labelDelimiterRight;
    private $labelRegEx;
    private $fileMapping;
    private $log;
    private $errorCount;

    public function __construct ($config) {
        $this->labelDelimiterLeft = $config->labelDelimiterLeft;
        $this->labelDelimiterRight = $config->labelDelimiterRight;
        $this->fileMapping = $config->fileMapping;
        $this->labelRegEx = $config->labelRegEx;
        $this->log = array();
    }
    
    public function extractFields () {
        $sections = array(self::SCOPE_GLOBAL => array());
        $this->errorCount = 0;
        foreach ($this->fileMapping as $inputFile => $outputFile) {
            $globalLabelsFound = 0;
            $currentScope = LazyDAO::getScopeNameForFile($inputFile);
            if (!is_file($inputFile) || !is_readable($inputFile)) {
                $this->log[] = sprintf('ERROR: File %s does not exist or is not readable', $inputFile);
                $this->errorCount++;
                continue;
            }
            $content = file_get_contents($inputFile);
            if (!preg_match_all($this->labelRegEx, $content, $matches, PREG_SET_ORDER)) {
                $this->log[] = sprintf('INFO: No text labels found in file %s', $inputFile);
            }
            $sections[$currentScope] = array();
            foreach ($matches as $match) {
                $label = $match['label'];
                $scope = $currentScope;
                if (array_key_exists('scope', $match) && (strlen($match['scope']))) {
                    $scope = $match['scope'];
                }
                $default = null;
                if (array_key_exists('default', $match)) {
                    $default = $match['default'];
                };
                $sections[$scope][$label] = (is_null($default) || (strlen($default) == 0)) ? $label : $default;
                if ($scope == self::SCOPE_GLOBAL) {
                    $globalLabelsFound++;
                } else if (array_key_exists($label, $sections[self::SCOPE_GLOBAL])) {
                    $this->log[] = sprintf('WARNING: Label %s in file %s also exists in the global scope!', $label, $inputFile);
                }
            }
            $this->log[] = sprintf('INFO: Found %d local and %d global text labels in file %s',
                                   count($sections[$currentScope]),
                                   $globalLabelsFound,
                                   $inputFile);
        }
        return $sections;
    }
    
    public function getLog () {
        return $this->log;
    }

}