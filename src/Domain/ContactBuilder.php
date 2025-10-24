<?php
declare(strict_types=1);

namespace App\Domain;

final class ContactBuilder
{
    private ?string $name    = null;
    private ?string $surname = null;
    private ?string $email   = null;
    private ?string $phone   = null;
    private ?string $address = null;

    public function name(string $v): self    { $this->name = trim($v); return $this; }
    public function surname(string $v): self { $this->surname = trim($v); return $this; }
    public function email(string $v): self   { $this->email = trim($v); return $this; }
    public function phone(string $v): self   { $this->phone = trim($v); return $this; }
    public function address(string $v): self { $this->address = trim($v); return $this; }

    public function build(): Contact
    {
        if ($this->name === null || $this->surname === null) {
            throw new \InvalidArgumentException('Name та Surname обов’язкові');
        }
        if ($this->email !== null && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email невалідний');
        }

        $this->email   ??= '';
        $this->phone   ??= '';
        $this->address ??= '';

        return Contact::fromBuilder($this);
    }

    public function getName(): string    { return (string)$this->name; }
    public function getSurname(): string { return (string)$this->surname; }
    public function getEmail(): string   { return (string)$this->email; }
    public function getPhone(): string   { return (string)$this->phone; }
    public function getAddress(): string { return (string)$this->address; }
}

