<?php

namespace SimpleDAV\Auth\Backend;

/**
 * Implements authentication via an IMAP server.
 * @package SimpleDAV\Auth\Backend
 */
class IMAP implements ServiceBackend {

    private $server;

    function __construct($server) {
        $this->server = $server;
    }

    function authenticate($username, $password) {
        try {
            $imap = imap_open($this->server, $username, $password, OP_HALFOPEN);
            imap_close($imap);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}
