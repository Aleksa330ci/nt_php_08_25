<?php
declare(strict_types=1);

function isEven(int $n): bool
{
    return $n % 2 === 0;
}


function parity(int $n): string
{
    return isEven($n) ? 'even' : 'odd';
}
