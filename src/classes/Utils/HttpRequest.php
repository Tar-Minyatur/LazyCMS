<?php
namespace LazyCMS\Utils;

class HttpRequest {

    private $getParams;
    private $postParams;
    private $sessionVars;
    private $serverVars;

    public function __construct(array $serverVars, array $getParams, array $postParams, array &$sessionVars) {
        $this->getParams = new ArrayAsObjectWrapper($getParams);
        $this->postParams = new ArrayAsObjectWrapper($postParams);
        $this->serverVars = new ArrayAsObjectWrapper($serverVars, true);
        $this->sessionVars = new ArrayAsObjectWrapper($sessionVars);
    }

    public function __get ($var) {
        $target = null;
        if ($var == 'get') { $target = $this->getParams; }
        else if ($var == 'session') { $target = $this->sessionVars; }
        else if ($var == 'server') { $target = $this->serverVars; }
        else if ($var == 'post') { $target = $this->postParams; }
        return $target;
    }

    public function __isset ($var) {
        return (($var == 'get') || ($var == 'post') || ($var == 'server') || ($var == 'session'));
    }

    public static function getDefaultInstance () {
        return new HttpRequest($_SERVER, $_GET, $_POST, $_SESSION);
    }

}

