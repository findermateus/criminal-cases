<?php

namespace CriminalCases\App\Domain\Entity;

class Crime
{
    private int $crimeId;
    private string $crime_title;
    private string $crime_description;
    private bool $crime_solved = false;
    private ?int $guilty_id = null;

    public static function create(int $crimeId, string $crime_title, string $crime_description): Crime
    {
        $crime = new Crime();
        $crime->setCrimeId($crimeId);
        $crime->setCrimeTitle($crime_title);
        $crime->setCrimeDescription($crime_description);
        return $crime;
    }
    public function getCrimeTitle(): string
    {
        return $this->crime_title;
    }
    public function getCrimeId(): int
    {
        return $this->crimeId;
    }
    public function getCrimeDescription(): string
    {
        return $this->crime_description;
    }
    public function getCrimeSolved(): bool
    {
        return $this->crime_solved;
    }
    public function getGuiltyId(): ?int
    {
        return $this->guilty_id;
    }
    public function setCrimeTitle(string $crime_title): void
    {
        $this->crime_title = $crime_title;
    }
    public function setCrimeDescription(string $crime_description): void
    {
        $this->crime_description = $crime_description;
    }
    public function setCrimeSolved(bool $crime_solved): void
    {
        $this->crime_solved = $crime_solved;
    }
    public function setGuiltyId(int $guilty_id): void
    {
        $this->guilty_id = $guilty_id;
    }
    public function setCrimeId(int $crimeId): void
    {
        $this->crimeId = $crimeId;
    }
}
