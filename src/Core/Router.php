<?php
namespace Core;
use Closure;

final class Router {
    private static array $routes = []; 

    public static function get(string $path, ...$handlers): void  { self::add('GET',  $path, $handlers); }
    public static function post(string $path, ...$handlers): void { self::add('POST', $path, $handlers); }

    private static function add(string $m, string $p, array $handlers): void {
        self::$routes[$m][$p] = $handlers;
    }

    public function dispatch(Request $request): void {
        $match = self::$routes[$request->method][$request->path] ?? null;
        if (!$match) { http_response_code(404); echo 'Not Found'; return; }

        $middlewares = array_slice($match, 0, -1);
        $handler     = $match[array_key_last($match)];

        $next = function() use (&$next, &$middlewares, $handler, $request) {
            if ($mw = array_shift($middlewares)) {
                [$class, $method] = is_array($mw) ? $mw : [$mw, 'handle'];
                (new $class())->$method($request, $next);
                return;
            }
            if ($handler instanceof Closure) { $handler(); return; }
            if (is_array($handler)) { [$cls, $m] = $handler; (new $cls())->$m(); return; }
        };

        $next();
    }
}
