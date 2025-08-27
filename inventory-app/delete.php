<?php
require 'functions.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $product = getProductById($id);
    if ($product && $product['image'] && file_exists("uploads/" . $product['image'])) {
        unlink("uploads/" . $product['image']);
    }
    deleteProduct($id);
}

header("Location: index.php");
exit;
?>

