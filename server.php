<?php

require_once __DIR__ . '/common.php';

date_default_timezone_set('UTC');

/** Map PHP errors to exceptions to send a proper response back to the client (HTTP/1.1 500). */
function exception_error_handler($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

set_error_handler('exception_error_handler');

$pdo = PicoDb\Database::get('db')->getConnection();

$principalBackend = new \Sabre\DAVACL\PrincipalBackend\PDO($pdo);
$cardDAVBackend = new \Sabre\CardDAV\Backend\PDO($pdo);
$calDAVBackend = new \Sabre\CalDAV\Backend\PDO($pdo);
$lockBackend = new \Sabre\DAV\Locks\Backend\File(LOCKDB_FILE);
$storageBackend = new Sabre\DAV\PropertyStorage\Backend\PDO($pdo);

$authPlugin = new Sabre\DAV\Auth\Plugin(new \SimpleDAV\Auth\PDOAuth(), 'SimpleDAV');

/** Top level directories of the WebDAV server. */
$nodes = [
    new \Sabre\CalDAV\Principal\Collection($principalBackend),
    new \Sabre\CalDAV\CalendarRoot($principalBackend, $calDAVBackend),
    new \Sabre\CardDAV\AddressBookRoot($principalBackend, $cardDAVBackend),
    new \SimpleDAV\Collection\Home($authPlugin, WEBDAV_DIRECTORY),
];

$server = new \Sabre\DAV\Server($nodes);
$server->setBaseUri(BASE_DIRECTORY . DIRECTORY_SEPARATOR . basename(__FILE__));
$server->addPlugin($authPlugin);
$server->addPlugin(new \Sabre\DAVACL\Plugin());
$server->addPlugin(new \Sabre\CalDAV\Plugin());
$server->addPlugin(new \Sabre\CalDAV\Notifications\Plugin());
$server->addPlugin(new \Sabre\CalDAV\Schedule\Plugin());
$server->addPlugin(new \Sabre\CalDAV\Subscriptions\Plugin());
$server->addPlugin(new \Sabre\CardDAV\Plugin());
$server->addPlugin(new \Sabre\DAV\Browser\Plugin());
$server->addPlugin(new \Sabre\DAV\Browser\GuessContentType());
$server->addPlugin(new \Sabre\DAV\Locks\Plugin($lockBackend));
$server->addPlugin(new \Sabre\DAV\Mount\Plugin());
$server->addPlugin(new \Sabre\DAV\PartialUpdate\Plugin());
$server->addPlugin(new \Sabre\DAV\PropertyStorage\Plugin($storageBackend));
$server->addPlugin(new \Sabre\DAV\Sync\Plugin());
$server->addPlugin(new \Sabre\DAV\TemporaryFileFilterPlugin(TEMP_DIRECTORY));

$server->exec();
