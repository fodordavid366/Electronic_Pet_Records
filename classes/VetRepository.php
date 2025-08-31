<?php
namespace App;

use PDO;

class VetRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $rows = $this->pdo->query("SELECT * FROM vet")->fetchAll();
        return array_map(fn($row) => new Vet($row), $rows);
    }

    public function find(int $id): ?Vet
    {
        $stmt = $this->pdo->prepare("SELECT * FROM vet WHERE vet_id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? new Vet($row) : null;
    }

    public function create(Vet $vet): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO vet (first_name, last_name, email, phone_number, birth_date, specialization, password)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $vet->firstName,
            $vet->lastName,
            $vet->email,
            $vet->phoneNumber,
            $vet->birthDate,
            $vet->specialization,
            password_hash($vet->password, PASSWORD_DEFAULT)
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(Vet $vet): void
    {
        if ($vet->password) {
            $stmt = $this->pdo->prepare(
                "UPDATE vet SET first_name=?, last_name=?, email=?, phone_number=?, birth_date=?, specialization=?, password=?
                 WHERE vet_id=?"
            );
            $stmt->execute([
                $vet->firstName,
                $vet->lastName,
                $vet->email,
                $vet->phoneNumber,
                $vet->birthDate,
                $vet->specialization,
                password_hash($vet->password, PASSWORD_DEFAULT),
                $vet->id
            ]);
        } else {
            $stmt = $this->pdo->prepare(
                "UPDATE vet SET first_name=?, last_name=?, email=?, phone_number=?, birth_date=?, specialization=?
                 WHERE vet_id=?"
            );
            $stmt->execute([
                $vet->firstName,
                $vet->lastName,
                $vet->email,
                $vet->phoneNumber,
                $vet->birthDate,
                $vet->specialization,
                $vet->id
            ]);
        }
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM vet WHERE vet_id=?");
        $stmt->execute([$id]);
    }
}
