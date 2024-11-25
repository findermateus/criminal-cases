<?php

namespace CriminalCases\App\Controller;

use CriminalCases\App\Controller\ControllerTrait;
use CriminalCases\App\Domain\DAO\CrimeDAODatabase;
use CriminalCases\App\Domain\Repository\CrimeRepositoryDatabase;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use CriminalCases\App\Domain\UseCase\GetAllCrimes;
use CriminalCases\App\Domain\UseCase\CreateCrime;
use CriminalCases\App\Domain\UseCase\DeleteCrime;
use CriminalCases\App\Domain\UseCase\SolveCrime;
use CriminalCases\App\Domain\UseCase\GetCrimeById;

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
        $crimeCase = new CreateCrime($crimeRepository);
        $crimeId = $crimeCase->execute($post);
        $response->getBody()->write(json_encode(['crimeId' => $crimeId]));
        return $response;
    }

    public function deleteCrime(Request $request, Response $response, $args)
    {
        $crimeId = $args['id'];
        $crimeRepository = new CrimeRepositoryDatabase($this->getConnection());
        $crimeCase = new DeleteCrime($crimeRepository);
        $result = $crimeCase->execute($crimeId);
        $response->getBody()->write($result);
        return $response;
    }

    public function solveCrime(Request $request, Response $response, $args)
    {
        $post = json_decode($request->getBody(), true);
        $params = [
            'crimeId' => $args['id'],
            'crimeGuiltyId' => $post['crimeGuiltyId']
        ];
        $crimeRepository = new CrimeRepositoryDatabase($this->getConnection());
        $crimeCase = new SolveCrime($crimeRepository);
        $result = $crimeCase->execute($params);
        $response->getBody()->write($result);
        return $response;
    }
    public function loadCrimeById(Request $request, Response $response, $args)
    {
        $crimeId = $args['id'];
        $crimeRepository = new CrimeRepositoryDatabase($this->getConnection());
        $crimeCase = new GetCrimeById($crimeRepository);
        $result = $crimeCase->execute($crimeId);
        $response->getBody()->write(json_encode($result));
        return $response;
    }
}
