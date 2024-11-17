<?php

namespace CriminalCases\App\Domain\DAO;

use CriminalCases\App\Infra\Connection;
use PDO;

class DAO
{
    protected PDO $pdo;
    public function __construct()
    {
        $this->pdo = Connection::getConnection();
    }
}
