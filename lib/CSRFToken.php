<?php

namespace SimpleDAV;

class CSRFToken {

    const TIMEOUT = 1200; // 20 Minutes
    const ID = 'csrf';

    private static function clearExpired() {
        if (!isset($_SESSION[self::ID])) {
            return;
        }

        $expiration = \time() - self::TIMEOUT;
        foreach ($_SESSION[self::ID] as $token => $time) {
            if ($time < $expiration) {
                unset($_SESSION[self::ID][$token]);
            }
        }
    }

    public static function generate() {
        if (empty($_SESSION[self::ID])) {
            $_SESSION[self::ID] = [];
        }

        $token = \hash('sha256', \mcrypt_create_iv(16, \MCRYPT_DEV_URANDOM));
        $_SESSION[self::ID][$token] = \time();
        return $token;
    }

    public static function check($token) {
        self::clearExpired();

        if (!isset($token)) {
            return false;
        }

        $expiration = time() - self::TIMEOUT;
        return isset($_SESSION[self::ID][$token]) && $_SESSION[self::ID][$token] >= $expiration;
    }

}
