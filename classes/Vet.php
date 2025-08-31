<?php
namespace App;

class Vet
{
    public ?int $id = null;
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $phoneNumber;
    public string $birthDate;
    public string $specialization;
    public ?string $password = null; // csak létrehozásnál / frissítésnél

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? ($data['vet_id'] ?? null);
        $this->firstName = $data['first_name'] ?? '';
        $this->lastName = $data['last_name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->phoneNumber = $data['phone_number'] ?? '';
        $this->birthDate = $data['birth_date'] ?? '';
        $this->specialization = $data['specialization'] ?? '';
        if (isset($data['password'])) {
            $this->password = $data['password'];
        }
    }

    public function toArray(): array
    {
        return [
            'vet_id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone_number' => $this->phoneNumber,
            'birth_date' => $this->birthDate,
            'specialization' => $this->specialization,
        ];
    }
}
