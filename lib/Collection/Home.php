<?php

namespace SimpleDAV\Collection;

use Sabre\DAV\Auth\Plugin as AuthPlugin;
use Sabre\DAV\Collection;
use Sabre\DAV\FS;

class Home extends Collection {

    protected $homePath;
    protected $authPlugin;

    function __construct(AuthPlugin $authPlugin, $homePath) {
        $this->authPlugin = $authPlugin;
        $this->homePath = $homePath;
    }

    function getChildren() {
        $user = $this->authPlugin->getCurrentUser();
        if (!isset($user)) {
            return [];
        }

        $userPath = $this->homePath . '/' . $user;

        if (!file_exists($userPath)) {
            \mkdir($userPath, 0700, true);
        }

        return [new FS\Directory($userPath)];
    }

    function getName() {
        return 'home';
    }

}
