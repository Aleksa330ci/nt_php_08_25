<?php
declare(strict_types=1);

function gradeLetter(int $score): ?string
{
    if ($score < 0 || $score > 100) return null;

    if ($score >= 90) return 'A';
    if ($score >= 80) return 'B';
    if ($score >= 70) return 'C';
    if ($score >= 60) return 'D';
    return 'F';
}
