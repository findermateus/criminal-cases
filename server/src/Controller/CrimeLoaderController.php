<?php

namespace CriminalCases\App\Controller;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use CriminalCases\App\Domain\UseCase\GetAllCrimesCase;

class CrimeLoaderController
{
    public function loadAllCrimes(Request $request, Response $response)
    {
        $crimeCase = new GetAllCrimesCase();
        $crimes = $crimeCase->execute();
        $response->getBody()->write(json_encode($crimes));
        return $response;
    }
}
