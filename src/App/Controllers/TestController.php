<?php
namespace App\Controllers;

use Core\Controller;
use Core\Request;
use Core\Response;

final class TestController extends Controller
{
    public function index(Request $req): Response
    {
        return $this->ok([
            'hello' => 'router is alive',
            'method' => $req->method(),
            'query'  => $req->query(),
        ]);
    }

    public function show(string $id, Request $req): Response
    {
        if (!ctype_digit($id)) {
            return $this->badRequest('id must be numeric');
        }
        return $this->ok(['id' => (int)$id, 'details' => 'example']);
    }

    public function store(Request $req): Response
    {
        $data = $req->json();
        if (!isset($data['name']) || $data['name'] === '') {
            return $this->badRequest("field 'name' is required");
        }
        // ... зберегли б у БД
        return $this->ok(['created' => true, 'payload' => $data]);
    }

    public function update(string $id, Request $req): Response
    {
        return $this->ok(['updated' => (int)$id, 'payload' => $req->json()]);
    }

    public function destroy(string $id, Request $req): Response
    {
        return $this->ok(['deleted' => (int)$id]);
    }
}
