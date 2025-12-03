<?php
namespace Controllers;

use Core\Controller;
use Repositories\ProductRepository;
use Services\CartService;
use Services\InventoryService;
use Validators\CartValidator;

class CartController extends Controller
{
    public function __construct(
        private ProductRepository  $products = new ProductRepository(),
        private CartService        $cart     = new CartService(),
        private InventoryService   $stock    = new InventoryService(),
    ) {}

    public function index(): void
    {
        $items = $this->cart->all();
        $total = $this->cart->total();
        $errors = $_SESSION['flash_errors'] ?? [];
        unset($_SESSION['flash_errors']);

        view('cart/index', compact('items','total','errors'));
    }

    public function add(): void
    {
        [$productId, $qty, $errors] = CartValidator::validateAdd($_POST);
        if ($errors) {
            $_SESSION['flash_errors'] = $errors;
            redirect('/cart');
        }

        $product = $this->products->find($productId);
        if (!$product) {
            $_SESSION['flash_errors'] = ['Продукт не знайдено'];
            redirect('/cart');
        }

        $reason = null;
        if (!$this->stock->canPrepareProduct($productId, $qty, $reason)) {
            $_SESSION['flash_errors'] = [$reason ?: 'Неможливо додати продукт у корзину'];
            redirect('/cart');
        }

        $this->cart->add($product, $qty);
        redirect('/cart');
    }

    public function update(): void
    {
        $id = (int)($_GET['id'] ?? 0); 
        [$productId, $qty, $errors] = CartValidator::validateUpdate($_POST, $id);
        if ($errors) {
            $_SESSION['flash_errors'] = $errors;
            redirect('/cart');
        }

        if ($qty > 0) {
            $reason = null;
            if (!$this->stock->canPrepareProduct($productId, $qty, $reason)) {
                $_SESSION['flash_errors'] = [$reason ?: 'Недостатньо інгредієнтів'];
                redirect('/cart');
            }
        }

        $this->cart->update($productId, $qty);
        redirect('/cart');
    }

    public function remove(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) $this->cart->remove($id);
        redirect('/cart');
    }

    public function clear(): void
    {
        $this->cart->clear();
        redirect('/cart');
    }
}
