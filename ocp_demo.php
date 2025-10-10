<?php
declare(strict_types=1);

require __DIR__ . '/src/Logger/Contracts/FormatStrategy.php';
require __DIR__ . '/src/Logger/Contracts/DeliveryStrategy.php';
require __DIR__ . '/src/Logger/Format/RawFormatter.php';
require __DIR__ . '/src/Logger/Format/WithDateFormatter.php';
require __DIR__ . '/src/Logger/Format/WithDateAndDetailsFormatter.php';
require __DIR__ . '/src/Logger/Delivery/EmailDelivery.php';
require __DIR__ . '/src/Logger/Delivery/SmsDelivery.php';
require __DIR__ . '/src/Logger/Delivery/ConsoleDelivery.php';
require __DIR__ . '/src/Logger/Logger.php';

use App\Logger\Logger;
use App\Logger\Format\RawFormatter;
use App\Logger\Format\WithDateFormatter;
use App\Logger\Format\WithDateAndDetailsFormatter;
use App\Logger\Delivery\SmsDelivery;
use App\Logger\Delivery\EmailDelivery;
use App\Logger\Delivery\ConsoleDelivery;


$logger1 = new Logger(new RawFormatter(), new SmsDelivery());
$logger1->log('Emergency error! Please fix me!');

echo PHP_EOL;


$logger2 = new Logger(new WithDateFormatter(), new ConsoleDelivery());
$logger2->log('Something happened');


$logger3 = new Logger(new WithDateAndDetailsFormatter(), new EmailDelivery());
$logger3->log('Critical alert');
