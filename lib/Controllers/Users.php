<?php

namespace SimpleDAV\Controllers;

use PicoFarad\Request;
use PicoFarad\Response;
use PicoFarad\Router;
use PicoFarad\Session;
use PicoFarad\Template;
use SimpleDAV\Hash\HashFactory;
use SimpleDAV\Model\User;

Router\get_action('users', function() {
    Response\html(Template\layout('users', [
        'page' => 'users',
        'username' => User::loggedIn(),
        'isAdmin' => User::isAdmin(),
        'users' => User::getUsers(),
    ]));
});

Router\get_action('add-user', function() {
    Response\html(Template\layout('add-user', [
        'page' => 'users',
        'username' => User::loggedIn(),
        'isAdmin' => User::isAdmin(),
    ]));
});

Router\post_action('add-user', function () {

    $values = Request\values();
    $hash = HashFactory::createHashAlgorithm()->hash($values['password']);
    if (User::create($values['username'], $hash)) {
        Session\flash('User created successfully.');
    } else {
        Session\flash_error('Unable to create user.');
    }

    Response\redirect('?action=users');
});
