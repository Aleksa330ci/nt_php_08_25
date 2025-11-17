<?php
declare(strict_types=1);

namespace Auth;

use PDO;

final class Auth
{
    private const KEY = 'user_id';

    public static function check(): bool
    {
        return isset($_SESSION[self::KEY]) && is_numeric($_SESSION[self::KEY]);
    }

    public static function id(): ?int
    {
        return self::check() ? (int)$_SESSION[self::KEY] : null;
    }

    public static function user(PDO $pdo): ?array
    {
        if (!self::check()) return null;
        $stmt = $pdo->prepare('SELECT u.*, r.name AS role FROM users u LEFT JOIN roles r ON r.id = u.role_id WHERE u.id = ? LIMIT 1');
        $stmt->execute([self::id()]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function attempt(PDO $pdo, string $email, string $password): bool
    {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) return false;
        if (!password_verify($password, $user['password'])) return false;

        $_SESSION[self::KEY] = (int)$user['id'];
        return true;
    }

    public static function logout(): void
    {
        unset($_SESSION[self::KEY]);
    }
}