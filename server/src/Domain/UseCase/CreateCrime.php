<?php

namespace CriminalCases\App\Domain\UseCase;

use CriminalCases\App\Domain\Entity\Crime;
use CriminalCases\App\Domain\Interfaces\CrimeRepository;
use CriminalCases\App\Domain\Interfaces\UseCase;

class CreateCrime implements UseCase
{
    private Crime $crime;
    private CrimeRepository $crimeRepository;

    public function __construct($post, CrimeRepository $crimeRepository)
    {
        $this->crimeRepository = $crimeRepository;
        $this->setCrime($post);
    }

    public function execute(mixed $data = null): mixed
    {
        $this->crime = $this->crimeRepository->createCrime($this->crime);
        return $this->crime->getCrimeId();
    }

    private function setCrime($post)
    {
        $this->crime = new Crime();
        $this->crime->setCrimeTitle($post['title']);
        $this->crime->setCrimeDescription($post['description']);
    }
}
