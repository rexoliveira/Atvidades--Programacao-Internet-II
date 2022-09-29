<?php
declare(strict_types=1);

namespace App\Domain\servico;

use JsonSerializable;

class servico implements JsonSerializable
{
    private ?int $id;

    private string $servicoNome;

    private string $firstName;

    private string $lastName;

    public function __construct(?int $id, string $servicoNome, string $firstName, string $lastName)
    {
        $this->id = $id;
        $this->servicoNome = strtolower($servicoNome);
        $this->firstName = ucfirst($firstName);
        $this->lastName = ucfirst($lastName);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getservicoNome(): string
    {
        return $this->servicoNome;
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
            'servicoNome' => $this->servicoNome,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ];
    }
}
