<?php
namespace Core;

final class Request
{
    public function __construct(
        private string $method,
        private string $path,
        private array $query,
        private array $headers,
        private string $rawBody
    ) {}

    public static function fromGlobals(): self
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $uri    = $_SERVER['REQUEST_URI'] ?? '/';
        $path   = parse_url($uri, PHP_URL_PATH) ?: '/';

        // Заголовки
        $headers = [];
        foreach ($_SERVER as $k => $v) {
            if (str_starts_with($k, 'HTTP_')) {
                $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($k, 5)))));
                $headers[$name] = $v;
            }
        }
        return new self($method, $path, $_GET, $headers, file_get_contents('php://input') ?: '');
    }

    public function method(): string { return $this->method; }
    public function path(): string { return $this->path; }
    public function query(): array { return $this->query; }
    public function header(string $name, ?string $default = null): ?string
    {
        $name = implode('-', array_map('ucfirst', explode('-', strtolower($name))));
        return $this->headers[$name] ?? $default;
    }
    public function json(): array
    {
        $data = json_decode($this->rawBody, true);
        return is_array($data) ? $data : [];
    }
    public function rawBody(): string { return $this->rawBody; }
}
