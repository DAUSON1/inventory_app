<?php
require_once 'config.php';

// Create PDO connection
function getDB() {
    static $pdo;
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    return $pdo;
}

// Get all products
function getProducts() {
    $stmt = getDB()->query("SELECT * FROM products ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get single product by ID
function getProduct($id) {
    $stmt = getDB()->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Add product
function addProduct($name, $quantity, $price, $image) {
    $stmt = getDB()->prepare("INSERT INTO products (name, quantity, price, image) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $quantity, $price, $image]);
}

// Update product
function updateProduct($id, $name, $quantity, $price, $image = null) {
    if ($image) {
        $stmt = getDB()->prepare("UPDATE products SET name=?, quantity=?, price=?, image=? WHERE id=?");
        return $stmt->execute([$name, $quantity, $price, $image, $id]);
    } else {
        $stmt = getDB()->prepare("UPDATE products SET name=?, quantity=?, price=? WHERE id=?");
        return $stmt->execute([$name, $quantity, $price, $id]);
    }
}

// Delete product
function deleteProduct($id) {
    $product = getProduct($id);
    if ($product && $product['image'] && file_exists("uploads/" . $product['image'])) {
        unlink("uploads/" . $product['image']);
    }
    $stmt = getDB()->prepare("DELETE FROM products WHERE id=?");
    return $stmt->execute([$id]);
}
