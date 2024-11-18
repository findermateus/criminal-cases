<?php

namespace CriminalCases\App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use CriminalCases\App\Domain\UseCase\GetAllCrimesCase;
use CriminalCases\App\Domain\UseCase\CreateCrimeCase;

class CrimeController
{
    public function loadAllCrimes(Request $request, Response $response)
    {
        $crimeCase = new GetAllCrimesCase();
        $crimes = $crimeCase->execute();
        $response->getBody()->write(json_encode($crimes));
        return $response;
    }
    public function createCrime(Request $request, Response $response)
    {
        $post = $request->getParsedBody();
        $crimeCase = new CreateCrimeCase($post);
        $crimeId = $crimeCase->execute();
        $response->getBody()->write(json_encode(['crimeId' => $crimeId]));
        return $response;
    }
}
