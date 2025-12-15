<?php /** @var array $orders */ ?>
<h1>My Orders</h1>
<table>
  <thead>
    <tr><th>ID</th><th>Total</th><th>Discount</th><th>Created</th><th></th></tr>
  </thead>
  <tbody>
    <?php foreach ($orders as $o): ?>
      <tr>
        <td><?= (int)$o['id'] ?></td>
        <td><?= number_format((float)$o['total'], 2) ?></td>
        <td><?= number_format((float)$o['discount'], 2) ?></td>
        <td><?= htmlspecialchars($o['created_at']) ?></td>
        <td><a href="/orders/show?id=<?= (int)$o['id'] ?>">Details</a></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
