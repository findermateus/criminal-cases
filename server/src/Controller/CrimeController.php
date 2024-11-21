<?php

namespace CriminalCases\App\Controller;

use CriminalCases\App\Controller\ControllerTrait;
use CriminalCases\App\Domain\DAO\CrimeDAODatabase;
use CriminalCases\App\Domain\Repository\CrimeRepositoryDatabase;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use CriminalCases\App\Domain\UseCase\GetAllCrimes;
use CriminalCases\App\Domain\UseCase\CreateCrime;

class CrimeController
{
    use ControllerTrait;
    public function loadAllCrimes(Request $request, Response $response)
    {
        $crimeDAO = new CrimeDAODatabase($this->getConnection());
        $crimeCase = new GetAllCrimes($crimeDAO);
        $crimes = $crimeCase->execute();
        $response->getBody()->write(json_encode($crimes));
        return $response;
    }
    public function createCrime(Request $request, Response $response)
    {
        $post = $request->getParsedBody();
        $crimeRepository = new CrimeRepositoryDatabase($this->getConnection());
        $crimeCase = new CreateCrime($post, $crimeRepository);
        $crimeId = $crimeCase->execute();
        $response->getBody()->write(json_encode(['crimeId' => $crimeId]));
        return $response;
    }
}
