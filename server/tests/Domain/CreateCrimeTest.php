<?php

namespace CriminalCases\Tests\Domain;

use CriminalCases\App\Domain\DAO\CrimeDAODatabase;
use CriminalCases\App\Domain\Repository\CrimeRepositoryDatabase;
use CriminalCases\App\Domain\UseCase\CreateCrime;

beforeEach(function () {
    $pdo = new \PDO("sqlite::memory:");
    $pdo->exec("CREATE TABLE crime (
        crime_id INTEGER PRIMARY KEY AUTOINCREMENT,
        crime_title VARCHAR(255) NOT NULL,
        crime_description VARCHAR(255) NOT NULL,
        crime_solved BOOLEAN NOT NULL DEFAULT FALSE
    )");
    $this->pdo = $pdo;
});

test("It should create a new crime", function () {
    $crimeRepository = new CrimeRepositoryDatabase($this->pdo);
    $createCrime = new CreateCrime($crimeRepository);
    $crime = $createCrime->execute(['title' => 'Robbery', 'description' => 'Robbery of a bank']);
    expect($crime['crime_id'])->toBeInt();
    expect($crime['crime_title'])->toBe('Robbery');
    expect($crime['crime_description'])->toBe('Robbery of a bank');
    expect($crime['crime_solved'])->toBe(false);
});

test("It should not create a new crime with invalid arguments", function ($args) {
    $crimeRepository = new CrimeRepositoryDatabase($this->pdo);
    $createCrime = new CreateCrime($crimeRepository);
    $createCrime->execute($args);
})->with([
    [
        ['title' => 'Robbery', 'description' => ''],
        ['title' => '', 'description' => 'Robbery of a bank'],
    ]
])->throws(\Exception::class, "Invalid arguments");
