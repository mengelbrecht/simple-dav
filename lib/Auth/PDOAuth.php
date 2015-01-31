<?php

namespace SimpleDAV\Auth;

use Sabre\DAV\Auth\Backend\AbstractBasic;
use SimpleDAV\Hash\HashFactory;
use SimpleDAV\Model\User;

class PDOAuth extends AbstractBasic {

    protected function validateUserPass($username, $password) {
        $hash = User::getHash($username);
        return isset($hash) && HashFactory::createHashAlgorithm()->verify($password, $hash);
    }
}
