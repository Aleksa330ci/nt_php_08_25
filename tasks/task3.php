<?php
declare(strict_types=1);

function sumPositive(array $nums): int|float
{
    $sum = 0;
    foreach ($nums as $x) {
        if (is_numeric($x) && $x > 0) {
            $sum += $x;
        }
    }
    return $sum;
}
