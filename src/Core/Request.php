<?php
namespace Core;

final class Request {
    public string $method;
    public string $path;
    public array $body;

    private function __construct() {
        $this->method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $this->path   = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $this->body   = $_POST;
    }
    public static function capture(): self { return new self(); }
}
