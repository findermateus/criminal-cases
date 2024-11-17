<?php

namespace CriminalCases\App\Domain\UseCase;

use CriminalCases\App\Domain\DAO\CrimeDAO;
use CriminalCases\App\Domain\UseCase\Interface\UseCase;

class GetAllCrimesCase implements UseCase
{
    private CrimeDAO $crimeDAO;
    public function __construct()
    {
        $this->crimeDAO = new CrimeDAO();
    }
    public function execute()
    {
        $crimes = $this->crimeDAO->getAllCrimesWithSuspects();
        return $this->buildResponse($crimes);
    }
    private function buildResponse($crimes)
    {
        $cleanedCrimes = [];
        foreach ($crimes as $key => $crime) {
            $cleanedCrimes['crimes'][$crime['crime_id']] = [
                'crime_id' => $crime['crime_id'],
                'crime_title' => $crime['crime_title'],
                'crime_description' => $crime['crime_description'],
                'crime_solved' => $crime['crime_solved']
            ];
            if (empty($crime['suspect_id'])) {
                continue;
            }
            $cleanedCrimes['suspects'][$crime['suspect_id']] = [
                'suspect_id' => $crime['suspect_id'],
                'suspect_name' => $crime['suspect_name'],
                'suspect_age' => $crime['suspect_age'],
                'suspect_crime' => $crime['crime_id'],
                'isGuilty' => ($crime['guilty_id'] == $crime['suspect_id'])
            ];
        }
        return $cleanedCrimes;
    }
}
