<?php
namespace LazyCMS\Utils;

class FileSystemUtil {

    public function recursiveCopy ($src, $target) {
        $success = true;
        if (is_dir($src)) {
            @mkdir($target, 0777, true);
            $objects = scandir($src);
            if(sizeof($objects) > 0) {
                foreach( $objects as $file ) {
                    if($file == "." || $file == "..") {
                        continue;
                    }
                    if(is_dir($src.DIRECTORY_SEPARATOR.$file )) {
                        $this->recursiveCopy($src.DIRECTORY_SEPARATOR.$file, $target.DIRECTORY_SEPARATOR.$file);
                    }
                    else {
                        $success = $success && copy($src.DIRECTORY_SEPARATOR.$file, $target.DIRECTORY_SEPARATOR.$file);
                    }
                }
            }
        }
        else if(is_file($src)) {
            return copy($src, $target);
        }
        else {
            // Wat?
            $success = false;
        }
        return $success;
    }

}