<?php


namespace App\Db;

use PDO,
PDOException,
Dotenv\Dotenv;

class Conn {
    private static $instance = null;
    private $connection;
    private function __construct()
    {
        if(!isset($_ENV['DB_HOST'])) {
            $dotenv = Dotenv::createImmutable(__DIR__.'/../../');
            $dotenv->load();
        }
        try {
            $this->connection = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}", $_ENV['DB_USER'], $_ENV['DB_PASS']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e) {
            throw new PDOException("Connection failed: " . $e->getMessage(), $e->getCode());
        }
    }

    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new Conn();
        }
        return self::$instance->connection;
    }
}