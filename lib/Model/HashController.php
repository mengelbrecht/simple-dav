<?php

namespace SimpleDAV\Model;

class HashController implements AbstractHashController {

    function hashForUser($username) {
        return User::getHash($username);
    }

    function updateHashForUser($username, $hash) {
        if (User::exists($username))
            User::updateHash($username, $hash);
        else
            User::create($username, $hash);
    }
}
