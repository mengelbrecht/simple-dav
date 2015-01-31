<?php

require_once __DIR__ . '/common.php';

$publicDir = 'public';
$tmpDir = 'tmpdata';
$rootPath = dirname(__FILE__);
$baseUri = '/' . basename($rootPath) . '/' . basename(__FILE__);
$homePath = $rootPath . '/' . $publicDir;

date_default_timezone_set('UTC');

/** Map PHP errors to exceptions to send a proper response back to the client (HTTP/1.1 500). */
function exception_error_handler($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

set_error_handler('exception_error_handler');

$pdo = PicoDb\Database::get('db')->getConnection();

$authBackend = new \SimpleDAV\Auth\ServiceAuth(
    new \SimpleDAV\Auth\Backend\IMAP(IMAP_SERVER),
    new \SimpleDAV\Model\HashController(),
    new \SimpleDAV\Hash\Blowfish());

$principalBackend = new \Sabre\DAVACL\PrincipalBackend\PDO($pdo);
$cardDAVBackend = new \Sabre\CardDAV\Backend\PDO($pdo);
$calDAVBackend = new \Sabre\CalDAV\Backend\PDO($pdo);
$lockBackend = new \Sabre\DAV\Locks\Backend\File($tmpDir . '/locksdb');

$authPlugin = new Sabre\DAV\Auth\Plugin($authBackend, 'SimpleDAV');

/** Top level directories of the WebDAV server. */
$nodes = [
    new \Sabre\CalDAV\Principal\Collection($principalBackend),
    new \Sabre\CalDAV\CalendarRoot($principalBackend, $calDAVBackend),
    new \Sabre\CardDAV\AddressBookRoot($principalBackend, $cardDAVBackend),
    new \SimpleDAV\Collection\Home($authPlugin, $homePath),
];

$server = new \Sabre\DAV\Server($nodes);
$server->setBaseUri($baseUri);
$server->addPlugin($authPlugin);
$server->addPlugin(new \Sabre\DAV\Browser\Plugin());
$server->addPlugin(new \Sabre\CalDAV\Plugin());
$server->addPlugin(new \Sabre\CardDAV\Plugin());
$server->addPlugin(new \Sabre\DAVACL\Plugin());
$server->addPlugin(new \Sabre\DAV\Sync\Plugin());
$server->addPlugin(new \Sabre\DAV\Locks\Plugin($lockBackend));
$server->addPlugin(new \Sabre\DAV\Browser\GuessContentType());
$server->addPlugin(new \Sabre\DAV\TemporaryFileFilterPlugin($tmpDir));

$server->exec();
