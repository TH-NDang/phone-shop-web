<div id="content" class="container">
  <h1>Our Products</h1>
  <div class="product-grid">
    <?php foreach ($products as $product): ?>
      <div class="product-card">
        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-card__image">
        <div class="product-card__info">
          <div class="product-card__name"><?php echo htmlspecialchars($product['name']); ?></div>
          <div class="product-card__price">$<?php echo number_format($product['price'], 2); ?></div>
          <div class="product-card__category"><?php echo htmlspecialchars($product['category_name']); ?></div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
