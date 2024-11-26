<?php

namespace CriminalCases\App\Domain\UseCase;

use CriminalCases\App\Domain\Entity\Crime;
use CriminalCases\App\Domain\Interfaces\CrimeRepository;
use CriminalCases\App\Domain\Interfaces\UseCase;

class CreateCrime implements UseCase
{
    private Crime $crime;
    private CrimeRepository $crimeRepository;

    public function __construct(CrimeRepository $crimeRepository)
    {
        $this->crimeRepository = $crimeRepository;
    }

    public function execute(mixed $data = null): mixed
    {
        $this->setCrime($data);
        $this->crime = $this->crimeRepository->createCrime($this->crime);
        return $this->buildResponse($this->crime);
    }
    private function buildResponse($crime)
    {
        return [
            'crime_id' => $crime->getCrimeId(),
            'crime_title' => $crime->getCrimeTitle(),
            'crime_description' => $crime->getCrimeDescription(),
            'crime_solved' => $crime->getCrimeSolved(),
        ];
    }

    private function setCrime($post)
    {
        if (empty($post['title']) || empty($post['description'])) {
            throw new \Exception('Invalid arguments');
        }
        $this->crime = new Crime();
        $this->crime->setCrimeTitle($post['title']);
        $this->crime->setCrimeDescription($post['description']);
    }
}
