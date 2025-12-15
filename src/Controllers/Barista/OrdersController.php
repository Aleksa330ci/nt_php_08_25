<?php
namespace Controllers\Barista;

use Core\Controller;
use Core\Auth;
use Repositories\OrdersRepository;

class OrdersController extends Controller
{
    private OrdersRepository $repo;

    public function __construct()
    {
        $this->repo = new OrdersRepository();
    }

    public function index(): void
    {
        $orders = $this->repo->allForUser((int)Auth::id());
        view('barista/orders/index', compact('orders'));
    }

    public function show(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $order = $this->repo->findWithItems($id);
        if (!$order || (int)$order['user_id'] !== (int)Auth::id()) {
            http_response_code(403);
            echo 'Forbidden';
            return;
        }
        view('barista/orders/show', compact('order'));
    }
}
