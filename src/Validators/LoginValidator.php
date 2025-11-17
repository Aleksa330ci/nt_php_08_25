<?php
declare(strict_types=1);

namespace Validators;

final class LoginValidator
{
    public static function validate(array $data): array
    {
        $errors = [];
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Невалідний email';
        }
        if ($password === '') {
            $errors['password'] = 'Пароль обовʼязковий';
        }

        return [$email, $password, $errors];
    }
}
