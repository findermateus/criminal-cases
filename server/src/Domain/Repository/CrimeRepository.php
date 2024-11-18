<?php

namespace CriminalCases\App\Domain\Repository;

use CriminalCases\App\Domain\Entity\Crime;

class CrimeRepository extends Repository
{
    public function createCrime(Crime $crime)
    {
        $sql = "INSERT INTO crime (crime_title, crime_description, crime_solved) ";
        $sql .= "VALUES (:crime_title, :crime_description, false);";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'crime_title' => $crime->getCrimeTitle(),
            'crime_description' => $crime->getCrimeDescription(),
        ]);
        return $this->pdo->lastInsertId();
    }
}
