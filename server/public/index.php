<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$routes = require_once __DIR__ . '/../src/routes.php';

$routes($app);

$app->run();
