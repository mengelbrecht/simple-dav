<?php

namespace SimpleDAV\Controllers;

use PicoFarad\Request;
use PicoFarad\Response;
use PicoFarad\Router;
use PicoFarad\Template;
use SimpleDAV\CSRFToken;
use SimpleDAV\Model\User;
use SimpleDAV\Hash\HashFactory;


Router\get_action('logout', function () {
    User::logout();
    Response\redirect('?action=login');
});

Router\get_action('login', function () {

    if (User::loggedIn())
        Response\redirect('?action=overview');

    Response\html(Template\load('signin', [
        'error' => null,
        'values' => ['csrf' => CSRFToken::generate()]
    ]));
});

Router\post_action('login', function () {

    $values = Request\values();
    if (!CSRFToken::check($values['csrf'])) {
        Response\html(Template\load('signin', [
            'error' => 'Invalid session or timeout.',
            'values' => $values + ['csrf' => CSRFToken::generate()],
        ]));
    }

    $hash = User::getHash($values['username']);

    if (!HashFactory::createHashAlgorithm()->verify($values['password'], $hash)) {
        Response\html(Template\load('signin', [
            'error' => 'Invalid username or password.',
            'values' => $values
        ]));
    }

    $_SESSION['loggedin'] = $values['username'];
    Response\redirect('?action=overview');
});
