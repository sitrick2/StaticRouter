<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controller.php';

use StaticRouter\StaticRouter;

function routes()
{
    StaticRouter::get('/', static function() {
        return '<h1>Hello World!</h1>';
    });

    StaticRouter::get('/index', 'Controller@index');
}