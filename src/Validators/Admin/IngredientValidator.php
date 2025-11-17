<?php
namespace Validators\Admin;

final class IngredientValidator {
    public static function validate(array $in): array {
        $errors = [];
        $name = trim((string)($in['name'] ?? ''));
        $amount = (float)($in['amount'] ?? 0);

        if ($name === '') $errors[] = 'Name is required';
        if ($amount < 0)  $errors[] = 'Amount must be >= 0';

        return [$name, $amount, $errors];
    }
}
