<?php
namespace Controllers\Admin;

use Core\Controller;
use Repositories\IngredientRepository;
use Validators\Admin\IngredientValidator;

final class IngredientsController extends Controller
{
    public function __construct(private IngredientRepository $repo = new IngredientRepository()) {}

    public function index(): void {
        $items = $this->repo->all();
        view('admin/ingredients/index', compact('items'));
    }

    public function create(): void {
        $errors = $_SESSION['flash_errors'] ?? [];
        unset($_SESSION['flash_errors']);
        view('admin/ingredients/create', compact('errors'));
    }

    public function store(): void {
        [$name,$amount,$errors] = IngredientValidator::validate($_POST);
        if ($errors) { $_SESSION['flash_errors']=$errors; header('Location: /admin/ingredients/create'); return; }
        $this->repo->create(['name'=>$name, 'amount'=>$amount]);
        header('Location: /admin/ingredients');
    }

    public function edit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $item = $this->repo->find($id);
        if (!$item) { http_response_code(404); echo 'Not found'; return; }
        $errors = $_SESSION['flash_errors'] ?? [];
        unset($_SESSION['flash_errors']);
        view('admin/ingredients/edit', compact('item','errors'));
    }

    public function update(): void {
        $id = (int)($_GET['id'] ?? 0);
        [$name,$amount,$errors] = IngredientValidator::validate($_POST);
        if ($errors) { $_SESSION['flash_errors']=$errors; header("Location: /admin/ingredients/{$id}/edit"); return; }
        $this->repo->update($id, ['name'=>$name, 'amount'=>$amount]);
        header('Location: /admin/ingredients');
    }

    public function destroy(): void {
        $id = (int)($_GET['id'] ?? 0);
        $this->repo->delete($id);
        header('Location: /admin/ingredients');
    }
}
