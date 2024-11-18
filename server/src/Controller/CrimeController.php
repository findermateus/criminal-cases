<?php

namespace CriminalCases\App\Controller;

use CriminalCases\App\Domain\DAO\CrimeDAODatabase;
use CriminalCases\App\Domain\Repository\CrimeRepositoryDatabase;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use CriminalCases\App\Domain\UseCase\GetAllCrimesCase;
use CriminalCases\App\Domain\UseCase\CreateCrimeCase;

class CrimeController
{
    public function loadAllCrimes(Request $request, Response $response)
    {
        $crimeDAO = new CrimeDAODatabase();
        $crimeCase = new GetAllCrimesCase($crimeDAO);
        $crimes = $crimeCase->execute();
        $response->getBody()->write(json_encode($crimes));
        return $response;
    }
    public function createCrime(Request $request, Response $response)
    {
        $post = $request->getParsedBody();
        $crimeRepository = new CrimeRepositoryDatabase();
        $crimeCase = new CreateCrimeCase($post, $crimeRepository);
        $crimeId = $crimeCase->execute();
        $response->getBody()->write(json_encode(['crimeId' => $crimeId]));
        return $response;
    }
}
