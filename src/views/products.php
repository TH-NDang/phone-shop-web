<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Phone Shop</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
    }

    .product-card {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: transform 0.3s ease;
    }

    .product-card:hover {
      transform: translateY(-5px);
    }

    .product-image {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .product-info {
      padding: 15px;
    }

    .product-name {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .product-price {
      font-size: 16px;
      color: #e44d26;
      font-weight: bold;
    }

    .product-category {
      font-size: 14px;
      color: #777;
      margin-top: 5px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Our Products</h1>
    <div class="product-grid">
      <?php foreach ($products as $product): ?>
        <div class="product-card">
          <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
          <div class="product-info">
            <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
            <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
            <div class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>

</html>
