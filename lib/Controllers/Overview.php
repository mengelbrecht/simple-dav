<?php

namespace SimpleDAV\Controllers;

use PicoFarad\Response;
use PicoFarad\Router;
use PicoFarad\Template;


Router\get_action('overview', function() {
    Response\html(Template\load('overview', [
    ]));
});
