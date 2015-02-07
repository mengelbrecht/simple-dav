<?php

require_once __DIR__ . '/common.php';

use PicoFarad\Response;
use PicoFarad\Router;


Router\bootstrap(__DIR__ . '/lib/Controllers', 'Common', 'Overview', 'User', 'Users');

Router\notfound(function() {
    Response\redirect('?action=overview');
});
