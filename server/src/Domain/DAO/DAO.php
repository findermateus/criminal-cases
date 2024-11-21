<?php

namespace CriminalCases\App\Domain\DAO;

use PDO;

class DAO
{
    protected PDO $pdo;
    public function __construct(PDO $connection)
    {
        $this->pdo = $connection;
    }
}
