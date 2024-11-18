<?php

namespace CriminalCases\App\Domain\UseCase;

use CriminalCases\App\Domain\Entity\Crime;
use CriminalCases\App\Domain\Repository\CrimeRepository;

class CreateCrimeCase
{
    private $crime;
    public function __construct($post)
    {
        $this->setCrime($post);
    }
    public function execute()
    {
        $crimeRepository = new CrimeRepository();
        return $crimeRepository->createCrime($this->crime);
    }
    private function setCrime($post)
    {
        $this->crime = new Crime();
        $this->crime->setCrimeTitle($post['title']);
        $this->crime->setCrimeDescription($post['description']);
    }
}
