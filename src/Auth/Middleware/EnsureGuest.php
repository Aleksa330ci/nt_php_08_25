<?php
declare(strict_types=1);

namespace Auth\Middleware;

use Auth\Auth;

final class EnsureAuth
{
    public function handle(callable $next)
    {
        if (!Auth::check()) {
            header('Location: /login');
            exit;
        }
        return $next();
    }
}
"@ | Set-Content -Encoding UTF8 src\Auth\Middleware\EnsureAuth.php

@"
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
