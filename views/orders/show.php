<?php /** @var array $order */ ?>
<h1>Order #<?= (int)$order['id'] ?></h1>
<p>Subtotal: <?= number_format((float)$order['subtotal'], 2) ?></p>
<p>Discount: <?= number_format((float)$order['discount'], 2) ?></p>
<p>Total:    <?= number_format((float)$order['total'], 2) ?></p>

<h3>Items</h3>
<table>
  <thead>
    <tr><th>Product</th><th>Qty</th><th>Unit price</th><th>Line total</th></tr>
  </thead>
  <tbody>
  <?php foreach ($order['items'] as $it): ?>
    <tr>
      <td><?= htmlspecialchars($it['product_title']) ?></td>
      <td><?= (int)$it['quantity'] ?></td>
      <td><?= number_format((float)$it['unit_price'], 2) ?></td>
      <td><?= number_format((float)$it['unit_price'] * (int)$it['quantity'], 2) ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
