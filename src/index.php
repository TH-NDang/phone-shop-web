<?php
require_once 'config.php';
require_once 'models/Product.php';

$retries = 5;
$retry_interval = 2; // seconds

while ($retries > 0) {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME,
            DB_USER,
            DB_PASS,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
        );
        break; // Successful connection, exit the loop
    } catch (PDOException $e) {
        $retries--;
        if ($retries == 0) {
            die("Connection failed after multiple attempts: " . $e->getMessage());
        }
        sleep($retry_interval);
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : 'home';

switch ($action) {
    case 'home':
        include 'views/home.php';
        break;
    case 'products':
        $productModel = new Product($pdo);
        $products = $productModel->getAll();
        include 'views/products.php';
        break;
    case 'about':
        // TODO: Create and include about page
        echo "About page";
        break;
    case 'contact':
        // TODO: Create and include contact page
        echo "Contact page";
        break;
    default:
        echo "404 Not Found";
        break;
}
