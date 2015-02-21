<?php
namespace LazyCMS;

class LazyGenerator {
    
    private $dataDirectory;
    private $fileMapping;
    private $labelDelimiterLeft;
    private $labelDelimiterRight;
    private $labelScopeOperator;
    private $labelDefaultDelimiterLeft;
    private $labelDefaultDelimiterRight;
    private $labelRegEx;
    private $log;
    private $errorCount;

    public function __construct ($config) {
        $this->dataDirectory = $config->dataDirectory;
        $this->fileMapping = $config->fileMapping;
        $this->labelDelimiterLeft = $config->labelDelimiterLeft;
        $this->labelDelimiterRight = $config->labelDelimiterRight;
        $this->labelScopeOperator = $config->labelScopeOperator;
        $this->labelDefaultDelimiterLeft = $config->labelDefaultDelimiterLeft;
        $this->labelDefaultDelimiterRight = $config->labelDefaultDelimiterRight;
        $this->labelRegEx = $config->labelRegEx;
        $this->log = array();
        $this->errorCount = 0;
    }
    
    public function generate () {
        $this->log = array();
        $this->errorCount = 0;
        $globalFields = $this->getTextLabelsForFile();
        foreach ($this->fileMapping as $inputFile => $outputFile) {
            $this->log[] = sprintf('INFO: Generating file %s from %s', $outputFile, $inputFile);
            if (!$this->checkFileAvailability($inputFile, $outputFile)) {
                continue;
            }
            $lineNumber = 1;
            $fhIn = fopen($inputFile, 'r');
            $tempFile = tempnam(dirname($outputFile), 'gen');
            $fhOut = fopen($tempFile, 'w');
            if (!is_resource($fhOut)) {
                $this->log[] = sprintf('ERROR: Temporary file %s could not be created.', $tempFile);
                $this->errorCount++;
                continue;
            }
            $fields = $this->getTextLabelsForFile($inputFile);
            while (!feof($fhIn)) {
                $line = fgets($fhIn);
                $line = $this->performLabelReplacement($globalFields, $fields, $inputFile, $lineNumber, $line);
                fputs($fhOut, $line);
                $lineNumber++;
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

    private function getTextLabelsForFile ($dataFile = null) {
        $fields = array();

        if (is_null($dataFile)) {
            $targetFile = $this->dataDirectory . DIRECTORY_SEPARATOR . LazyExtractor::SCOPE_GLOBAL . '.json';
        } else {
            $targetFile = $this->dataDirectory . DIRECTORY_SEPARATOR . LazyDAO::getScopeNameForFile($dataFile) . '.json';
        }

        if (!is_file($targetFile) || !is_readable($targetFile)) {
            $this->log[] = sprintf('WARNING: Cannot read from data file %s', $targetFile);
            $this->errorCount++;
        } else {
            $fields = json_decode(file_get_contents($targetFile), 2);
            if (!is_array($fields)) {
                $this->log[] = sprintf('ERROR: Data in file %s is invalid', $targetFile);
                $this->errorCount++;
            }
        }
        
        return $fields;
    }

    private function checkFileAvailability($inputFile, $outputFile) {
        if (!is_file($inputFile) || !is_readable($inputFile)) {
            $this->log[] = sprintf('ERROR: File %s does not exist or is not readable', $inputFile);
            $this->errorCount++;
            return false;
        }
        if (!is_dir(dirname($outputFile))) {
            if (!mkdir(dirname($outputFile), 0777, true)) {
                $this->log[] = sprintf('ERROR: Could not create output folder %s', dirname($outputFile));
                $this->errorCount++;
                return false;
            }
        }
        if (!is_writable(dirname($outputFile))) {
            $this->log[] = sprintf('ERROR: Cannot create file in %s', dirname($outputFile));
            $this->errorCount++;
            return false;
        }
        return true;
    }

    private function performLabelReplacement(array $globalFields, array $fields, $inputFile, $lineNumber, $line) {
        $line = preg_replace_callback($this->labelRegEx,
            function ($matches) use ($globalFields, $fields, $inputFile, $lineNumber) {
                $value = null;
                if (array_key_exists('scope', $matches) && ($matches['scope'] == LazyExtractor::SCOPE_GLOBAL)) {
                    if (array_key_exists($matches['label'], $globalFields)) {
                        $value = $globalFields[$matches['label']];
                    }
                } else {
                    if (array_key_exists($matches['label'], $fields)) {
                        $value = $fields[$matches['label']];
                    } else if (array_key_exists($matches['label'], $globalFields)) {
                        $this->log[] = sprintf('WARNING: File %s contains unscoped label %s on line %d, which only exists in global',
                            $inputFile, $matches['label'], $lineNumber);
                        $value = $globalFields[$matches['label']];
                    } else {
                        $this->log[] = sprintf('WARNING: File %s contains unknown label %s on line %d',
                            $inputFile, $matches['label'], $lineNumber);
                    }
                }
                if (is_null($value) && array_key_exists('default', $matches)) {
                    $value = $matches['default'];
                    $this->log[] = sprintf('         -> Replacing %s in file %s (line %d) with its default value',
                        $matches['label'], $inputFile, $lineNumber);
                }
                return is_null($value) ? '' : $value;

            }, $line);
        return $line;
    }

    public function getLog () {
        return $this->log;
    }

}