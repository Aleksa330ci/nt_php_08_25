<?php $errors = $errors ?? ($_SESSION['flash_errors'] ?? []); ?>
<!doctype html><meta charset="utf-8">
<h2>Login</h2>
<?php if ($errors): ?>
  <ul style="color:#c00">
    <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
  </ul>
<?php endif; ?>
<form action="/login" method="post">
  <label>Email <input type="email" name="email" required></label><br>
  <label>Password <input type="password" name="password" required></label><br>
  <button type="submit">Sign in</button>
</form>
