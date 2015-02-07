<?php

namespace SimpleDAV\Controllers;

use PicoFarad\Response;
use PicoFarad\Router;
use PicoFarad\Session;
use PicoFarad\Template;
use SimpleDAV\Model\User;


Router\before(function ($action) {

    Session\open(BASE_DIRECTORY, '', 0);

    $loggedIn = User::loggedIn();
    if (!isset($loggedIn) && $action !== 'login') {
        User::logout();
        Response\redirect('?action=login');
    }

    $adminActions = ['users', 'adduser'];
    if (!User::isAdmin() && in_array($action, $adminActions)) {
        Response\html(Template\layout('error', [
            'page' => '',
            'username' => User::loggedIn(),
            'isAdmin' => false,
            'error' => "Permission denied"
        ]));
    }

    Response\csp([
        'media-src' => '*',
        'img-src' => '*',
        'style-src' => [
            "'self'",
            'https://fonts.googleapis.com',
            'https://maxcdn.bootstrapcdn.com',
        ],
        'font-src' => [
            "'self'",
            'https://fonts.gstatic.com',
            'https://maxcdn.bootstrapcdn.com'
        ],
        'script-src' => [
            "'self'",
            'https://code.jquery.com',
            'https://maxcdn.bootstrapcdn.com'
        ]
    ]);
    Response\xframe();
    Response\xss();
    Response\nosniff();
});
