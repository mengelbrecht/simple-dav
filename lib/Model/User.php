<?php

namespace SimpleDAV\Model;

use PicoDb\Database;
use PicoFarad\Session;

class User {

    public static function loggedIn() {
        return $_SESSION['loggedin'];
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

    public static function create($username, $hash) {
        $db = Database::get('db');
        $db->table('users')->insert(['username' => $username, 'digesta1' => $hash]);
        $db->table('principals')->insert(['uri' => "principals/$username/calendar-proxy-read"]);
        $db->table('principals')->insert(['uri' => "principals/$username/calendar-proxy-write"]);
        $db->table('addressbooks')->insert([
            'principaluri' => "principals/$username",
            'displayname' => 'Contacts',
            'uri' => 'default',
            'description' => '',
            'synctoken' => '1'
        ]);
        $db->table('calendars')->insert([
            'principaluri' => "principals/$username",
            'displayname' => 'Contacts',
            'uri' => 'default',
            'components' => 'VEVENT,VTODO',
            'synctoken' => '1',
            'transparent' => '0'
        ]);
    }
}
