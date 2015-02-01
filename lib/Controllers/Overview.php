<?php

namespace SimpleDAV\Controllers;

use PicoFarad\Response;
use PicoFarad\Router;
use PicoFarad\Template;
use SimpleDAV\Model\User;


Router\get_action('overview', function() {
    Response\html(Template\load('overview', [
        'values' => [
            'username' => User::loggedIn()
        ]
    ]));
});
