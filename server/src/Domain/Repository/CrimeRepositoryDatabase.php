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
    
    public function deleteCrime(int $crimeId): bool
    {
        $this->deleteSuspectsFromCrime($crimeId);
        $sql = "DELETE FROM crime WHERE crime_id = :crime_id;";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'crime_id' => $crimeId,
        ]);
    }

    private function deleteSuspectsFromCrime(int $crimeId): bool
    {
        $sql = "DELETE FROM suspect WHERE suspect_crime = :crime_id;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'crime_id' => $crimeId,
        ]);
        return $stmt->rowCount();
    }
}
