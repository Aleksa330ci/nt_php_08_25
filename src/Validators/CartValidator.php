<?php
namespace Validators;

final class CartValidator
{
    public static function validateAdd(array $post): array
    {
        $errors = [];
        $product_id = (int)($post['product_id'] ?? 0);
        $qty        = (int)($post['qty'] ?? 1);

        if ($product_id < 1) $errors[] = 'Некоректний product_id';
        if ($qty < 1)        $errors[] = 'Кількість має бути >= 1';

        return [$product_id, $qty, $errors];
    }

    public static function validateUpdate(array $post, int $pathId): array
    {
        $errors = [];
        $product_id = $pathId; 
        $qty        = (int)($post['qty'] ?? 1);

        if ($product_id < 1) $errors[] = 'Некоректний product_id';
        if ($qty < 0)        $errors[] = 'Кількість не може бути відʼємною';

        return [$product_id, $qty, $errors];
    }
}
