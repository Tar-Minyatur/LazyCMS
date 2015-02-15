<?php
namespace LazyCMS\Utils;

class ArrayAsObjectWrapper {

    private $data;
    private $hasUppercaseKeys;

    public function __construct(array &$data, $hasUpperCaseKeys = false) {
        $this->data = &$data;
        $this->hasUppercaseKeys = $hasUpperCaseKeys;
    }

    public function __get ($var) {
        $return = null;
        if ($this->hasUppercaseKeys) {
            $var = strtoupper($var);
        }
        if (isset($this->data[$var])) {
            $return = $this->data[$var];
        }
        return $return;
    }

    public function __isset ($var) {
        if ($this->hasUppercaseKeys) {
            $var = strtoupper($var);
        }
        return isset($this->data[$var]);
    }
}