<!doctype html><meta charset="utf-8">
<h2>Cart</h2>

<?php if (!empty($errors)): ?>
  <ul style="color:#c00">
    <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php if (empty($items)): ?>
  <p>Корзина порожня.</p>
<?php else: ?>
  <table cellpadding="6" cellspacing="0">
    <tr><th>Продукт</th><th>Ціна</th><th>К-ть</th><th>Сума</th><th></th></tr>
    <?php foreach ($items as $row): ?>
      <tr>
        <td>
          <?php if (!empty($row['thumbnail'])): ?>
            <img src="/uploads/products/<?= htmlspecialchars($row['thumbnail']) ?>" alt="" width="50">
          <?php endif; ?>
          <?= htmlspecialchars($row['name']) ?>
        </td>
        <td><?= number_format($row['price'], 2) ?></td>
        <td>
          <form action="/cart/<?= (int)$row['product_id'] ?>/update" method="post" style="display:inline">
            <input type="number" name="qty" min="0" value="<?= (int)$row['qty'] ?>" style="width:60px">
            <button type="submit">Оновити</button>
          </form>
        </td>
        <td><?= number_format($row['subtotal'], 2) ?></td>
        <td>
          <form action="/cart/<?= (int)$row['product_id'] ?>/remove" method="post" style="display:inline">
            <button type="submit">Прибрати</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    <tr>
      <th colspan="3" style="text-align:right">Разом:</th>
      <th><?= number_format($total, 2) ?></th>
      <th></th>
    </tr>
  </table>

  <form action="/cart/clear" method="post" style="margin-top:12px">
    <button type="submit">Очистити корзину</button>
  </form>
<?php endif; ?>

<hr>

<form action="/cart/add" method="post" style="margin-top:12px">
  <label>Product ID: <input type="number" name="product_id" min="1" required></label>
  <label>Qty: <input type="number" name="qty" min="1" value="1" required></label>
  <button type="submit">Додати</button>
</form>
