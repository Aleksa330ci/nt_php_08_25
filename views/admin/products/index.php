<!doctype html><meta charset="utf-8">
<h2>Products</h2>
<p><a href="/admin/products/create">Create</a></p>
<table cellpadding="6">
  <tr><th>ID</th><th>Name</th><th>Price</th><th>Discount</th><th>Thumb</th><th>Actions</th></tr>
  <?php foreach ($products as $p): ?>
    <tr>
      <td><?= $p['id'] ?></td>
      <td><?= htmlspecialchars($p['name']) ?></td>
      <td><?= number_format((float)$p['price'], 2) ?></td>
      <td><?= (int)$p['discount'] ?>%</td>
      <td>
        <?php if (!empty($p['thumbnail'])): ?>
          <img src="/uploads/products/<?= htmlspecialchars($p['thumbnail']) ?>" alt="" width="60">
        <?php endif; ?>
      </td>
      <td>
        <a href="/admin/products/<?= $p['id'] ?>/edit">edit</a>
        <form action="/admin/products/<?= $p['id'] ?>/delete" method="post" style="display:inline">
          <button type="submit">delete</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
