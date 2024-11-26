<?php

namespace CriminalCases\Tests\Domain;

use CriminalCases\App\Domain\DAO\CrimeDAODatabase;
use CriminalCases\App\Domain\Repository\CrimeRepositoryDatabase;
use CriminalCases\App\Domain\UseCase\GetAllCrimes;
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
    $this->pdo = $pdo;
});

test("It should return all crimes", function () {
    $crimeDAO = new CrimeDAODatabase($this->pdo);
    $getAllCrimes = new GetAllCrimes($crimeDAO);
    $crimes = $getAllCrimes->execute();
    expect($crimes)->toBeArray();
    expect(count($crimes['crimes']))->toBe(2);
    for ($i = 1; $i <= count($crimes['crimes']); $i++) {
        expect($crimes['crimes'][$i]['crime_id'])->toBeInt();
    }
});

test("It should return a specific crime", function () {
    $crimeRepository = new CrimeRepositoryDatabase($this->pdo);
    $getCrimeById = new GetCrimeById($crimeRepository);
    $crimeIdToBeSearched = 2;
    $result = $getCrimeById->execute($crimeIdToBeSearched);
    expect($result['crime_id'])->toBe($crimeIdToBeSearched);
    expect($result['crime_title'])->toBe('Murder');
});

test("It should not return a specific crime", function ($invalidId) {
    $crimeRepository = new CrimeRepositoryDatabase($this->pdo);
    $getCrimeById = new GetCrimeById($crimeRepository);
    $getCrimeById->execute($invalidId);
})->with(['-1', '999'])->throws(\Exception::class);
