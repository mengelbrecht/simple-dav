<?php

namespace SimpleDAV\Hash;

interface HashAlgorithm {
    function hash($data);

    function verify($data, $hash);
}
