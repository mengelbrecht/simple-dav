<?php

namespace SimpleDAV\Controllers;

use PicoFarad\Response;
use PicoFarad\Router;
use PicoFarad\Template;
use SimpleDAV\Model\User;


Router\get_action('overview', function() {
    Response\html(Template\layout('overview', [
        'page' => 'overview',
        'username' => User::loggedIn(),
        'isAdmin' => User::isAdmin(),
    ]));
});
