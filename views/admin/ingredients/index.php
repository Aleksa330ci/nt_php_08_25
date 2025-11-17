<!doctype html><meta charset="utf-8">
<h2>Ingredients</h2>
<p><a href="/admin/ingredients/create">Create</a></p>
<table  cellpadding="6">
  <tr><th>ID</th><th>Name</th><th>Amount</th><th>Actions</th></tr>
  <?php foreach ($items as $i): ?>
    <tr>
      <td><?= $i['id'] ?></td>
      <td><?= htmlspecialchars($i['name']) ?></td>
      <td><?= (float)$i['amount'] ?></td>
      <td>
        <a href="/admin/ingredients/<?= $i['id'] ?>/edit">edit</a>
        <form action="/admin/ingredients/<?= $i['id'] ?>/delete" method="post" style="display:inline">
          <button type="submit">delete</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
