<?php
declare(strict_types=1);

const BASE_DIR = __DIR__ . '/..';

require BASE_DIR . '/vendor/autoload.php';

session_start();

require BASE_DIR . '/src/Core/helpers.php';   
require BASE_DIR . '/routes/web.php';        

use Core\Router;
use Core\Request;

(new Router())->dispatch(Request::capture());
