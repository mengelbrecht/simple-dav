<?php

namespace SimpleDAV\Controllers;

use PicoFarad\Response;
use PicoFarad\Router;
use PicoFarad\Session;
use SimpleDAV\Model\User;


Router\before(function ($action) {

    Session\open(BASE_DIRECTORY, '', 0);

    if (!User::loggedIn() && $action !== 'login') {
        User::logout();
        Response\redirect('?action=login');
    }

    Response\csp([
        'media-src' => '*',
        'img-src' => '*',
        'style-src' => '*',
        'font-src' => '*',
    ]);
    Response\xframe();
    Response\xss();
    Response\nosniff();
});
