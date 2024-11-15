<?php

namespace CriminalCases\App\Domain\UseCase;

use CriminalCases\App\Domain\DAO\CrimeDAO;

class CrimeCase
{
    private CrimeDAO $crimeDAO;
    public function __construct()
    {
        $this->crimeDAO = new CrimeDAO();
    }
    public function getCrimes()
    {
        return $this->crimeDAO->getAllCrimesWithSuspects();
    }
}
