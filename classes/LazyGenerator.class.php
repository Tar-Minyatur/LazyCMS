<?php
class LazyGenerator {
    
    private $dataFile;
    private $fileMapping;
    private $labelDelimiterLeft;
    private $labelDelimiterRight;
    private $log;
    private $errorCount;
    
    public function __construct ($config) {
        $this->dataFile = $config->dataFile;
        $this->fileMapping = $config->fileMapping;
        $this->labelDelimiterLeft = $config->labelDelimiterLeft;
        $this->labelDelimiterRight = $config->labelDelimiterRight;
        $this->log = array();
        $this->errorCount = 0;
    }
    
    public function generate () {
        $this->log = array();
        $this->errorCount = 0;
        list($textLabels, $texts) = $this->getReplaceArrays();
        if (count($textLabels) < 1) {
            $this->errorCount++;
        }
        foreach ($this->fileMapping as $inputFile => $outputFile) {
            $this->log[] = sprintf('INFO: Generating file %s from %s', $outputFile, $inputFile);
            $inputFile = ROOT_DIR . DIRECTORY_SEPARATOR . $inputFile;
            $outputFile = ROOT_DIR . DIRECTORY_SEPARATOR . $outputFile;
            if (!is_file($inputFile) || !is_readable($inputFile)) {
                $this->log[] = sprintf('ERROR: File %s does not exist or is not readable', $inputFile);
                $this->errorCount++;
                continue;
            }
            if (!is_dir(dirname($outputFile))) {
                if (!mkdir(dirname($outputFile), 0777, true)) {
                    $this->log[] = sprintf('ERROR: Could not create output folder %s', dirname($outputFile));
                    $this->errorCount++;
                    continue;
                }
            }
            if (!is_writable(dirname($outputFile))) {
                $this->log[] = sprintf('ERROR: Cannot create file in %s', dirname($outputFile));
                $this->errorCount++;
                continue;
            }
            $fhIn = fopen($inputFile, 'r');
            $tempFile = tempnam(dirname($outputFile), 'gen');
            $fhOut = fopen($tempFile, 'w');
            if (!is_resource($fhOut)) {
                $this->log[] = sprintf('ERROR: Temporary file %s could not be created.', $tempFile);
                $this->errorCount++;
                continue;
            }
            while (!feof($fhIn)) {
                $line = fgets($fhIn);
                $line = str_replace($textLabels, $texts, $line);
                fputs($fhOut, $line);
            }
            fclose($fhIn);
            if (!copy($tempFile, $outputFile)) {
                $this->log[] = sprintf('ERROR: Could not move temporary file %s to %s.', $tempFile, $outputFile);
                $this->errorCount++;
            }
            if (!@unlink($tempFile)) {
                $this->log[] = sprintf('WARNING: Could not delete temporary file %s', $tempFile);
            }
        }
        return $this->errorCount;
    }
                
    private function getReplaceArrays () {
        $textLabels = array();
        $texts = array();
        
        $lazyDAO = new LazyDAO($this->dataFile);
        $data = $lazyDAO->getTextLabels();
        
        if (!is_array($data)) {
            $this->log[] = sprintf('ERROR: %s', $data);
        } else {
            foreach ($data as $textLabel => $text) {
                if (is_array($text)) {
                    foreach ($text as $subTextLabel => $subText) {
                        $textLabels[] = sprintf('%s%s%s', $this->labelDelimiterLeft, $subTextLabel, $this->labelDelimiterRight);
                        $texts[] = $subText;
                    }
                } else {
                    $textLabels[] = sprintf('%s%s%s', $this->labelDelimiterLeft, $textLabel, $this->labelDelimiterRight);
                    $texts[] = $text;
                }
            }
        }
        
        return array($textLabels, $texts);
    }
                
    public function getLog () {
        return $this->log;
    }
    
}