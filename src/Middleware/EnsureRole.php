<?php
namespace Middleware;

use Core\Auth;

class EnsureRole
{
    /** @param array|string $roles */
    public function handle(array|string $roles): void
    {
        if (!Auth::check()) { header('Location: /login'); exit; }
        $roles = is_array($roles) ? $roles : [$roles];
        $user = Auth::user();
        $role = $user['role'] ?? $user['role_name'] ?? null;

        if (!$role || !in_array($role, $roles, true)) {
            http_response_code(403);
            echo 'Forbidden';
            exit;
        }
    }
}
