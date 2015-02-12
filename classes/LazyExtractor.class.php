<?php
class LazyExtractor {
 
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
        $fields = array();
        $sections = array('global' => array());
        $this->errorCount = 0;
        foreach ($this->fileMapping as $inputFile => $outputFile) {
            if (!is_file($inputFile) || !is_readable($inputFile)) {
                $this->log[] = sprintf('ERROR: File %s does not exist or is not readable', $inputFile);
                $this->errorCount++;
                continue;
            }
            $content = file_get_contents($inputFile);
            if (!preg_match_all($this->labelRegEx, $content, $matches)) {
                $this->log[] = sprintf('INFO: No text labels found in file %s', $inputFile);
            }
            $sections[$inputFile] = array();
            foreach ($matches['label'] as $match) {
                if (!isset($fields[$match])) {
                    $fields[$match] = array();
                }
                $fields[$match][] = $inputFile;
                $sections[$inputFile][$match] = $match;
            }
            $this->log[] = sprintf('INFO: Found %d text labels in file %s', count($sections[$inputFile]), $inputFile);
        }
        foreach ($fields as $field => $where) {
            if (count($where) > 1) {
                $this->log[] = sprintf('INFO: Label %s is used in multiple sections; extracting into global', $field);
                $sections['global'][$field] = $field;
                foreach ($where as $s) {
                    unset($sections[$s][$field]);
                }
            }
        }
        return $sections;
    }
    
    public function getLog () {
        return $this->log;
    }
    
}