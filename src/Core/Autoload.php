<?php
spl_autoload_register(function ($class) {
    $prefixes = [
        'Core\\' => __DIR__ . '/',
        'App\\'  => dirname(__DIR__) . '/App/',
    ];
    foreach ($prefixes as $prefix => $baseDir) {
        if (strncmp($class, $prefix, strlen($prefix)) === 0) {
            $rel = substr($class, strlen($prefix));
            $file = $baseDir . str_replace('\\', '/', $rel) . '.php';
            if (is_file($file)) {
                require $file;
                return true;
            }
        }
    }
    return false;
});
