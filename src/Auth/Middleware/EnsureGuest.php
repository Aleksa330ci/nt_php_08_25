<?php
declare(strict_types=1);

namespace Auth\Middleware;

use Auth\Auth;

final class EnsureGuest
{
    public function handle(callable $next)
    {
        if (Auth::check()) {
            header('Location: /');
            exit;
        }
        return $next();
    }
}
