<?php

namespace CriminalCases\App\Domain\Repository;

use PDO;

class Repository
{
    protected PDO $pdo;
    public function __construct(PDO $connection)
    {
        $this->pdo = $connection;
    }
}
