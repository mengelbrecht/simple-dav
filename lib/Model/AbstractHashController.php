<?php

namespace SimpleDAV\Model;

interface AbstractHashController {

    function hashForUser($username);

    function updateHashForUser($username, $hash);

}
