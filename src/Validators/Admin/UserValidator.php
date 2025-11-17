<?php
namespace Validators\Admin;

final class UserValidator {
    public static function validateCreate(array $in): array {
        $errors = [];
        $name  = trim((string)($in['name']  ?? ''));
        $email = trim((string)($in['email'] ?? ''));
        $password = (string)($in['password'] ?? '');
        $role_id = isset($in['role_id']) ? (int)$in['role_id'] : null;

        if ($name === '')  $errors[] = 'Name is required';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email';
        if ($password === '') $errors[] = 'Password is required';

        return [$name, $email, $password, $role_id, $errors];
    }

    public static function validateUpdate(array $in): array {
        $errors = [];
        $name  = trim((string)($in['name']  ?? ''));
        $email = trim((string)($in['email'] ?? ''));
        $password = (string)($in['password'] ?? ''); // optional
        $role_id = isset($in['role_id']) ? (int)$in['role_id'] : null;

        if ($name === '')  $errors[] = 'Name is required';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email';

        return [$name, $email, $password, $role_id, $errors];
    }
}
