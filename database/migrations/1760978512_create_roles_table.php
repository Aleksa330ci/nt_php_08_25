<?php
return new class {
    public function up() {
        return "
        CREATE TABLE IF NOT EXISTS roles (
            id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL UNIQUE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    }
    public function down() {
        return "DROP TABLE IF EXISTS roles;";
    }
};
