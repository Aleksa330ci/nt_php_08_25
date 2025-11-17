<!doctype html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <style>
    body{font-family:system-ui,Arial;padding:40px}
    form{max-width:360px;margin:auto;border:1px solid #ddd;padding:20px;border-radius:8px}
    .error{color:#b00020;margin:8px 0}
    label{display:block;margin:10px 0 4px}
    input{width:100%;padding:8px}
    button{margin-top:12px;padding:10px 14px}
  </style>
</head>
<body>
  <form action="/login" method="post" novalidate>
    <h2>Увійти</h2>
    <?php if (!empty($errors['general'])): ?>
      <div class="error"><?= htmlspecialchars($errors['general']) ?></div>
    <?php endif; ?>
    <label>Email</label>
    <input type="email" name="email" required>
    <?php if (!empty($errors['email'])): ?>
      <div class="error"><?= htmlspecialchars($errors['email']) ?></div>
    <?php endif; ?>

    <label>Пароль</label>
    <input type="password" name="password" required>
    <?php if (!empty($errors['password'])): ?>
      <div class="error"><?= htmlspecialchars($errors['password']) ?></div>
    <?php endif; ?>

    <button type="submit">Login</button>
  </form>
</body>
</html>

