<?php
declare(strict_types=1);

namespace App\Domain\cliente;

use JsonSerializable;

class cliente implements JsonSerializable
{
    private ?int $id;

    private string $clientename;

    private string $firstName;

    private string $lastName;

    public function __construct(?int $id, string $clientename, string $firstName, string $lastName)
    {
        $this->id = $id;
        $this->clientename = strtolower($clientename);
        $this->firstName = ucfirst($firstName);
        $this->lastName = ucfirst($lastName);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getclientename(): string
    {
        return $this->clientename;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'clientename' => $this->clientename,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ];
    }
}
