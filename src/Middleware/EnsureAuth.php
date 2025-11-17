<?php
namespace Middleware;
use Core\Request;

final class EnsureAuth {
    public function handle(Request $request, callable $next): void {
        if (empty($_SESSION['user'])) { header('Location: /login'); return; }
        $next();
    }
}
