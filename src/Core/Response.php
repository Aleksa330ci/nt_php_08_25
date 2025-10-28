<?php
namespace Core;

final class Response
{
    public function __construct(
        private string $body,
        private int $status = 200,
        private array $headers = []
    ) {}

    public static function json(mixed $data, int $status = 200, array $headers = []): self
    {
        $payload = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return new self($payload === false ? '{}' : $payload, $status, ['Content-Type' => 'application/json; charset=utf-8'] + $headers);
    }

    public function send(): void
    {
        http_response_code($this->status);
        foreach ($this->headers as $k => $v) {
            header("$k: $v");
        }
        echo $this->body;
    }
}
