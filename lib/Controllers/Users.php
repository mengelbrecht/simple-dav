<?php

namespace SimpleDAV\Controllers;

use PicoFarad\Response;
use PicoFarad\Router;
use PicoFarad\Template;
use SimpleDAV\Model\User;


Router\get_action('users', function() {
    Response\html(Template\layout('users', [
        'page' => 'users',
        'username' => User::loggedIn(),
        'isAdmin' => User::isAdmin(),
        'users' => User::getUsers(),
    ]));
});
