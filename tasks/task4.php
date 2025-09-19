<?php
declare(strict_types=1);

function passwordStrength(string $password): string
{
    $len = strlen($password);
    if ($len >= 10) return 'strong';
    if ($len >= 7)  return 'medium';
    return 'weak';
}
