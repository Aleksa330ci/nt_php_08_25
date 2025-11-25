<!doctype html><meta charset="utf-8">
<h2>Create product</h2>
<?php if (!empty($errors)): ?><ul style="color:#c00"><?php foreach($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach;?></ul><?php endif; ?>

<form action="/admin/products" method="post" enctype="multipart/form-data">
  <p><label>Name <input name="name" required></label></p>
  <p><label>Description <textarea name="description"></textarea></label></p>
  <p><label>Price <input name="price" type="number" step="0.01" min="0" value="0"></label></p>
  <p><label>Discount <input name="discount" type="number" min="0" max="100" value="0"> %</label></p>
  <p><label>Thumbnail <input name="thumbnail" type="file" accept="image/*"></label></p>
  <button type="submit">Save</button>
</form>
<p><a href="/admin/products">← back</a></p>
