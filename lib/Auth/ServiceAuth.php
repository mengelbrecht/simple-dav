<?php

namespace SimpleDAV\Auth;

use Sabre\DAV\Auth\Backend\AbstractBasic;
use SimpleDAV\Auth\Backend\ServiceBackend;
use SimpleDAV\Model\HashController;
use SimpleDAV\Hash\HashAlgorithm;

class ServiceAuth extends AbstractBasic {

    private $backend;
    private $hashController;
    private $hashAlgorithm;

    public function __construct(ServiceBackend $backend, HashController $hashController, HashAlgorithm $hashAlgorithm) {
        $this->backend = $backend;
        $this->hashController = $hashController;
        $this->hashAlgorithm = $hashAlgorithm;
    }

    protected function validateUserPass($username, $password) {
        $username = strtolower($username);
        $data = "$username:$password";

        if ($this->validateFromDB($username, $data))
            return true;

        if ($this->validateFromService($username, $password, $data))
            return true;

        return false;
    }

    private function validateFromDB($username, $data) {
        $hash = $this->hashController->hashForUser($username);
        return isset($hash) && $this->hashAlgorithm->verify($data, $hash);
    }

    private function validateFromService($username, $password, $data) {
        if (!$this->backend->authenticate($username, $password))
            return false;

        $hash = $this->hashAlgorithm->hash($data);
        $this->hashController->updateHashForUser($username, $hash);
        return true;
    }
}
