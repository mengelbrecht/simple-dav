<?php

namespace SimpleDAV\Auth\Backend;

/**
 * This interface provides the ability to implement custom authentication backends which can rely on a service to
 * perform authentication. The service backend could e.g. call an IMAP server for authentication or perform a lookup
 * from a database.
 * @package SimpleDAV\Auth\Backend
 */
interface ServiceBackend {
    /**
     * Tries to authenticate the user with the specified password.
     * Returns true if the user was successfully authenticated with the specified password. Otherwise false is returned.
     *
     * @param $username
     * @param $password
     * @return bool
     */
    function authenticate($username, $password);
}
