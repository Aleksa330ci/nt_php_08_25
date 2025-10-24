<?php
declare(strict_types=1);

namespace App\Domain;

final class Contact
{
    private function __construct(
        private string $name,
        private string $surname,
        private string $email,
        private string $phone,
        private string $address,
    ) {}

    /** Фабрика, щоб почати ланцюжок */
    public static function make(): ContactBuilder
    {
        return new ContactBuilder();
    }

    // --- Getters ---
    public function name(): string     { return $this->name; }
    public function surname(): string  { return $this->surname; }
    public function email(): string    { return $this->email; }
    public function phone(): string    { return $this->phone; }
    public function address(): string  { return $this->address; }

    /** Внутрішній конструктор для Builder */
    public static function fromBuilder(ContactBuilder $b): self
    {
        return new self(
            $b->getName(),
            $b->getSurname(),
            $b->getEmail(),
            $b->getPhone(),
            $b->getAddress(),
        );
    }
}
