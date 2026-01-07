<?php
/**
 * Fiets.php
 * Auteur: [Jouw naam]
 * Class voor een fiets object
 */

namespace CrudFietsOOP;

class Fiets {
    // Eigenschappen van een fiets
    private ?int $id;
    private string $merk;
    private string $type;
    private float $prijs;
    private string $foto;

    // Constructor: maakt nieuw fiets object aan
    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? null;
        $this->merk = $data['merk'] ?? '';
        $this->type = $data['type'] ?? '';
        $this->prijs = $data['prijs'] ?? 0.0;
        $this->foto = $data['foto'] ?? '';
    }

    // Getters - halen waardes op
    public function getId(): ?int {
        return $this->id;
    }

    public function getMerk(): string {
        return $this->merk;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getPrijs(): float {
        return $this->prijs;
    }

    public function getFoto(): string {
        return $this->foto;
    }

    // Setters - stellen waardes in
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setMerk(string $merk): void {
        $this->merk = $merk;
    }

    public function setType(string $type): void {
        $this->type = $type;
    }

    // Prijs mag niet negatief zijn
    public function setPrijs(float $prijs): void {
        if ($prijs < 0) {
            throw new \InvalidArgumentException("Prijs mag niet negatief zijn");
        }
        $this->prijs = $prijs;
    }

    public function setFoto(string $foto): void {
        $this->foto = $foto;
    }

    // Converteer naar array
    public function toArray(): array {
        return [
            'id' => $this->id,
            'merk' => $this->merk,
            'type' => $this->type,
            'prijs' => $this->prijs,
            'foto' => $this->foto
        ];
    }

    // Converteer naar string (bijv. "Gazelle Eclipse - €799.99")
    public function __toString(): string {
        return "{$this->merk} {$this->type} - €{$this->prijs}";
    }
}