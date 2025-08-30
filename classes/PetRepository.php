<?php
namespace App;

use PDO;

class PetRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Pet $pet, int $owner_id): int|string
    {
        if ($this->existsPet($pet, $owner_id)) {
            return "Ez a házikedvenc már létezik.";
        }

        $stmt = $this->pdo->prepare(
            "INSERT INTO pet (name, species, breed, gender, birth_date, vet_id)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $pet->name,
            $pet->species,
            $pet->breed,
            $pet->gender,
            $pet->birthDate,
            $pet->vetId
        ]);
        $newId = (int)$this->pdo->lastInsertId();

        $link = $this->pdo->prepare("INSERT INTO owner_pet (owner_id, pet_id) VALUES (?, ?)");
        $link->execute([$owner_id, $newId]);

        return $newId;
    }

    public function existsPet(Pet $pet, int $ownerId): bool
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM owner_pet op
             JOIN pet p ON op.pet_id = p.pet_id
             WHERE p.name = ? AND p.species = ? AND p.breed = ? AND p.gender = ? AND p.birth_date = ?
               AND op.owner_id = ?"
        );
        $stmt->execute([
            $pet->name,
            $pet->species,
            $pet->breed,
            $pet->gender,
            $pet->birthDate,
            $ownerId
        ]);
        return $stmt->fetchColumn() > 0;
    }

    public function find(int $id): ?Pet
    {
        $stmt = $this->pdo->prepare(
            "SELECT p.*, op.owner_id FROM pet p
             LEFT JOIN owner_pet op ON op.pet_id = p.pet_id
             WHERE p.pet_id = ?"
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? new Pet($row) : null;
    }

    public function findByOwner(int $ownerId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT p.*, op.owner_id FROM pet p
             JOIN owner_pet op ON op.pet_id = p.pet_id
             WHERE op.owner_id = ?"
        );
        $stmt->execute([$ownerId]);
        return array_map(
            fn($row) => new Pet($row),
            $stmt->fetchAll()
        );
    }

    public function findByVet(int $vetId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT p.*, op.owner_id FROM pet p
             LEFT JOIN owner_pet op ON op.pet_id = p.pet_id
             WHERE p.vet_id = ?"
        );
        $stmt->execute([$vetId]);
        return array_map(
            fn($row) => new Pet($row),
            $stmt->fetchAll()
        );
    }

    public function findAll(): array
    {
        $rows = $this->pdo->query(
            "SELECT p.*, op.owner_id FROM pet p
             LEFT JOIN owner_pet op ON op.pet_id = p.pet_id"
        )->fetchAll();
        return array_map(
            fn($row) => new Pet($row),
            $rows
        );
    }

    public function update(Pet $pet): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE pet
             SET name=?, species=?, breed=?, gender=?, birth_date=?, vet_id=?
             WHERE pet_id=?"
        );
        $stmt->execute([
            $pet->name,
            $pet->species,
            $pet->breed,
            $pet->gender,
            $pet->birthDate,
            $pet->vetId,
            $pet->id
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM pet WHERE pet_id = ?");
        $stmt->execute([$id]);
    }
}
