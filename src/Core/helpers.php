<?php
use Core\DB;

function db(): PDO { return DB::connect(); }

function view(string $path, array $data = []): void {
    extract($data);
    require BASE_DIR . '/views/' . $path . '.php';
}
