<?php

namespace SimpleDAV\Model;

interface HashController {

    function hashForUser($username);

    function updateHashForUser($username, $hash);

}
