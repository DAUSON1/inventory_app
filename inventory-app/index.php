<?php
require_once 'functions.php';
$products = getProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Inventory Management</title>
  <link rel="stylesheet" href="styles.css">
</head>
<style>
    body {
  font-family: Arial, sans-serif;
  background: #f5f5f5;
}

.container {
  width: 80%;
  margin: auto;
  background: #fff;
  padding: 20px;
  margin-top: 40px;
  border-radius: 8px;
  box-shadow: 0 0 10px #ccc;
}

h1 {
  text-align: center;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

table, th, td {
  border: 1px solid #ddd;
}

th, td {
  padding: 10px;
  text-align: center;
}

.btn {
  display: inline-block;
  padding: 8px 12px;
  margin-top: 10px;
  background: #28a745;
  color: white;
  text-decoration: none;
  border-radius: 4px;
}

.btn:hover {
  background: #218838;
}

form {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

</style>
<body>
<div class="container">
  <h1>Inventory Management</h1>
  <a class="btn" href="add_edit.php">➕ Add Product</a>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Name</th><th>Quantity</th><th>Price</th><th>Image</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $p): ?>
        <tr>
          <td><?= $p['id'] ?></td>
          <td><?= htmlspecialchars($p['name']) ?></td>
          <td><?= $p['quantity'] ?></td>
          <td>$<?= $p['price'] ?></td>
          <td>
            <?php if ($p['image']): ?>
              <img src="uploads/<?= htmlspecialchars($p['image']) ?>" width="60">
            <?php endif; ?>
          </td>
          <td>
            <a href="add_edit.php?id=<?= $p['id'] ?>">✏ Edit</a> | 
            <a href="delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Delete this product?')">🗑 Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>
