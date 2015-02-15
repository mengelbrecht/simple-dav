<?php

namespace SimpleDAV\Auth;

use Sabre\DAV\Auth\Backend\AbstractBasic;
use SimpleDAV\Model\User;

class PDOAuth extends AbstractBasic {

    protected function validateUserPass($username, $password) {
        return User::validate($username, $password);
    }
}
