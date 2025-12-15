<?php
namespace Controllers;

use Core\Controller;
use Core\DB;
use Repositories\OrdersRepository;
use Services\CartService; 
use Throwable;

class OrdersController extends Controller
{
    public function __construct(
        private OrdersRepository $orders = new OrdersRepository(),
        private CartService      $cart   = new CartService()
    ) { }

    public function index(): void
    {
        $user = auth()->user(); 
        $page = (int)($_GET['page'] ?? 1);
        $orders = $this->orders->forUser((int)$user['id'], $page);
        view('orders/index', compact('orders'));
    }

    public function show(): void
    {
        $id    = (int)($_GET['id'] ?? 0);
        $order = $this->orders->findWithItems($id);
        if (!$order) { http_response_code(404); echo 'Order not found'; return; }

        $user = auth()->user();
        if ($order['user_id'] !== (int)$user['id']) {
            header('Location: /orders'); return;
        }

        view('orders/show', compact('order'));
    }

    public function store(): void
    {
        $pdo = DB::connect();

        $cartData = $this->cart->summary(); 

        if (!$this->cart->isAvailable()) {       
            $_SESSION['flash_error'] = 'Not enough ingredients to place the order';
            header('Location: /cart'); return;
        }

        try {
            $pdo->beginTransaction();

            $user = auth()->user();
            $orderId = $this->orders->create(
                (int)$user['id'],
                (float)$cartData['subtotal'],
                (float)$cartData['discount'],
                (float)$cartData['total']
            );

            $this->orders->attachProducts($orderId, $cartData['items']);

            
            $this->orders->decrementIngredients($cartData['items']); 

            $pdo->commit();

            $this->cart->reset();                                     
            header('Location: /orders/show?id=' . $orderId);
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) { $pdo->rollBack(); }
            $_SESSION['flash_error'] = 'Order failed: ' . $e->getMessage();
            header('Location: /cart');
        }
    }
}
