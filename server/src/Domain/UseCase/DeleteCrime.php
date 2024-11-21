<?php

namespace CriminalCases\App\Domain\UseCase;

use CriminalCases\App\Domain\Interfaces\UseCase;
use CriminalCases\App\Domain\Interfaces\CrimeRepository;
use Exception;

class DeleteCrime implements UseCase
{
    private int $crimeId;
    private CrimeRepository $crimeRepository;

    public function __construct(CrimeRepository $crimeRepository)
    {
        $this->crimeRepository = $crimeRepository;
    }

    public function execute(mixed $crimeId = null): mixed
    {
        $result = $this->crimeRepository->deleteCrime($crimeId);
        return $this->buildResponse($result);
    }

    private function buildResponse(bool $result)
    {
        if (!$result) {
            throw new Exception("Failed to delete crime");
        }
        return json_encode(['message' => 'Crime deleted successfully']);
    }
}
