
<?php
require_once '../config.php';
require_once '../models/Product.php';

$pdo = new PDO(
    "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME,
    DB_USER,
    DB_PASS,
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
);

$productModel = new Product($pdo);
$products = $productModel->getAll();

foreach ($products as $product) {
    echo '<div class="product-card">';
    echo '<img src="' . htmlspecialchars($product['image_url']) . '" alt="' . htmlspecialchars($product['name']) . '" class="product-card__image">';
    echo '<div class="product-card__info">';
    echo '<div class="product-card__name">' . htmlspecialchars($product['name']) . '</div>';
    echo '<div class="product-card__price">$' . number_format($product['price'], 2) . '</div>';
    echo '<div class="product-card__category">' . htmlspecialchars($product['category_name']) . '</div>';
    echo '</div>';
    echo '</div>';
}
