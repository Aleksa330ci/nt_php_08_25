<?php
namespace Controllers\Admin;

use Core\Controller;
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
        $orders = $this->repo->all();
        view('admin/orders/index', compact('orders'));
    }

    public function show(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $order = $this->repo->findWithItems($id);
        if (!$order) { http_response_code(404); echo 'Not found'; return; }

        view('admin/orders/show', compact('order'));
    }

    public function destroy(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $this->repo->delete($id);
        header('Location: /admin/orders');
    }
}
