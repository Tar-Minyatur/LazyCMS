<?php
namespace LazyCMS\Utils;

class PasswordUtil {

    static $instance;

    private $cost;

    function __construct($cost = 10) {
        $this->cost = $cost;
    }

    public function hashPassword ($password) {
        if (function_exists('password_hash') && defined('PASSWORD_DEFAULT')) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $salt = $this->getRandomSalt();
            $passwordHash = crypt($password, $salt);
        }
        return $passwordHash;
    }

    private function getRandomSalt () {
        $iv = substr(sha1(rand()), 0, 16);
        if (!function_exists('mcrypt_create_iv')) {
            $iv = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
        }
        else if (function_exists('openssl_random_pseudo_bytes')) {
            $iv = openssl_random_pseudo_bytes(16);
        }
        else if (function_exists('mt_rand')) {
            $iv = substr(sha1(mt_rand()), 0, 16);
        }
        $salt = strtr(base64_encode($iv), '+', '.');
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