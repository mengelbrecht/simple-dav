<?php

namespace SimpleDAV\Model;

abstract class Role {

    const ADMIN = 0;
    const REGULAR = 1;

    public static function asStringList() {
        return ['Regular', 'Admin'];
    }

    public static function fromString($role) {
        switch (\strtolower($role)) {
            case 'admin':
                return self::ADMIN;
            case 'regular':
            default:
                return self::REGULAR;
        }
    }
}
