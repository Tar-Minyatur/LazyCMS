<?php
spl_autoload_register(function ($class) {
    $fileName = 'classes/' . $class . '.class.php';
    if (file_exists($fileName)) {
        require($fileName);
    }
});