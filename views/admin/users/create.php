<!doctype html><meta charset="utf-8">
<h2>Create user</h2>
<?php if (!empty($errors)): ?><ul style="color:#c00"><?php foreach($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach;?></ul><?php endif; ?>
<form action="/admin/users" method="post">
  <p><label>Name <input name="name" required></label></p>
  <p><label>Email <input name="email" type="email" required></label></p>
  <p><label>Password <input name="password" type="password" required></label></p>
  <p><label>Role ID <input name="role_id" type="number" min="1"></label></p>
  <button type="submit">Save</button>
</form>
<p><a href="/admin/users">← back</a></p>
