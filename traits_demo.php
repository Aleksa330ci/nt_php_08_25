<?php
declare(strict_types=1);

require __DIR__ . '/src/Traits/TraitOne.php';
require __DIR__ . '/src/Traits/TraitTwo.php';
require __DIR__ . '/src/Traits/TraitThree.php';
require __DIR__ . '/src/TraitsDemo.php';

use App\Traits\TraitOne;
use App\Traits\TraitTwo;
use App\Traits\TraitThree;
use App\TraitsDemo;

$demo = new TraitsDemo();

echo 'test(): ', $demo->test(), PHP_EOL; 
echo 'sum():  ', $demo->sum(),  PHP_EOL;  
