<?php

namespace Schema;

const Version = 1;

function version_1(\PDO $pdo) {
    $pdo->exec('
        CREATE TABLE addressbooks (
            id integer primary key asc,
            principaluri text,
            displayname text,
            uri text,
            description text,
            synctoken integer
        );
    ');

    $pdo->exec('
        CREATE TABLE cards (
            id integer primary key asc,
            addressbookid integer,
            carddata blob,
            uri text,
            lastmodified integer,
            etag text,
            size integer
        );
    ');

    $pdo->exec('
        CREATE TABLE addressbookchanges (
            id integer primary key asc,
            uri text,
            synctoken integer,
            addressbookid integer,
            operation integer
        );
    ');

    $pdo->exec('CREATE INDEX addressbookid_synctoken ON addressbookchanges (addressbookid, synctoken);');

    $pdo->exec('
        CREATE TABLE calendarobjects (
            id integer primary key asc,
            calendardata blob,
            uri text,
            calendarid integer,
            lastmodified integer,
            etag text,
            size integer,
            componenttype text,
            firstoccurence integer,
            lastoccurence integer,
            uid text
        );
    ');

    $pdo->exec('
        CREATE TABLE calendars (
            id integer primary key asc,
            principaluri text,
            displayname text,
            uri text,
            synctoken integer,
            description text,
            calendarorder integer,
            calendarcolor text,
            timezone text,
            components text,
            transparent bool
        );
    ');

    $pdo->exec('
        CREATE TABLE calendarchanges (
            id integer primary key asc,
            uri text,
            synctoken integer,
            calendarid integer,
            operation integer
        );
    ');

    $pdo->exec('CREATE INDEX calendarid_synctoken ON calendarchanges (calendarid, synctoken);');

    $pdo->exec('
        CREATE TABLE calendarsubscriptions (
            id integer primary key asc,
            uri text,
            principaluri text,
            source text,
            displayname text,
            refreshrate text,
            calendarorder integer,
            calendarcolor text,
            striptodos bool,
            stripalarms bool,
            stripattachments bool,
            lastmodified int
        );
    ');

    $pdo->exec('
        CREATE TABLE schedulingobjects (
            id integer primary key asc,
            principaluri text,
            calendardata blob,
            uri text,
            lastmodified integer,
            etag text,
            size integer
        );
    ');

    $pdo->exec('CREATE INDEX principaluri_uri ON calendarsubscriptions (principaluri, uri);');

    $pdo->exec('
        CREATE TABLE locks (
            id integer primary key asc,
            owner text,
            timeout integer,
            created integer,
            token text,
            scope integer,
            depth integer,
            uri text
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
            id integer primary key asc,
            path TEXT,
            name TEXT,
            value TEXT
        );
    ');

    $pdo->exec('CREATE UNIQUE INDEX path_property ON propertystorage (path, name);');

    $pdo->exec('
        CREATE TABLE users (
            id integer primary key asc,
            username TEXT,
            digesta1 TEXT,
            UNIQUE(username)
        );
    ');
}
