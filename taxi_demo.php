<?php
declare(strict_types=1);

require_once __DIR__.'/src/Contracts/Car.php';
require_once __DIR__.'/src/Domain/Cars/EconomyCar.php';
require_once __DIR__.'/src/Domain/Cars/StandardCar.php';
require_once __DIR__.'/src/Domain/Cars/LuxuryCar.php';
require_once __DIR__.'/src/Creator/TaxiService.php';
require_once __DIR__.'/src/Creator/EconomyTaxi.php';
require_once __DIR__.'/src/Creator/StandardTaxi.php';
require_once __DIR__.'/src/Creator/LuxuryTaxi.php';

use App\Creator\EconomyTaxi;
use App\Creator\StandardTaxi;
use App\Creator\LuxuryTaxi;

$economy = new EconomyTaxi();
$standard = new StandardTaxi();
$luxury = new LuxuryTaxi();

echo $economy->orderRide(), PHP_EOL;
echo $standard->orderRide(), PHP_EOL;
echo $luxury->orderRide(), PHP_EOL;
