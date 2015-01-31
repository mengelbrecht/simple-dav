<?php

namespace SimpleDAV\Hash;

class HashFactory {
    public static function createHashAlgorithm() {
        return new Blowfish();
    }
}
