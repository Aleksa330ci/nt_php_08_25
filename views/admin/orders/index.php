<h1>Orders (Admin)</h1>
<table  cellpadding="6">
  <thead>
    <tr>
      <th>ID</th><th>User</th><th>Total</th><th>Status</th><th>Created</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($orders as $o): ?>
    <tr>
      <td><?= (int)$o['id'] ?></td>
      <td><?= htmlspecialchars($o['user_name'] ?? '-') ?></td>
      <td><?= number_format((float)$o['total'], 2) ?></td>
      <td><?= htmlspecialchars($o['status'] ?? 'new') ?></td>
      <td><?= htmlspecialchars($o['created_at'] ?? '') ?></td>
      <td>
        <a href="/admin/orders/show?id=<?= (int)$o['id'] ?>">view</a>
        <form action="/admin/orders/delete" method="post" style="display:inline" onsubmit="return confirm('Delete?')">
          <input type="hidden" name="id" value="<?= (int)$o['id'] ?>">
          <button type="submit">delete</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
