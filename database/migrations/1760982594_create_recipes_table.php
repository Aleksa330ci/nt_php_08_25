<?php
return new class {
    public function up() {
        return "
        CREATE TABLE IF NOT EXISTS recipes (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            product_id INT UNSIGNED,
            ingredient_id INT UNSIGNED,
            amount FLOAT DEFAULT 0,
            CONSTRAINT fk_recipes_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
            CONSTRAINT fk_recipes_ingredient FOREIGN KEY (ingredient_id) REFERENCES ingredients(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    }
    public function down() {
        return "DROP TABLE IF EXISTS recipes;";
    }
};
