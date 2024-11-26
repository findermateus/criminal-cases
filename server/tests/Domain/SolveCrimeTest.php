<?php

use CriminalCases\App\Domain\Repository\CrimeRepositoryDatabase;
use CriminalCases\App\Domain\UseCase\GetCrimeById;
use CriminalCases\App\Domain\UseCase\SolveCrime;

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $pdo = new \PDO("sqlite::memory:");
    $pdo->exec("CREATE TABLE crime (
        crime_id INTEGER PRIMARY KEY AUTOINCREMENT,
        crime_title VARCHAR(255) NOT NULL,
        crime_description VARCHAR(255) NOT NULL,
        crime_solved BOOLEAN NOT NULL,
        guilty_id INTEGER,
        FOREIGN KEY(guilty_id) REFERENCES suspect(suspect_id)
    )");
    $pdo->exec("CREATE TABLE suspect (
        suspect_id INTEGER PRIMARY KEY,
        suspect_name VARCHAR(255) NOT NULL,
        suspect_age INTEGER NOT NULL,
        suspect_crime INTEGER,
        FOREIGN KEY(suspect_crime) REFERENCES crime(crime_id)
    )");
    $pdo->exec("INSERT INTO crime (crime_title, crime_description, crime_solved) VALUES (
        'Robbery',
        'Robbery of a bank',
        false
    ), (
        'Murder',
        'Murder of a person',
        false
    )");
    $pdo->exec("INSERT INTO suspect (suspect_id, suspect_name, suspect_age, suspect_crime) VALUES (
        1,
        'John Doe',
        30,
        1
    )");
    $this->pdo = $pdo;
});

test("Should solve a crime with a suspect", function () {
    $crimeRepository = new CrimeRepositoryDatabase($this->pdo);
    $solveCrime = new SolveCrime($crimeRepository);
    $result = json_decode($solveCrime->execute(['crimeId' => 1, 'crimeGuiltyId' => 1]), true);
    assertEquals("Successfully solved the crime", $result['message']);
    $getCrimeById = new GetCrimeById($crimeRepository);
    $crime = $getCrimeById->execute(1);
    assertEquals(true, $crime['crime_solved']);
});

test("Should solve a crime without a suspect", function () {
    $crimeRepository = new CrimeRepositoryDatabase($this->pdo);
    $solveCrime = new SolveCrime($crimeRepository);
    $result = json_decode($solveCrime->execute(['crimeId' => 1, 'crimeGuiltyId' => null]), true);
    assertEquals("Successfully solved the crime", $result['message']);
    $getCrimeById = new GetCrimeById($crimeRepository);
    $crime = $getCrimeById->execute(1);
    assertEquals(true, $crime['crime_solved']);
});

test("Should not solve a crime with a suspect that is not from the crime", function () {
    $crimeRepository = new CrimeRepositoryDatabase($this->pdo);
    $solveCrime = new SolveCrime($crimeRepository);
    json_decode($solveCrime->execute(['crimeId' => 2, 'crimeGuiltyId' => 1]), true);
})->throws(Exception::class, "Suspect ID is not from the crime");

test("Should not solve a case that does not exist", function ($crimeId) {
    $crimeRepository = new CrimeRepositoryDatabase($this->pdo);
    $solveCrime = new SolveCrime($crimeRepository);
    $solveCrime->execute(['crimeId' => $crimeId, 'crimeGuiltyId' => null]);
})->with([3, -1])->throws(Exception::class, "Crime not found");
