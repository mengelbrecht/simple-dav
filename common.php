<?php

require_once __DIR__ . '/vendor/autoload.php';

if (file_exists(__DIR__ . '/config.php'))
    require_once __DIR__ . '/config.php';

// Set default configuration
defined('IMAP_SERVER') or define('IMAP_SERVER', '{localhost:143/novalidate-cert}INBOX');
defined('DATABASE_FILE') or define('DATABASE_FILE', 'data/db.sqlite');

PicoDb\Database::bootstrap('db', function() {

    $db = new PicoDb\Database(array(
        'driver' => 'sqlite',
        'filename' => DATABASE_FILE
    ));
    $db->getConnection()->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    if ($db->schema()->check(Schema\Version)) {
        return $db;
    }
    else {
        die('Unable to migrate database schema.');
    }
});
