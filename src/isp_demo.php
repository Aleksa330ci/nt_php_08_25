<?php
declare(strict_types=1);

require __DIR__ . '/src/ISP/Contracts/Eater.php';
require __DIR__ . '/src/ISP/Contracts/Flyer.php';
require __DIR__ . '/src/ISP/Swallow.php';
require __DIR__ . '/src/ISP/Ostrich.php';

use App\ISP\Swallow;
use App\ISP\Ostrich;

$swallow = new Swallow();  
$ostrich = new Ostrich();  


