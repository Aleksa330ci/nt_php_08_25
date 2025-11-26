<?php
namespace Controllers\Admin;

use Core\Controller;
use Repositories\ProductRepository;
use Validators\Admin\ProductValidator;

class ProductsController extends Controller
{
    public function __construct(private ProductRepository $repo = new ProductRepository()) {}

    public function index(): void
    {
        $products = $this->repo->all();
        view('admin/products/index', compact('products'));
    }

    public function create(): void
    {
        $errors = $_SESSION['flash_errors'] ?? [];
        unset($_SESSION['flash_errors']);

        view('admin/products/create', compact('errors'));
    }

    public function store(): void
    {
        [$name, $description, $price, $discount, $image, $errors] =
            ProductValidator::validateCreate($_POST, $_FILES);

        if ($errors) {
            $_SESSION['flash_errors'] = $errors;
            redirect('/admin/products/create');
        }

        $this->repo->create(
            compact('name', 'description', 'price', 'discount'),
            $image
        );

        redirect('/admin/products');
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $product = $this->repo->find($id);

        if (!$product) {
            http_response_code(404);
            echo 'Not found';
            return;
        }

        $errors = $_SESSION['flash_errors'] ?? [];
        unset($_SESSION['flash_errors']);

        view('admin/products/edit', compact('product', 'errors'));
    }

    public function update(): void
    {
        $id = (int)($_GET['id'] ?? 0);

        [$name, $description, $price, $discount, $image, $errors] =
            ProductValidator::validateUpdate($_POST, $_FILES);

        if ($errors) {
            $_SESSION['flash_errors'] = $errors;
            redirect("/admin/products/{$id}/edit");
        }

        $this->repo->update(
            $id,
            compact('name', 'description', 'price', 'discount'),
            $image
        );

        redirect('/admin/products');
    }

    public function destroy(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $this->repo->delete($id);

        redirect('/admin/products');
    }
}
