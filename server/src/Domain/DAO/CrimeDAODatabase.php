<?php

namespace CriminalCases\App\Domain\DAO;

use CriminalCases\App\Domain\Interfaces\CrimeDAO;
use PDO;

class CrimeDAODatabase extends DAO implements CrimeDAO
{
    public function getAllCrimesWithSuspects(): array
    {
        $sql = "SELECT crime.crime_id, crime.crime_title, crime.crime_description, crime.crime_solved, crime.guilty_id, ";
        $sql .= "suspect.suspect_id, suspect.suspect_name, suspect.suspect_age ";
        $sql .= "FROM crime ";
        $sql .= "LEFT JOIN suspect ON suspect.suspect_crime = crime.crime_id;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
