<?php
namespace Controllers\Admin;

use Core\Controller;
use Repositories\UserRepository;
use Validators\Admin\UserValidator;

final class UsersController extends Controller
{
    public function __construct(private UserRepository $repo = new UserRepository()) {}

    public function index(): void {
        $users = $this->repo->all();
        view('admin/users/index', compact('users'));
    }

    public function create(): void {
        $errors = $_SESSION['flash_errors'] ?? [];
        unset($_SESSION['flash_errors']);
        view('admin/users/create', compact('errors'));
    }

    public function store(): void {
        [$name,$email,$password,$role_id,$errors] = UserValidator::validateCreate($_POST);
        if ($errors) { $_SESSION['flash_errors']=$errors; header('Location: /admin/users/create'); return; }

         $this->repo->create([
            'name'=>$name, 'email'=>$email,
            'password'=>password_hash($password, PASSWORD_BCRYPT),
            'role_id'=>$role_id
        ]);

        header('Location: /admin/users');
    }

    public function edit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $user = $this->repo->find($id);
        if (!$user) { http_response_code(404); echo 'Not found'; return; }

        $errors = $_SESSION['flash_errors'] ?? [];
        unset($_SESSION['flash_errors']);
        view('admin/users/edit', compact('user','errors'));
    }

    public function update(): void {
        $id = (int)($_GET['id'] ?? 0);
        [$name,$email,$password,$role_id,$errors] = UserValidator::validateUpdate($_POST);
        if ($errors) { $_SESSION['flash_errors']=$errors; header("Location: /admin/users/{$id}/edit"); return; }

        $data = ['name'=>$name, 'email'=>$email, 'role_id'=>$role_id];
        if ($password !== '') $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        $this->repo->update($id, $data);

        header('Location: /admin/users');
    }

    public function destroy(): void {
        $id = (int)($_GET['id'] ?? 0);
        $this->repo->delete($id);
        header('Location: /admin/users');
    }
}
