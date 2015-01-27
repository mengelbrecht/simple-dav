<?php

namespace SimpleDAV\Hash;

class Blowfish implements HashAlgorithm {

    public function hash($data) {
        return password_hash($data, PASSWORD_BCRYPT);
    }

    public function verify($data, $hash) {
        return password_verify($data, $hash);
    }
}
