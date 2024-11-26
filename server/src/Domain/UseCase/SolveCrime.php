<?php

namespace CriminalCases\App\Domain\UseCase;

use CriminalCases\App\Domain\Interfaces\CrimeRepository;
use CriminalCases\App\Domain\Interfaces\UseCase;
use Exception;

class SolveCrime implements UseCase
{
    private CrimeRepository $crimeRepository;

    public function __construct(CrimeRepository $crimeRepository)
    {
        $this->crimeRepository = $crimeRepository;
    }

    public function execute(mixed $crimeData = null): mixed
    {
        $rows = $this->crimeRepository->solveCrime($crimeData['crimeId'], $crimeData['crimeGuiltyId']);
        if ($rows === false) {
            throw new Exception("Suspect ID is not from the crime");
        }
        if ($rows === 0) {
            throw new Exception("Crime not found");
        }
        return json_encode(['message' => 'Successfully solved the crime']);
    }
}
