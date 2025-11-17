<?php
namespace Validators;

final class LoginValidator {
    public static function validate(array $input): array {
        $errors = [];
        $email = trim((string)($input['email'] ?? ''));
        $password = (string)($input['password'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Невалідний email';
        if ($password === '') $errors[] = 'Пароль обовʼязковий';

        return [$email, $password, $errors];
    }
}
