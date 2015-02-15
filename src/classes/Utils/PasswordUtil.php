<?php
namespace LazyCMS\Utils;

class PasswordUtil {

    static $instance;

    private $cost;

    function __construct($cost = 10) {
        $this->cost = $cost;
    }

    public function hashPassword ($password) {
        if (function_exists('password_hash' && defined('PASSWORD_DEFAULT'))) {
            $passwordHash = password_hash($password, PASSWORD_DEFAUlT);
        } else {
            $salt = $this->getRandomSalt();
            $passwordHash = crypt($password, $salt);
        }
        return $passwordHash;
    }

    private function getRandomSalt () {
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
        $salt = sprintf("$2a$%02d$%s", $this->cost, $salt);
        return $salt;
    }

    public function passwordMatchesHash ($passwordHash, $password) {
        if (function_exists('password_verify')) {
            $result = password_verify($password, $passwordHash);
        } else {
            if (function_exists('hash_equals')) {
                $result = hash_equals($passwordHash, crypt($password, $passwordHash));
            }
            else {
                $result = (crypt($password, $passwordHash) == $passwordHash);
            }
        }
        return $result;
    }

}