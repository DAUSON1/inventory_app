<?php
require_once 'functions.php';

$id = $_GET['id'] ?? null;
$product = $id ? getProduct($id) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $image = $product['image'] ?? null;

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            if ($product && $product['image'] && file_exists("uploads/" . $product['image'])) {
                unlink("uploads/" . $product['image']);
            }
            $image = $imageName;
        }
    }

    if ($id) {
        updateProduct($id, $name, $quantity, $price, $image);
    } else {
        addProduct($name, $quantity, $price, $image);
    }

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $id ? 'Edit' : 'Add' ?> Product</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
  <h1><?= $id ? 'Edit' : 'Add' ?> Product</h1>
  <form method="post" enctype="multipart/form-data">
    <label>Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name'] ?? '') ?>" required>
    <label>Quantity:</label>
    <input type="number" name="quantity" value="<?= htmlspecialchars($product['quantity'] ?? '') ?>" required>
    <label>Price:</label>
    <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($product['price'] ?? '') ?>" required>
    <label>Image:</label>
    <input type="file" name="image">
    <?php if ($product && $product['image']): ?>
      <img src="uploads/<?= htmlspecialchars($product['image']) ?>" width="80">
    <?php endif; ?>
    <button type="submit">💾 Save</button>
  </form>
  <a class="btn" href="index.php">⬅ Back</a>
</div>
</body>
</html>
