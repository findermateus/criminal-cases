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
        if (!$rows) {
            throw new Exception("Failed to solve the crime");
        }
        return json_encode(['message' => 'Successfully solve the crime']);
    }
}
