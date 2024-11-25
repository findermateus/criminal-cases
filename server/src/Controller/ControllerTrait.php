<?php

namespace CriminalCases\App\Controller;

use CriminalCases\App\Infra\PostgreeSQLConnectionAdapter;

trait ControllerTrait
{
    protected PostgreeSQLConnectionAdapter $connection;
    public function __construct()
    {
        $this->connection = new PostgreeSQLConnectionAdapter();
    }
    protected function getConnection()
    {
        return $this->connection->getConnection();
    }
}
