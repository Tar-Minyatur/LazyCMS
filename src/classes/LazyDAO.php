<?php
namespace LazyCMS;

class LazyDAO {
    
    private $dataDirectory;
    
    public function __construct ($dataDirectory) {
        $this->dataDirectory = $dataDirectory;
    }

    public function getDataFiles ($directory = null) {
        if (is_null($directory)) {
            $directory = $this->dataDirectory;
        }
        $files = array();
        if (is_dir($directory)) {
            foreach (scandir($directory) as $object) {
                $path = $directory . DIRECTORY_SEPARATOR . $object;
                if (is_file($path) && (substr($object, -5) == '.json')) {
                    $files[] = $path;
                }
                else if (is_dir($path) && ($object !== '.') && ($object !== '..')) {
                    $files = array_merge($files, $this->getDataFiles($path));
                }
            }
        }
        return $files;
    }

    public function getTextLabels () {
        $return = null;
        $json = file_get_contents($this->dataDirectory);
        if ($json === false) {
            $return = sprintf('Could not read from file %s! Make sure it exists and is readable!', $this->dataDirectory);
        } else {
            $return = json_decode($json, true, 3);
            if (is_null($return)) {
                $return = sprintf('JSON in file %s is invalid!', $this->dataDirectory);
            }
        }
        return $return;
    }

    public static function getScopeNameForFile($inputFile) {
        $fileName = str_replace(ROOT_DIR, '', $inputFile);
        if ($fileName{0} === '/') {
            $fileName = substr($fileName, 1);
        } else if (substr($fileName, 1, 2) === ':\\') {
            $fileName = substr($fileName, 3);
        }
        return $fileName;
    }
    
}