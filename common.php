<?php

require_once __DIR__ . '/vendor/autoload.php';

if (file_exists(__DIR__ . '/config.php'))
    require_once __DIR__ . '/config.php';

// Set default configuration
function getBaseDirectory() {
    $dir = $_SERVER['PHP_SELF'];
    while (strrpos($dir, '.php'))
        $dir = dirname($dir);
    return $dir;
}

define('BASE_DIRECTORY', getBaseDirectory());
define('ROOT_DIRECTORY', __DIR__);
define('DATA_DIRECTORY', ROOT_DIRECTORY . DIRECTORY_SEPARATOR . 'data');
define('WEBDAV_DIRECTORY', DATA_DIRECTORY . DIRECTORY_SEPARATOR . 'files');
define('TEMP_DIRECTORY', DATA_DIRECTORY . DIRECTORY_SEPARATOR . 'temp');
define('LOCKDB_FILE', TEMP_DIRECTORY . DIRECTORY_SEPARATOR . 'locksdb');

defined('DB_FILE') or define('DB_FILE', DATA_DIRECTORY . DIRECTORY_SEPARATOR . 'db.sqlite');

if (version_compare(PHP_VERSION, '5.5.0', '<'))
    die('This software requires at least PHP 5.5.0');

if (!extension_loaded('pdo_sqlite'))
    die('PHP extension required: pdo_sqlite');

if (!is_writable(DATA_DIRECTORY))
    die('The data directory must be writeable by your web server user');

PicoDb\Database::bootstrap('db', function () {

    $db = new PicoDb\Database([
        'driver' => 'sqlite',
        'filename' => DB_FILE
    ]);

    $db->getConnection()->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    if ($db->schema()->check(Schema\Version))
        return $db;
    else
        die('Unable to migrate database schema.');
});
