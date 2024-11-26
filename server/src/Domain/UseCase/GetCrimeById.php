<?php

namespace CriminalCases\App\Domain\UseCase;

use CriminalCases\App\Domain\Interfaces\CrimeRepository;
use CriminalCases\App\Domain\Entity\Crime;

class GetCrimeById
{
    private CrimeRepository $crimeRepository;
    public function __construct(CrimeRepository $crimeRepository)
    {
        $this->crimeRepository = $crimeRepository;
    }

    public function execute($crimeId)
    {
        $crime = $this->crimeRepository->getCrimeById($crimeId);
        $this->verifyCrime($crime);
        return $this->buildResponse($crime);
    }
    private function buildResponse($crime)
    {
        return [
            'crime_id' => $crime->getCrimeId(),
            'crime_title' => $crime->getCrimeTitle(),
            'crime_description' => $crime->getCrimeDescription(),
            'crime_solved' => $crime->getCrimeSolved(),
            'guilty_id' => $crime->getGuiltyId()
        ];
    }
    private function verifyCrime(mixed $crime)
    {
        if (!$crime) {
            throw new \Exception('Crime not found');
        }
    }
}
