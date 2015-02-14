<?php

namespace Schema;

use SimpleDAV\Hash\HashFactory;

const VERSION = 1;

function version_1(\PDO $pdo) {
    $pdo->exec('
        CREATE TABLE addressbooks (
            id INTEGER PRIMARY KEY ASC,
            principaluri TEXT,
            displayname TEXT,
            uri TEXT,
            description TEXT,
            synctoken INTEGER
        );
    ');

    $pdo->exec('
        CREATE TABLE cards (
            id INTEGER PRIMARY KEY ASC,
            addressbookid INTEGER,
            carddata BLOB,
            uri TEXT,
            lastmodified INTEGER,
            etag TEXT,
            size INTEGER
        );
    ');

    $pdo->exec('
        CREATE TABLE addressbookchanges (
            id INTEGER PRIMARY KEY ASC,
            uri TEXT,
            synctoken INTEGER,
            addressbookid INTEGER,
            operation INTEGER
        );
    ');

    $pdo->exec('CREATE INDEX addressbookid_synctoken ON addressbookchanges (addressbookid, synctoken);');

    $pdo->exec('
        CREATE TABLE calendarobjects (
            id INTEGER PRIMARY KEY ASC,
            calendardata BLOB,
            uri TEXT,
            calendarid INTEGER,
            lastmodified INTEGER,
            etag TEXT,
            size INTEGER,
            componenttype TEXT,
            firstoccurence INTEGER,
            lastoccurence INTEGER,
            uid TEXT
        );
    ');

    $pdo->exec('
        CREATE TABLE calendars (
            id INTEGER PRIMARY KEY ASC,
            principaluri TEXT,
            displayname TEXT,
            uri TEXT,
            synctoken INTEGER,
            description TEXT,
            calendarorder INTEGER,
            calendarcolor TEXT,
            timezone TEXT,
            components TEXT,
            transparent BOOL
        );
    ');

    $pdo->exec('
        CREATE TABLE calendarchanges (
            id INTEGER PRIMARY KEY ASC,
            uri TEXT,
            synctoken INTEGER,
            calendarid INTEGER,
            operation INTEGER
        );
    ');

    $pdo->exec('CREATE INDEX calendarid_synctoken ON calendarchanges (calendarid, synctoken);');

    $pdo->exec('
        CREATE TABLE calendarsubscriptions (
            id INTEGER PRIMARY KEY ASC,
            uri TEXT,
            principaluri TEXT,
            source TEXT,
            displayname TEXT,
            refreshrate TEXT,
            calendarorder INTEGER,
            calendarcolor TEXT,
            striptodos BOOL,
            stripalarms BOOL,
            stripattachments BOOL,
            lastmodified INTEGER
        );
    ');

    $pdo->exec('
        CREATE TABLE schedulingobjects (
            id INTEGER PRIMARY KEY ASC,
            principaluri TEXT,
            calendardata BLOB,
            uri TEXT,
            lastmodified INTEGER,
            etag TEXT,
            size INTEGER
        );
    ');

    $pdo->exec('CREATE INDEX principaluri_uri ON calendarsubscriptions (principaluri, uri);');

    $pdo->exec('
        CREATE TABLE locks (
            id INTEGER PRIMARY KEY ASC,
            owner TEXT,
            timeout INTEGER,
            created INTEGER,
            token TEXT,
            scope INTEGER,
            depth INTEGER,
            uri TEXT
        );
    ');

    $pdo->exec('
        CREATE TABLE principals (
            id INTEGER PRIMARY KEY ASC,
            uri TEXT,
            email TEXT,
            displayname TEXT,
            vcardurl TEXT,
            UNIQUE(uri)
        );
    ');

    $pdo->exec('
        CREATE TABLE groupmembers (
            id INTEGER PRIMARY KEY ASC,
            principal_id INTEGER,
            member_id INTEGER,
            UNIQUE(principal_id, member_id)
        );
    ');

    $pdo->exec('
        CREATE TABLE propertystorage (
            id INTEGER PRIMARY KEY ASC,
            path TEXT,
            name TEXT,
            value TEXT
        );
    ');

    $pdo->exec('CREATE UNIQUE INDEX path_property ON propertystorage (path, name);');

    $pdo->exec('
        CREATE TABLE users (
            id INTEGER PRIMARY KEY ASC,
            username TEXT,
            digesta1 TEXT,
            role INTEGER DEFAULT 1,
            UNIQUE(username)
        );
    ');

    $adminHash = HashFactory::createHashAlgorithm()->hash('admin');
    $pdo->exec('INSERT INTO users (username, digesta1, role) VALUES ("admin", "' . $adminHash . '", 0);');
    $pdo->exec('INSERT INTO principals (uri, displayname) VALUES ("principals/admin", "admin");');
    $pdo->exec('INSERT INTO principals (uri) VALUES ("principals/admin/calendar-proxy-read");');
    $pdo->exec('INSERT INTO principals (uri) VALUES ("principals/admin/calendar-proxy-write");');
}
