<?php

namespace SimpleDAV\Model;

use PicoDb\Database;
use PicoFarad\Session;
use SimpleDAV\Hash\HashFactory;

class User {

    public static function validate($username, $password) {
        $hash = self::getHash($username);
        return isset($hash) && HashFactory::createHashAlgorithm()->verify($password, $hash);
    }

    public static function loggedIn() {
        return empty($_SESSION['loggedin']) ? null : $_SESSION['loggedin'];
    }

    public static function principalUri() {
        $username = self::loggedIn();
        return isset($username) ? "principals/$username" : null;
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

    private static function createPrincipal($username, $email) {
        $db = Database::get('db');
        $db->table('principals')->insert([
            'uri' => "principals/$username",
            'displayname' => $username,
            'email' => $email,
        ]);
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

    public static function create($username, $password, $email = '', $role = Role::REGULAR) {
        if (self::exists($username)) {
            return false;
        }

        $db = Database::get('db');
        $hash = HashFactory::createHashAlgorithm()->hash($password);
        $db->table('users')->insert([
            'username' => $username,
            'digesta1' => $hash,
            'role' => $role
        ]);
        self::createPrincipal($username, $email);
        self::createAddressBook($username);
        self::createCalendar($username);
        return true;
    }

    public static function getUsers() {
        return Database::get('db')->table('users')->asc('username')->columns('id', 'username', 'role')->findAll();
    }

    private static function getNameAndCount($categoryName, $categoryIDName, $objectName) {
        $principalUri = self::principalUri();
        if (!isset($principalUri)) {
            return [];
        }

        $objects = Database::get('db')->table($categoryName)->equals('principaluri', $principalUri)->
                columns('id', 'displayname')->findAll();

        $map = [];
        foreach ($objects as $object) {
            $id = $object['id'];
            $name = $object['displayname'];
            $count = Database::get('db')->table($objectName)->equals($categoryIDName, $id)->count();
            $map[] = ['id' => $id, 'name' => $name, 'count' => $count];
        }

        return $map;
    }

    public static function getCalendars() {
        return self::getNameAndCount('calendars', 'calendarid', 'calendarobjects');
    }

    public static function getAddressBooks() {
        return self::getNameAndCount('addressbooks', 'addressbookid', 'cards');
    }

    public static function getNameForUserID($userID) {
        return Database::get('db')->table('users')->equals('id', $userID)->findOneColumn('username');
    }

    public static function delete($userID) {
        $username = self::getNameForUserID($userID);
        if (!isset($username)) {
            return false;
        }

        $db = Database::get('db');
        $principalUri = "principals/$username";
        self::deleteAddressBooks($db, $principalUri);
        self::deleteCalendars($db, $principalUri);
        self::deleteSchedulingData($db, $principalUri);
        self::deleteLocks($db, $principalUri);
        self::deletePropertyStorage($db, $principalUri);
        self::deletePrincipal($db, $principalUri);
        $db->table('users')->equals('id', $userID)->remove();
        return true;
    }

    private static function deleteAddressBooks($db, $principalUri) {
        $addressBookIDs = $db->table('addressbooks')->equals('principaluri', $principalUri)->findAllByColumn('id');
        if (empty($addressBookIDs)) {
            return;
        }
        $db->table('cards')->in('addressbookid', $addressBookIDs)->remove();
        $db->table('addressbookchanges')->in('addressbookid', $addressBookIDs)->remove();
        $db->table('addressbooks')->equals('principaluri', $principalUri)->remove();
    }

    public static function deleteCalendarByIDs($principalUri, array $calendarIDs) {
        $db = Database::get('db');
        $allowedIDs = $db->table('calendars')->equals('principaluri', $principalUri)->findAllByColumn('id');
        $ids = \array_intersect($calendarIDs, $allowedIDs);
        if (empty($ids)) {
            return true;
        }
        $db->table('calendars')->in('id', $ids)->remove();
        $db->table('calendarobjects')->in('calendarid', $ids)->remove();
        $db->table('calendarchanges')->in('calendarid', $ids)->remove();
        return true;
    }

    private static function deleteCalendars($db, $principalUri) {
        $calendarIDs = $db->table('calendars')->equals('principaluri', $principalUri)->findAllByColumn('id');
        self::deleteCalendarByIDs($principalUri, $calendarIDs);
        $db->table('calendarsubscriptions')->equals('principaluri', $principalUri)->remove();
    }

    private static function deleteSchedulingData($db, $principalUri) {
        $db->table('schedulingobjects')->equals('principaluri', $principalUri)->remove();
    }

    private static function deleteLocks($db, $principalUri) {
        // TODO
    }

    private static function deletePropertyStorage($db, $principalUri) {
        // TODO
    }

    private static function deletePrincipal($db, $principalUri) {
        $db->table('principals')->equals('uri', $principalUri)->remove();
        $db->table('principals')->equals('uri', "$principalUri/calendar-proxy-read")->remove();
        $db->table('principals')->equals('uri', "$principalUri/calendar-proxy-write")->remove();
    }

    public static function getCalendarForID($calendarID) {
        $principalUri = self::principalUri();
        if (!isset($principalUri)) {
            return null;
        }
        return Database::get('db')->table('calendars')->equals('principaluri', $principalUri)->equals('id', $calendarID)->findOneColumn('displayname');
    }

}
