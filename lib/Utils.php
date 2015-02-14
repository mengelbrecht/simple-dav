<?php

namespace SimpleDAV;

class Utils {

    public static function escape($data) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8', false);
    }

    public static function flashIfSet($html) {
        if (!isset($_SESSION['flash_message'])) {
            return '';
        }

        $flash = sprintf($html, self::escape($_SESSION['flash_message']));
        unset($_SESSION['flash_message']);
        return $flash;
    }

    public static function flashErrorIfSet($html) {
        if (!isset($_SESSION['flash_error_message'])) {
            return '';
        }

        $flash = sprintf($html, self::escape($_SESSION['flash_error_message']));
        unset($_SESSION['flash_error_message']);
        return $flash;
    }

}
