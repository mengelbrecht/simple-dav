<?php

namespace SimpleDAV\Controllers;

use PicoFarad\Request;
use PicoFarad\Response;
use PicoFarad\Router;
use PicoFarad\Session;
use PicoFarad\Template;
use SimpleDAV\Model\Role;
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
        'roles' => Role::asStringList()
    ]));
});

Router\post_action('add-user', function () {

    $values = Request\values();
    $role = Role::fromString($values['role']);
    if (User::create($values['username'], $values['password'], $values['email'], $role)) {
        Session\flash('User created successfully.');
    } else {
        Session\flash_error('Unable to create user.');
    }

    Response\redirect('?action=users');
});
