<?php
namespace Validators\Admin;

final class ProductValidator
{
    public static function validateCreate(array $in, array $files): array
    {
        $errors = [];
        $name        = trim((string)($in['name'] ?? ''));
        $description = trim((string)($in['description'] ?? ''));
        $price       = (float)($in['price'] ?? 0);
        $discount    = (int)($in['discount'] ?? 0);

        if ($name === '') $errors[] = 'Name is required';
        if ($price < 0)   $errors[] = 'Price must be >= 0';
        if ($discount < 0 || $discount > 100) $errors[] = 'Discount must be 0..100';

        $image = $files['thumbnail'] ?? null;
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $mime = (string)mime_content_type($image['tmp_name']);
            if (!in_array($mime, ['image/jpeg','image/png','image/webp'], true)) {
                $errors[] = 'Thumbnail must be jpg/png/webp';
            }
        }

        return [$name, $description, $price, $discount, $image, $errors];
    }

    public static function validateUpdate(array $in, array $files): array
    {
        [$name,$description,$price,$discount,$image,$errors] = self::validateCreate($in, $files);
        return [$name,$description,$price,$discount,$image,$errors];
    }
}
