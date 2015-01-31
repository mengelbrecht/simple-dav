<?php

namespace SimpleDAV\Model;

class User {

    private $pdo;
    private $username;
    private $hash;

    private function __construct(\PDO $pdo, $username, $hash) {
        $this->pdo = $pdo;
        $this->username = $username;
        $this->hash = $hash;
    }

    public static function get(\PDO $pdo, $username) {
        $stmt = $pdo->prepare('SELECT digesta1 FROM users WHERE username = ? LIMIT 1');
        $stmt->execute(array($username));
        $result = $stmt->fetchAll();
        if (count($result) !== 1)
            return null;

        return new User($pdo, $username, $result[0]['digesta1']);
    }

    public static function create(\PDO $pdo, $username, $hash) {
        $user = new User($pdo, $username, $hash);
        $user->doCreate();
        return $user;
    }

    private function doCreate() {
        $stmt = $this->pdo->prepare('INSERT INTO users (username, digesta1) VALUES ("?", "?");');
        $stmt->execute(array($this->username, $this->hash));

        $this->createPrincipals();
        $this->addAddressBook();
        $this->addCalendar();
    }

    private function createPrincipals() {
        $stmt = $this->pdo->prepare('INSERT INTO principals (uri, displayname) VALUES ("principals/?", "?");');
        $stmt->execute(array($this->username, $this->username));

        // Enable support for calendar delegation
        $stmt = $this->pdo->prepare('INSERT INTO principals (uri) VALUES ("principals/?/calendar-proxy-read");');
        $stmt->execute(array($this->username));

        $stmt = $this->pdo->prepare('INSERT INTO principals (uri) VALUES ("principals/?/calendar-proxy-write");');
        $stmt->execute(array($this->username));
    }

    public function addAddressBook($addressBookName = 'Contacts') {
        $stmt = $this->pdo->prepare('INSERT INTO addressbooks (principaluri, displayname, uri, description, synctoken)
            VALUES ("principals/?", "?", "default", "", "1");');
        $stmt->execute(array($this->username, $addressBookName));
    }

    public function addCalendar($calendarName = 'Calendar') {
        $stmt = $this->pdo->prepare('INSERT INTO calendars (principaluri, displayname, uri, components, synctoken, transparent)
            VALUES ("principals/?", "?", "default", "VEVENT,VTODO", "1", "0");');
        $stmt->execute(array($this->username, $calendarName));
    }

    public static function exists(\PDO $pdo, $username) {
        $stmt = $pdo->prepare('SELECT username FROM users WHERE username = ? LIMIT 1');
        $stmt->execute(array($username));
        $result = $stmt->fetchAll();
        return count($result) === 1;
    }

    public function getHash() {
        return $this->hash;
    }

    public function setHash($hash) {
        $stmt = $this->pdo->prepare('UPDATE users SET digesta1 = ? WHERE username = ?');
        $stmt->execute(array($hash, $this->username));
    }
}
