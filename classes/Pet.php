<?php
namespace App;

class Pet
{
    public ?int $id = null;
    public string $name;
    public string $species;
    public string $breed;
    public string $gender;
    public string $birthDate;
    public int $vetId;
    public ?int $ownerId = null;

    public function __construct(array $data)
    {
        $this->name       = $data['name'];
        $this->species    = $data['species'];
        $this->breed      = $data['breed'];
        $this->gender     = $data['gender'];
        $this->birthDate  = $data['birth_date'];
        $this->vetId      = (int)$data['vet_id'];
        $this->ownerId    = isset($data['owner_id']) ? (int)$data['owner_id'] : null;

        if (isset($data['id'])) {
            $this->id = (int)$data['id'];
        } elseif (isset($data['pet_id'])) {
            $this->id = (int)$data['pet_id'];
        }
    }

    public function toArray(): array
    {
        return [
            'pet_id'     => $this->id,
            'name'       => $this->name,
            'species'    => $this->species,
            'breed'      => $this->breed,
            'gender'     => $this->gender,
            'birth_date' => $this->birthDate,
            'vet_id'     => $this->vetId,
            'owner_id'   => $this->ownerId,
        ];
    }
}
