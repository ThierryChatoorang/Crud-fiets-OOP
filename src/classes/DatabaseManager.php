<?php
/**
 * DatabaseManager.php
 * Auteur: [Jouw naam]
 * Class voor database operaties (CRUD)
 */

namespace CrudFietsOOP;

use PDO;
use PDOException;

class DatabaseManager {
    private PDO $conn;
    private string $tableName;

    // Constructor: maak database verbinding
    public function __construct(
        string $servername = "localhost",
        string $username = "root",
        string $password = "",
        string $dbname = "fietsenmaker",
        string $tableName = "fietsen"
    ) {
        $this->tableName = $tableName;
        $this->connectDb($servername, $username, $password, $dbname);
    }

    // Maak connectie met database
    private function connectDb(string $servername, string $username, string $password, string $dbname): void {
        try {
            $this->conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Connection failed: " . $e->getMessage());
        }
    }

    // Geef connectie terug
    public function getConnection(): PDO {
        return $this->conn;
    }

    // Haal alle fietsen op (READ)
    public function getData(): array {
        $sql = "SELECT * FROM {$this->tableName}";
        $query = $this->conn->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    // Haal 1 fiets op basis van ID (READ)
    public function getRecord(int $id): ?array {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = :id";
        $query = $this->conn->prepare($sql);
        $query->execute([':id' => $id]);
        $result = $query->fetch();
        return $result ?: null;
    }

    // Voeg nieuwe fiets toe (CREATE)
    public function insertRecord(Fiets $fiets): bool {
        $sql = "INSERT INTO {$this->tableName} (merk, type, prijs, foto) 
                VALUES (:merk, :type, :prijs, :foto)";
        
        $values = [
            ':merk' => $fiets->getMerk(),
            ':type' => $fiets->getType(),
            ':prijs' => $fiets->getPrijs(),
            ':foto' => $fiets->getFoto()
        ];

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($values);
            return $stmt->rowCount() === 1;
        } catch (PDOException $e) {
            error_log("Insert error: " . $e->getMessage());
            return false;
        }
    }

    // Wijzig bestaande fiets (UPDATE)
    public function updateRecord(Fiets $fiets): bool {
        $sql = "UPDATE {$this->tableName} 
                SET merk = :merk, type = :type, prijs = :prijs, foto = :foto 
                WHERE id = :id";

        $values = [
            ':merk' => $fiets->getMerk(),
            ':type' => $fiets->getType(),
            ':prijs' => $fiets->getPrijs(),
            ':foto' => $fiets->getFoto(),
            ':id' => $fiets->getId()
        ];

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($values);
            return $stmt->rowCount() === 1;
        } catch (PDOException $e) {
            error_log("Update error: " . $e->getMessage());
            return false;
        }
    }

    // Verwijder fiets (DELETE)
    public function deleteRecord(int $id): bool {
        $sql = "DELETE FROM {$this->tableName} WHERE id = :id";
        
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->rowCount() === 1;
        } catch (PDOException $e) {
            error_log("Delete error: " . $e->getMessage());
            return false;
        }
    }

    // Geef tabelnaam terug
    public function getTableName(): string {
        return $this->tableName;
    }
}