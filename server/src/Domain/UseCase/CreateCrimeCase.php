<?php

namespace CriminalCases\App\Domain\UseCase;

use CriminalCases\App\Domain\Entity\Crime;
use CriminalCases\App\Domain\Interfaces\CrimeRepository;

class CreateCrimeCase
{
    private Crime $crime;
    private CrimeRepository $crimeRepository;
    public function __construct($post, CrimeRepository $crimeRepository)
    {
        $this->crimeRepository = $crimeRepository;
        $this->setCrime($post);
    }
    public function execute()
    {
        return $this->crimeRepository->createCrime($this->crime);
    }
    private function setCrime($post)
    {
        $this->crime = new Crime();
        $this->crime->setCrimeTitle($post['title']);
        $this->crime->setCrimeDescription($post['description']);
    }
}
