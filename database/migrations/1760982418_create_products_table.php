<?php
return new class {
    public function up() {
        return "
        CREATE TABLE IF NOT EXISTS products (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL UNIQUE,
            description TEXT NULL,
            price DECIMAL(8,2) NOT NULL DEFAULT 0,
            discount SMALLINT UNSIGNED DEFAULT 0,
            thumbnail TEXT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    }
    public function down() {
        return "DROP TABLE IF EXISTS products;";
    }
};
