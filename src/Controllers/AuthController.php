<?php
declare(strict_types=1);

namespace Controllers;

use Auth\Auth;
use Validators\LoginValidator;

final class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (Auth::check()) { header('Location: /'); return; }
        $errors = $_SESSION['flash_errors'] ?? [];
        unset($_SESSION['flash_errors']);
        require BASE_DIR . '/views/auth/login.php';
    }

    public function login(): void
    {
        [\$email, \$password, \$errors] = LoginValidator::validate(\$_POST);
        if (\$errors) {
            \$_SESSION['flash_errors'] = \$errors;
            header('Location: /login'); return;
        }
        if (!Auth::attempt(\Core\DB::connect(), \$email, \$password)) {
            \$_SESSION['flash_errors'] = ['general' => 'Невірні облікові дані'];
            header('Location: /login'); return;
        }
        header('Location: /');
    }

    public function logout(): void
    {
        Auth::logout();
        header('Location: /login');
    }
}
