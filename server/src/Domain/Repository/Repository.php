<?php

namespace CriminalCases\App\Domain\Repository;

use CriminalCases\App\Infra\Connection;
use PDO;

class Repository
{
    protected PDO $pdo;
    public function __construct()
    {
        $this->pdo = Connection::getConnection();
    }
}
