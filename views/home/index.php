<?php
/** @var array|null $user */
?>
<!doctype html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <title>Головна</title>
  <style>body{font-family:system-ui,Arial;padding:40px}</style>
</head>
<body>
  <h1>Вітаю, <?= htmlspecialchars($user['name'] ?? 'користувач') ?></h1>
  <p>Ваша роль: <b><?= htmlspecialchars($user['role'] ?? '—') ?></b></p>
  <p><a href="/logout">Вийти</a></p>
</body>
</html>
