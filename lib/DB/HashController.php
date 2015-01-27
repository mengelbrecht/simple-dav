<?php

namespace SimpleDAV\DB;

interface HashController {

    function hashForUser($username);

    function updateHashForUser($username, $hash);

}
