<!doctype html><meta charset="utf-8">
<h2>Edit product #<?= $product['id'] ?></h2>
<?php if (!empty($errors)): ?><ul style="color:#c00"><?php foreach($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach;?></ul><?php endif; ?>

<form action="/admin/products/<?= $product['id'] ?>/update" method="post" enctype="multipart/form-data">
  <p><label>Name <input name="name" value="<?= htmlspecialchars($product['name']) ?>" required></label></p>
  <p><label>Description <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea></label></p>
  <p><label>Price <input name="price" type="number" step="0.01" min="0" value="<?= number_format((float)$product['price'],2,'.','') ?>"></label></p>
  <p><label>Discount <input name="discount" type="number" min="0" max="100" value="<?= (int)$product['discount'] ?>"> %</label></p>
  <p>
    <?php if (!empty($product['thumbnail'])): ?>
      <img src="/uploads/products/<?= htmlspecialchars($product['thumbnail']) ?>" width="80">
    <?php endif; ?>
    <label>New thumbnail <input name="thumbnail" type="file" accept="image/*"></label>
  </p>
  <button type="submit">Update</button>
</form>
<p><a href="/admin/products">← back</a></p>
