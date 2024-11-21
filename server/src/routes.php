<?php

namespace CriminalCases\App;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use CriminalCases\App\Controller\CrimeController;

return function (App $app) {

    $app->group('/cases', function (RouteCollectorProxy $group) {
        $group->get('/all', CrimeController::class . ':loadAllCrimes');
        $group->post('/add', CrimeController::class . ':createCrime');
        $group->delete('/{id}', CrimeController::class . ':deleteCrime');
        $group->put('/{id}/solve', CrimeController::class . ':solveCrime');
    });
};
