<!doctype html><meta charset="utf-8">
<h2>Edit user #<?= $user['id'] ?></h2>
<?php if (!empty($errors)): ?><ul style="color:#c00"><?php foreach($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach;?></ul><?php endif; ?>
<form action="/admin/users/<?= $user['id'] ?>/update" method="post">
  <p><label>Name <input name="name" value="<?= htmlspecialchars($user['name']) ?>" required></label></p>
  <p><label>Email <input name="email" type="email" value="<?= htmlspecialchars($user['email']) ?>" required></label></p>
  <p><label>New password (optional) <input name="password" type="password"></label></p>
  <p><label>Role ID <input name="role_id" type="number" value="<?= (int)$user['role_id'] ?>"></label></p>
  <button type="submit">Update</button>
</form>
<p><a href="/admin/users">← back</a></p>
