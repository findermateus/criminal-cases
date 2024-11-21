<?php

namespace CriminalCases\App\Controller;

use CriminalCases\App\Infra\MySQLConnectionAdapter;

trait ControllerTrait
{
    protected MySQLConnectionAdapter $connection;
    public function __construct()
    {
        $this->connection = new MySQLConnectionAdapter();
    }
    protected function getConnection()
    {
        return $this->connection->getConnection();
    }
}
