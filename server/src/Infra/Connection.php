<?php

namespace CriminalCases\App\Infra;

use PDO;

interface Connection
{
    public function getConnection(): PDO;
}
