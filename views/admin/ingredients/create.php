<!doctype html><meta charset="utf-8">
<h2>Create ingredient</h2>
<?php if (!empty($errors)): ?><ul style="color:#c00"><?php foreach($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach;?></ul><?php endif; ?>
<form action="/admin/ingredients" method="post">
  <p><label>Name <input name="name" required></label></p>
  <p><label>Amount <input name="amount" type="number" step="0.01" min="0" value="0"></label></p>
  <button type="submit">Save</button>
</form>
<p><a href="/admin/ingredients">← back</a></p>
