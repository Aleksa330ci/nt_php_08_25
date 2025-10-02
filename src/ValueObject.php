<?php
declare(strict_types=1);

final class ValueObject
{
    private int $red;
    private int $green;
    private int $blue;

    public function __construct(int $red, int $green, int $blue)
    {
        // Конструктор проходить через СЕТТЕРИ (валідація)
        $this->setRed($red);
        $this->setGreen($green);
        $this->setBlue($blue);
    }

    // --------- Getters ---------
    public function getRed(): int   { return $this->red; }
    public function getGreen(): int { return $this->green; }
    public function getBlue(): int  { return $this->blue; }

    // --------- Setters (з валідацією 0..255) ---------
    public function setRed(int $red): self
    {
        $this->assertChannel('red', $red);
        $this->red = $red;
        return $this;
    }

    public function setGreen(int $green): self
    {
        $this->assertChannel('green', $green);
        $this->green = $green;
        return $this;
    }

    public function setBlue(int $blue): self
    {
        $this->assertChannel('blue', $blue);
        $this->blue = $blue;
        return $this;
    }

    private function assertChannel(string $name, int $value): void
    {
        if ($value < 0 || $value > 255) {
            throw new InvalidArgumentException("$name must be between 0 and 255; given $value");
        }
    }

    // --------- Порівняння двох об'єктів ---------
    public function equals(ValueObject $other): bool
    {
        // У PHP один екземпляр класу має доступ до private-властивостей іншого екземпляра того ж класу.
        return $this->red   === $other->red
            && $this->green === $other->green
            && $this->blue  === $other->blue;
    }

    // --------- Випадковий RGB ---------
    public static function random(): self
    {
        return new self(
            random_int(0, 255),
            random_int(0, 255),
            random_int(0, 255)
        );
    }

    // --------- Змішування кольорів (середнє арифметичне) ---------
    // Міксує ПОТОЧНИЙ колір з довільною кількістю інших.
    // Якщо не передати інших — повертає клон поточного.
    public function mix(ValueObject ...$others): self
    {
        if (!$others) {
            return new self($this->red, $this->green, $this->blue);
        }

        $sumR = $this->red;
        $sumG = $this->green;
        $sumB = $this->blue;

        foreach ($others as $o) {
            $sumR += $o->red;
            $sumG += $o->green;
            $sumB += $o->blue;
        }

        $n = count($others) + 1; // поточний + інші

        return new self(
            intdiv($sumR, $n),
            intdiv($sumG, $n),
            intdiv($sumB, $n)
        );
    }

    // --------- Дрібні утиліти (не обов'язково, але зручно) ---------
    public function toArray(): array
    {
        return ['red' => $this->red, 'green' => $this->green, 'blue' => $this->blue];
    }

    public function toHex(): string
    {
        return sprintf('#%02X%02X%02X', $this->red, $this->green, $this->blue);
    }

    public function __toString(): string
    {
        return $this->toHex();
    }
}
