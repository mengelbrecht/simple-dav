<?php

namespace SimpleDAV\Model;

class DB implements HashController {
    private $pdo;

    function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    function hashForUser($username) {
        $user = $this->getUser($username);
        return isset($user) ? $user->getHash() : null;
    }

    public function getUser($username) {
        return User::get($this->pdo, $username);
    }

    function updateHashForUser($username, $hash) {
        if ($this->existsUser($username))
            $this->getUser($username)->setHash($hash);
        else
            $this->createUser($username, $hash);
    }

    public function existsUser($username) {
        return User::exists($this->pdo, $username);
    }

    public function createUser($username, $hash) {
        return User::create($this->pdo, $username, $hash);
    }
}
