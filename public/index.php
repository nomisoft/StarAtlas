<?php

require __DIR__ . '/../vendor/autoload.php';

use StarAtlas\App;

$app = new App();

$routes = array(
    array('^/$','index'),
    array('^/planets/?$','planets'),
    array('^/planets/([A-Za-z]+)/?$','planet'),
    array('^/stars/?$','stars'),
    array('^/stars/([0-9]+)/?$','star'),
    array('^/moon/?$','moon'),
    array('^/sun/?$','sun'),
);

$app->addRoutes($routes);

$app->run(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
