<?php
use Core\DB;

if (!function_exists('db')) {
    function db(): PDO {
        return DB::connect();
    }
}
