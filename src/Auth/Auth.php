<?php
namespace Auth;
use PDO;

final class Auth {
    public static function attempt(PDO $pdo, string $email, string $password): bool {
        $q = $pdo->prepare('SELECT id, name, email, password, role_id FROM users WHERE email = :e LIMIT 1');
        $q->execute([':e' => $email]);
        $user = $q->fetch();
        if (!$user) return false;

        $ok = password_get_info($user['password'])['algo'] ? password_verify($password, $user['password'])
                                                           : $password === $user['password'];

        if ($ok) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role_id' => $user['role_id'],
            ];
            return true;
        }
        return false;
    }

    public static function check(): bool { return !empty($_SESSION['user']); }
    public static function user(): ?array { return $_SESSION['user'] ?? null; }
    public static function logout(): void { unset($_SESSION['user']); session_regenerate_id(true); }
}
