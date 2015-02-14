<?php

namespace SimpleDAV;

class CSRFToken {

    const TIMEOUT = 1200; // 20 Minutes

    private static function clearExpired() {
        if (!isset($_SESSION['csrf'])) {
            return;
        }

        $expiration = \time() - self::TIMEOUT;
        foreach ($_SESSION['csrf'] as $token => $time) {
            if ($time < $expiration) {
                unset($_SESSION['csrf'][$token]);
            }
        }
    }

    public static function generate() {
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = [];
        }

        $token = \hash('sha256', \mcrypt_create_iv(16, \MCRYPT_DEV_URANDOM));
        $_SESSION['csrf'][$token] = \time();
        return $token;
    }

    public static function check($token) {
        self::clearExpired();

        if (!isset($token)) {
            return false;
        }

        $expiration = time() - self::TIMEOUT;
        return isset($_SESSION['csrf'][$token]) && $_SESSION['csrf'][$token] >= $expiration;
    }

}
