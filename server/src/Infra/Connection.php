<?php

namespace CriminalCases\App\Infra;

use PDO;
use Exception;
use PDOException;
use Dotenv\Dotenv;

class Connection
{
    private static Dotenv $dotenv;
    
    public static function getConnection()
    {
        self::getEnvironment();
        $host = $_ENV['DB_HOST'];
        $dbName = $_ENV['DB_NAME'];
        $port = $_ENV['DB_PORT'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $dsn = self::getDSN($host, $dbName, $port);

        try {
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }
    private static function getDSN(string $host, string $dbName, $port)
    {
        return "pgsql:host=$host;port=$port;dbname=$dbName";
    }
    private static function getEnvironment()
    {
        self::$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        self::$dotenv->load();
    }
}
