<?php

namespace CriminalCases\App\Domain\Interfaces;

use CriminalCases\App\Domain\Entity\Crime;

interface CrimeRepository
{

    public function createCrime(Crime $crime);

    public function deleteCrime(int $crimeId);

    public function solveCrime(int $crimeId, $crimeGuiltyId = null);
}
