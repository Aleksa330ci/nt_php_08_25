<?php
namespace Core;

use ReflectionClass;

final class Router
{
    /** @var array<string, array<int, array{pattern:string,regex:string,handler:array{0:string,1:string}}>> */
    private array $routes = [
        'GET'    => [], 'POST' => [], 'PUT' => [], 'PATCH' => [], 'DELETE' => [],
    ];

    public function get(string $p, array $h): void { $this->add('GET', $p, $h); }
    public function post(string $p, array $h): void { $this->add('POST', $p, $h); }
    public function put(string $p, array $h): void { $this->add('PUT', $p, $h); }
    public function patch(string $p, array $h): void { $this->add('PATCH', $p, $h); }
    public function delete(string $p, array $h): void { $this->add('DELETE', $p, $h); }

    private function add(string $method, string $pattern, array $handler): void
    {
        $regex = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $pattern);
        $regex = '#^' . $regex . '$#';
        $this->routes[$method][] = ['pattern' => $pattern, 'regex' => $regex, 'handler' => $handler];
    }

    public function dispatch(Request $request): mixed
    {
        $method = $request->method();
        $path   = rtrim($request->path(), '/') ?: '/';

        foreach ($this->routes[$method] ?? [] as $route) {
            if (preg_match($route['regex'], $path, $m)) {
                $params = [];
                foreach ($m as $k => $v) {
                    if (!is_int($k)) $params[$k] = $v;
                }
                [$controllerClass, $action] = $route['handler'];

                if (!class_exists($controllerClass)) {
                    return Response::json(['error' => "Controller '$controllerClass' not found"], 404);
                }
                $rc = new ReflectionClass($controllerClass);
                if (!$rc->isSubclassOf(Controller::class)) {
                    return Response::json(['error' => "Controller must extend " . Controller::class], 500);
                }
                if (!$rc->hasMethod($action)) {
                    return Response::json(['error' => "Action '$action' not found in $controllerClass"], 404);
                }

                $controller = $rc->newInstance();
                return $controller->$action(...array_values($params), $request);
            }
        }

        return Response::json(['error' => 'Route not found', 'method' => $method, 'path' => $path], 404);
    }
}
