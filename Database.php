<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'biopalmer';
    private $user = 'postgres';
    private $password = 'root';
    public $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("pgsql:host={$this->host};dbname={$this->dbname}", $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>
