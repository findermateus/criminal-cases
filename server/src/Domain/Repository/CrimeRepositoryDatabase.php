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

    public function solveCrime(int $crimeId, $crimeGuiltyId = null)
    {
        $sql = "UPDATE crime SET crime_solved = true ";
        if (is_numeric($crimeGuiltyId)) {
            $sql .= ", guilty_id = :guilty_id ";
        }
        $sql .= "WHERE crime_id = :crime_id;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'guilty_id' => $crimeGuiltyId,
            'crime_id' => $crimeId,
        ]);
        return $stmt->rowCount();
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
    public function getCrimeById($crimeId)
    {
        $sql = "SELECT * FROM crime WHERE crime_id = :crime_id;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'crime_id' => $crimeId,
        ]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
            return false;
        }
        $crime = Crime::create($crimeId, $result['crime_title'], $result['crime_description']);
        $crime->setCrimeSolved($result['crime_solved']);
        if (is_numeric($result['guilty_id'])) {
            $crime->setGuiltyId($result['guilty_id']);
        }
        return $crime;
    }
}
