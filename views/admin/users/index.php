<!doctype html><meta charset="utf-8">
<h2>Users</h2>
<p><a href="/admin/users/create">Create</a></p>
<table  cellpadding="6">
  <tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Actions</th></tr>
  <?php foreach ($users as $u): ?>
    <tr>
      <td><?= $u['id'] ?></td>
      <td><?= htmlspecialchars($u['name']) ?></td>
      <td><?= htmlspecialchars($u['email']) ?></td>
      <td><?= (int)$u['role_id'] ?></td>
      <td>
        <a href="/admin/users/<?= $u['id'] ?>/edit">edit</a>
        <form action="/admin/users/<?= $u['id'] ?>/delete" method="post" style="display:inline">
          <button type="submit">delete</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
