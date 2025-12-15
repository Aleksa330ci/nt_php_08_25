<?php

return new class implements Console\Contracts\Migration
{
    public function up(): string
    {
        return "
        CREATE TABLE IF NOT EXISTS `order_products` (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            order_id BIGINT UNSIGNED NOT NULL,
            product_id INT(10) UNSIGNED NULL,
            product_title VARCHAR(255) NOT NULL,
            quantity SMALLINT UNSIGNED NOT NULL DEFAULT 1,
            unit_price DECIMAL(10,2) NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT fk_order_products_order
              FOREIGN KEY (order_id) REFERENCES orders(id)
              ON DELETE CASCADE,
            CONSTRAINT fk_order_products_product
              FOREIGN KEY (product_id) REFERENCES products(id)
              ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
    }

    public function down(): string
    {
        return "DROP TABLE IF EXISTS `order_products`;";
    }
};
