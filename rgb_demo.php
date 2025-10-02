<?php
require __DIR__ . '/src/ValueObject.php';

$a = new ValueObject(255, 0, 0);     // червоний
$b = new ValueObject(0, 0, 255);     // синій

$mixed = $a->mix($b);                // фіолетовий (#7F007F)
$rand  = ValueObject::random();

header('Content-Type: text/plain; charset=utf-8');
echo "A: {$a}\n";
echo "B: {$b}\n";
echo "A==B? " . ($a->equals($b) ? 'true' : 'false') . "\n";
echo "mixed(A,B): {$mixed}\n";
echo "random: {$rand}\n";
