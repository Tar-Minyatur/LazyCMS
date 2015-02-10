<?php
class LazyDAO {
    
    private $dataFile;
    
    public function __construct ($dataFile) {
        $this->dataFile = $dataFile;
    }
    
    public function getTextLabels () {
        $return = null;
        $json = file_get_contents($this->dataFile);
        if ($json === false) {
            $return = sprintf('Could not read from file %s! Make sure it exists and is readable!', $this->dataFile);
        } else {
            $return = json_decode($json, true, 2);
            if (is_null($return)) {
                $return = sprintf('JSON in file %s is invalid!', $this->dataFile);
            }            
        }
        return $return;
    }
    
}