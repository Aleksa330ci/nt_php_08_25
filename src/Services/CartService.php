<?php
namespace Services;

final class CartService
{
    private const KEY = 'cart';

    public function all(): array
    {
        return $_SESSION[self::KEY]['items'] ?? [];
    }

    public function total(): float
    {
        $sum = 0.0;
        foreach ($this->all() as $row) {
            $sum += (float)$row['subtotal'];
        }
        return $sum;
    }

    public function add(array $product, int $qty): void
    {
        if ($qty < 1) $qty = 1;
        $items = $this->all();

        $pid = (int)$product['id'];
        if (isset($items[$pid])) {
            $items[$pid]['qty'] += $qty;
        } else {
            $items[$pid] = [
                'product_id' => $pid,
                'name'       => (string)$product['name'],
                'price'      => (float)$product['price'],
                'thumbnail'  => $product['thumbnail'] ?? null,
                'qty'        => $qty,
            ];
        }

        $items[$pid]['subtotal'] = $items[$pid]['qty'] * $items[$pid]['price'];
        $_SESSION[self::KEY]['items'] = $items;
    }

    public function update(int $productId, int $qty): void
    {
        $items = $this->all();
        if (!isset($items[$productId])) return;

        if ($qty < 1) {
            unset($items[$productId]);
        } else {
            $items[$productId]['qty'] = $qty;
            $items[$productId]['subtotal'] = $qty * $items[$productId]['price'];
        }
        $_SESSION[self::KEY]['items'] = $items;
    }

    public function remove(int $productId): void
    {
        $items = $this->all();
        unset($items[$productId]);
        $_SESSION[self::KEY]['items'] = $items;
    }

    public function clear(): void
    {
        unset($_SESSION[self::KEY]);
    }
}
