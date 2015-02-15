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

Router\get_action('confirm-delete-user', function () {

    $userID = Request\int_param('user_id');
    $userToDelete = User::getNameForUserID($userID);

    if (!isset($userToDelete)) {
        Session\flash_error('User does not exist.');
        Response\redirect('?action=users');
    }

    if ($userToDelete === User::loggedIn()) {
        Session\flash_error('Cannot delete active user.');
        Response\redirect('?action=users');
    }

    Response\html(Template\layout('confirm-delete-user', [
        'page' => 'users',
        'username' => User::loggedIn(),
        'isAdmin' => User::isAdmin(),
        'userToDelete' => $userToDelete,
        'userID' => $userID
    ]));
});

Router\get_action('delete-user', function () {

    $userID = Request\int_param('user_id');
    $userToDelete = User::getNameForUserID($userID);
    if ($userToDelete === User::loggedIn()) {
        Session\flash_error('Cannot delete active user.');
        Response\redirect('?action=users');
    }

    if (User::delete($userID)) {
        Session\flash('User deleted successfully.');
    } else {
        Session\flash_error('Unable to delete user.');
    }

    Response\redirect('?action=users');
});
