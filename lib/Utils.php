<?php

namespace SimpleDAV;

class Utils {
    public static function escape($data) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8', false);
    }
}
