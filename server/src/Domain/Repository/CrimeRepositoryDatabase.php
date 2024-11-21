<?php

namespace CriminalCases\App\Domain\Repository;

use CriminalCases\App\Domain\Entity\Crime;
use CriminalCases\App\Domain\Interfaces\CrimeRepository;

class CrimeRepositoryDatabase extends Repository implements CrimeRepository
{
    public function createCrime(Crime $crime): Crime
    {
        $sql = "INSERT INTO crime (crime_title, crime_description, crime_solved) ";
        $sql .= "VALUES (:crime_title, :crime_description, false);";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'crime_title' => $crime->getCrimeTitle(),
            'crime_description' => $crime->getCrimeDescription(),
        ]);
        $crime->setCrimeId($this->pdo->lastInsertId());
        return $crime;
    }
}
