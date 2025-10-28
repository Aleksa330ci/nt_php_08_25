<?php
namespace Core;

abstract class Controller
{
    protected function ok(mixed $data): Response
    {
        return Response::json($data, 200);
    }

    protected function notFound(string $message = 'Not Found'): Response
    {
        return Response::json(['error' => $message], 404);
    }

    protected function badRequest(string $message): Response
    {
        return Response::json(['error' => $message], 400);
    }
}
