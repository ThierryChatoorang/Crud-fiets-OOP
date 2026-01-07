<?php
/**
 * DatabaseManagerTest.php
 * Auteur: [Jouw naam]
 * Unit tests voor DatabaseManager class
 */

namespace CrudFietsOOP\Tests;

use PHPUnit\Framework\TestCase;
use CrudFietsOOP\DatabaseManager;
use CrudFietsOOP\Fiets;
use PDO;

class DatabaseManagerTest extends TestCase {
    private DatabaseManager $db;

    // Setup: wordt voor elke test uitgevoerd
    protected function setUp(): void {
        $this->db = new DatabaseManager("localhost", "root", "", "fietsenmaker", "fietsen");
    }

    // Test 1: Object wordt aangemaakt
    public function testConstructorCreatesObject(): void {
        $this->assertInstanceOf(DatabaseManager::class, $this->db);
    }

    // Test 2: Connectie is PDO object
    public function testGetConnectionReturnsPDO(): void {
        $conn = $this->db->getConnection();
        $this->assertInstanceOf(PDO::class, $conn);
    }

    // Test 3: getData geeft array terug
    public function testGetDataReturnsArray(): void {
        $data = $this->db->getData();
        $this->assertIsArray($data);
    }

    // Test 4: Fiets toevoegen werkt (INSERT)
    public function testInsertRecord(): void {
        $fiets = new Fiets([
            'merk' => 'TestMerk',
            'type' => 'TestType',
            'prijs' => 999.99,
            'foto' => 'test.jpg'
        ]);
        
        $result = $this->db->insertRecord($fiets);
        $this->assertTrue($result);
        
        // Cleanup: verwijder test record
        $data = $this->db->getData();
        $lastId = end($data)['id'];
        $this->db->deleteRecord($lastId);
    }

    // Test 5: Fiets ophalen op basis van ID (READ)
    public function testGetRecord(): void {
        // Voeg test fiets toe
        $testFiets = new Fiets([
            'merk' => 'GetTest',
            'type' => 'GetType',
            'prijs' => 750,
            'foto' => 'get.jpg'
        ]);
        $this->db->insertRecord($testFiets);
        
        $data = $this->db->getData();
        $insertedId = end($data)['id'];
        
        // Haal fiets op
        $record = $this->db->getRecord($insertedId);
        
        $this->assertIsArray($record);
        $this->assertEquals('GetTest', $record['merk']);
        
        // Cleanup
        $this->db->deleteRecord($insertedId);
    }

    // Test 6: Fiets updaten werkt (UPDATE)
    public function testUpdateRecord(): void {
        // Voeg fiets toe
        $fiets = new Fiets([
            'merk' => 'UpdateTest',
            'type' => 'OldType',
            'prijs' => 600,
            'foto' => 'old.jpg'
        ]);
        $this->db->insertRecord($fiets);
        
        $data = $this->db->getData();
        $id = end($data)['id'];
        
        // Update fiets
        $updatedFiets = new Fiets([
            'id' => $id,
            'merk' => 'UpdateTest',
            'type' => 'NewType',
            'prijs' => 700,
            'foto' => 'new.jpg'
        ]);
        $result = $this->db->updateRecord($updatedFiets);
        
        $this->assertTrue($result);
        
        // Controleer of update gelukt is
        $record = $this->db->getRecord($id);
        $this->assertEquals('NewType', $record['type']);
        
        // Cleanup
        $this->db->deleteRecord($id);
    }

    // Test 7: Fiets verwijderen werkt (DELETE)
    public function testDeleteRecord(): void {
        // Voeg fiets toe
        $fiets = new Fiets([
            'merk' => 'DeleteTest',
            'type' => 'ToDelete',
            'prijs' => 400,
            'foto' => ''
        ]);
        $this->db->insertRecord($fiets);
        
        $data = $this->db->getData();
        $id = end($data)['id'];
        
        // Verwijder fiets
        $result = $this->db->deleteRecord($id);
        $this->assertTrue($result);
        
        // Check of weg is
        $record = $this->db->getRecord($id);
        $this->assertNull($record);
    }

    // Test 8: Niet-bestaand ID retourneert null
    public function testGetRecordMetNietBestaandId(): void {
        $record = $this->db->getRecord(999999);
        $this->assertNull($record);
    }
}