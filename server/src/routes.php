<?php

namespace CriminalCases\App;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use CriminalCases\App\Controller\CrimeLoaderController;

return function (App $app) {
    $app->group('/cases', function (RouteCollectorProxy $group) {
        $group->get('/all', CrimeLoaderController::class . ':loadAllCrimes');
    });
};
