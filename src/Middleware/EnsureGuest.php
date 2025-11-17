<?php
namespace Middleware;
use Core\Request;

final class EnsureGuest {
    public function handle(Request $request, callable $next): void {
        if (!empty($_SESSION['user'])) { header('Location: /'); return; }
        $next();
    }
}
