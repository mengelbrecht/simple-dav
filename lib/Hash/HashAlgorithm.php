<?php

namespace SimpleDAV\Hash;

interface HashAlgorithm {
    function hash($password);

    function verify($password, $hash);
}
