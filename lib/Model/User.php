<?php

namespace SimpleDAV\Model;

use PicoDb\Database;
use PicoFarad\Session;

class User {

    public static function loggedIn() {
        return empty($_SESSION['loggedin']) ? null : $_SESSION['loggedin'];
    }

    public static function isAdmin() {
        $username = self::loggedIn();
        if (!isset($username)) {
            return false;
        }

        return Database::get('db')->table('users')->equals('username', $username)->findOneColumn('role') == Role::ADMIN;
    }

    public static function logout() {
        Session\close();
    }

    public static function exists($username) {
        return Database::get('db')->table('users')->equals('username', $username)->count() === 1;
    }

    public static function getHash($username) {
        return Database::get('db')->table('users')->equals('username', $username)->findOneColumn('digesta1');
    }

    public static function updateHash($username, $hash) {
        Database::get('db')->table('users')->equals('username', $username)->save(['digesta1' => $hash]);
    }

    private static function createPrincipal($username) {
        $db = Database::get('db');
        $db->table('principals')->insert(['uri' => "principals/$username/calendar-proxy-read"]);
        $db->table('principals')->insert(['uri' => "principals/$username/calendar-proxy-write"]);
    }

    private static function createAddressBook($username, $addressBook = 'Contacts') {
        $db = Database::get('db');
        $db->table('addressbooks')->insert([
            'principaluri' => "principals/$username",
            'displayname' => $addressBook,
            'uri' => 'default',
            'description' => '',
            'synctoken' => '1'
        ]);
    }

    private static function createCalendar($username, $calendarName = 'Calendar') {
        $db = Database::get('db');
        $db->table('calendars')->insert([
            'principaluri' => "principals/$username",
            'displayname' => $calendarName,
            'uri' => 'default',
            'components' => 'VEVENT,VTODO',
            'synctoken' => '1',
            'transparent' => '0'
        ]);
    }

    public static function create($username, $hash) {
        if (self::exists($username)) {
            return false;
        }

        $db = Database::get('db');
        $db->table('users')->insert(['username' => $username, 'digesta1' => $hash]);
        self::createPrincipal($username);
        self::createAddressBook($username);
        self::createCalendar($username);
        return true;
    }

    public static function getUsers() {
        return Database::get('db')->table('users')->asc('username')->columns('username', 'role')->findAll();
    }

    private static function getNameAndCount($categoryName, $categoryIDName, $objectName) {
        $username = self::loggedIn();
        if (!isset($username)) {
            return [];
        }

        $objects = Database::get('db')->table($categoryName)->equals('principaluri', "principals/$username")->
                columns('id', 'displayname')->findAll();

        $map = [];
        foreach ($objects as $object) {
            $id = $object['id'];
            $name = $object['displayname'];
            $count = Database::get('db')->table($objectName)->equals($categoryIDName, $id)->count();
            $map[$name] = $count;
        }

        return $map;
    }

    public static function getCalendars() {
        return self::getNameAndCount('calendars', 'calendarid', 'calendarobjects');
    }

    public static function getAddressBooks() {
        return self::getNameAndCount('addressbooks', 'addressbookid', 'cards');
    }

}
