<?php

namespace CriminalCases\Tests\Domain;

use CriminalCases\App\Domain\Repository\CrimeRepositoryDatabase;
use CriminalCases\App\Domain\UseCase\DeleteCrime;
use CriminalCases\App\Domain\UseCase\GetCrimeById;

beforeEach(function () {
    $pdo = new \PDO("sqlite::memory:");
    $pdo->exec("CREATE TABLE crime (
            crime_id INTEGER PRIMARY KEY AUTOINCREMENT,
            crime_title VARCHAR(255) NOT NULL,
            crime_description VARCHAR(255) NOT NULL,
            crime_solved BOOLEAN NOT NULL,
            guilty_id INTEGER,
            suspect_id INTEGER,
            FOREIGN KEY(guilty_id) REFERENCES suspect(suspect_id)
        )");
    $pdo->exec("CREATE TABLE suspect (
            suspect_id INTEGER PRIMARY KEY AUTOINCREMENT,
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
    $pdo->exec("INSERT INTO suspect (suspect_name, suspect_age, suspect_crime) VALUES (
            'John Doe',
            30,
            2
        )");
    $this->pdo = $pdo;
});

test("It should delete a specific crime", function () {
    $crimeRepository = new CrimeRepositoryDatabase($this->pdo);
    $deleteCrime = new DeleteCrime($crimeRepository);
    $crimeIdToBeDeleted = 1;
    $result = json_decode($deleteCrime->execute($crimeIdToBeDeleted), true);
    expect($result['message'])->toBe('Crime deleted successfully');
    $getCrimeById = new GetCrimeById($crimeRepository);
    $getCrimeById->execute($crimeIdToBeDeleted);
})->throws(\Exception::class, 'Crime not found');

// test("It should delete all suspects of a crime", function (){
// vai precisar do repository de suspeitos.
// });