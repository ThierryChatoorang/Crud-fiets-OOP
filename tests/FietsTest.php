<?php
/**
 * FietsTest.php
 * Auteur: [Jouw naam]
 * Unit tests voor Fiets class
 */

namespace CrudFietsOOP\Tests;

use PHPUnit\Framework\TestCase;
use CrudFietsOOP\Fiets;

class FietsTest extends TestCase {
    
    // Test 1: Constructor met lege array
    public function testConstructorMetLegeArray(): void {
        $fiets = new Fiets();
        
        $this->assertNull($fiets->getId());
        $this->assertEquals('', $fiets->getMerk());
        $this->assertEquals(0.0, $fiets->getPrijs());
    }

    // Test 2: Constructor met volledige data
    public function testConstructorMetData(): void {
        $data = [
            'id' => 1,
            'merk' => 'Gazelle',
            'type' => 'Chamonix',
            'prijs' => 799.99,
            'foto' => 'fiets1.jpg'
        ];
        
        $fiets = new Fiets($data);
        
        $this->assertEquals(1, $fiets->getId());
        $this->assertEquals('Gazelle', $fiets->getMerk());
        $this->assertEquals('Chamonix', $fiets->getType());
        $this->assertEquals(799.99, $fiets->getPrijs());
    }

    // Test 3: Merk setter en getter
    public function testGetMerkEnSetMerk(): void {
        $fiets = new Fiets();
        $fiets->setMerk('Giant');
        $this->assertEquals('Giant', $fiets->getMerk());
    }

    // Test 4: Type setter en getter
    public function testGetTypeEnSetType(): void {
        $fiets = new Fiets();
        $fiets->setType('Mountainbike');
        $this->assertEquals('Mountainbike', $fiets->getType());
    }

    // Test 5: Prijs met positieve waarde
    public function testSetPrijsPositief(): void {
        $fiets = new Fiets();
        $fiets->setPrijs(1299.50);
        $this->assertEquals(1299.50, $fiets->getPrijs());
    }

    // Test 6: Negatieve prijs geeft fout
    public function testSetPrijsMetNegatiefGooitException(): void {
        $this->expectException(\InvalidArgumentException::class);
        
        $fiets = new Fiets();
        $fiets->setPrijs(-100);
    }

    // Test 7: Converteer naar array
    public function testToArray(): void {
        $data = [
            'id' => 3,
            'merk' => 'Sparta',
            'type' => 'Pick-up',
            'prijs' => 899.00,
            'foto' => 'sparta.jpg'
        ];
        
        $fiets = new Fiets($data);
        $array = $fiets->toArray();
        
        $this->assertIsArray($array);
        $this->assertEquals($data, $array);
    }

    // Test 8: Converteer naar string
    public function testToString(): void {
        $fiets = new Fiets([
            'merk' => 'Koga',
            'type' => 'Miyata',
            'prijs' => 1599.99
        ]);
        
        $expected = "Koga Miyata - €1599.99";
        $this->assertEquals($expected, (string)$fiets);
    }
}