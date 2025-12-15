<h1>Order #<?= (int)$order['id'] ?></h1>
<p>Total: <?= number_format((float)$order['total'], 2) ?></p>
<p>Status: <?= htmlspecialchars($order['status'] ?? 'new') ?></p>
<hr>
<h3>Items</h3>
<table  cellpadding="6">
  <thead>
    <tr><th>Product</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
  </thead>
  <tbody>
  <?php foreach ($order['items'] as $it): ?>
    <tr>
      <td><?= htmlspecialchars($it['product_name']) ?></td>
      <td><?= (int)$it['qty'] ?></td>
      <td><?= number_format((float)$it['price'], 2) ?></td>
      <td><?= number_format((float)$it['subtotal'], 2) ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<p><a href="/barista/orders">Back</a></p>
