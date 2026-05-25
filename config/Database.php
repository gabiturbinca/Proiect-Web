<?php

class Database
{
    private static ?Database $instance = null;
    private PDO $connection;
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    private function __construct() {
        $dbHost = $_ENV['DB_HOST'];
        $dbPort = $_ENV['DB_PORT'];
        $dbName = $_ENV['DB_NAME'];
        $dbUser = $_ENV['DB_USER'];
        $dbPass = $_ENV['DB_PASS'];
        $dsn = "pgsql:host=$dbHost;port=$dbPort;dbname=$dbName";
        try {
            $this->connection = new PDO($dsn, $dbUser, $dbPass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }
    public function __clone() {
        throw new Exception("Not allowed to clone a singleton class.");
    }
    public function getConnection(): PDO {
        return $this->connection;
    }

}
?>