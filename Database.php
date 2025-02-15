<?php

class Database {
    private $pdo;

    public function __construct($host, $dbname, $user, $password) {
        $dsn = "pgsql:host=$host;dbname=$dbname";
        try {
            $this->pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage() . "\n");
        }
    }

    public function getConnection() {
        return $this->pdo;
    }

    public function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            surname VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL
        );";

        $this->pdo->exec($sql);
        echo "Table 'users' created successfully.\n";
    }
}

?>