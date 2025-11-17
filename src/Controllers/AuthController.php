<?php
namespace Controllers;

use Core\Controller;
use Core\DB;
use Validators\LoginValidator;
use Auth\Auth;

final class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (Auth::check()) { header('Location: /'); return; }
        $errors = $_SESSION['flash_errors'] ?? [];
        unset($_SESSION['flash_errors']);
        view('auth/login', compact('errors'));
    }

    public function login(): void
    {
        [$email, $password, $errors] = LoginValidator::validate($_POST);

        if ($errors) { $_SESSION['flash_errors'] = $errors; header('Location: /login'); return; }

        if (Auth::attempt(DB::connect(), $email, $password)) { header('Location: /'); return; }

        $_SESSION['flash_errors']['general'] = 'Неправильні облікові дані';
        header('Location: /login');
    }

    public function logout(): void
    {
        Auth::logout();
        header('Location: /login');
    }
}
