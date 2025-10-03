<?php
declare(strict_types=1);


final class MethodNotAllowedException extends BadMethodCallException {}

final class User
{
    private string  $name  = '';
    private int     $age   = 0;
    private ?string $email = null; 


    public function getData(): array
    {
        return [
            'name'  => $this->name,
            'age'   => $this->age,
            'email' => $this->email,
        ];
    }

    public function __call(string $method, array $args)
    {
        $allowed = ['setName', 'setAge'];

        if (in_array($method, $allowed, true) && method_exists($this, $method)) {
            return $this->{$method}(...$args);
        }

        throw new MethodNotAllowedException(
            "Метод {$method}() не існує або недоступний у класі " . __CLASS__
        );
    }


    private function setName(string $name): void
    {
        $name = trim($name);
        if ($name === '') {
            throw new InvalidArgumentException('Імʼя не може бути порожнім.');
        }
        $this->name = $name;
    }

    private function setAge(int $age): void
    {
        if ($age < 0 || $age > 130) {
            throw new InvalidArgumentException('Вік має бути у межах 0..130.');
        }
        $this->age = $age;
    }
}
