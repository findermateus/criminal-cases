<?php

namespace CriminalCases\App\Domain\Interfaces;

interface CrimeDAO
{
    public function getAllCrimesWithSuspects(): array;
}
