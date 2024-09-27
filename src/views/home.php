<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Phone Shop - Home</title>
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

    header {
      background-color: #333;
      color: #fff;
      padding: 10px 0;
    }

    nav ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
      display: flex;
      justify-content: center;
    }

    nav ul li {
      margin: 0 10px;
    }

    nav ul li a {
      color: #fff;
      text-decoration: none;
    }

    .hero {
      background-color: #e44d26;
      color: #fff;
      text-align: center;
      padding: 50px 0;
      margin-bottom: 30px;
    }

    .hero h1 {
      font-size: 36px;
      margin-bottom: 20px;
    }

    .cta-button {
      display: inline-block;
      background-color: #fff;
      color: #e44d26;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <header>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="index.php?action=products">Products</a></li>
        <li><a href="index.php?action=about">About</a></li>
        <li><a href="index.php?action=contact">Contact</a></li>
      </ul>
    </nav>
  </header>
  <div class="hero">
    <div class="container">
      <h1>Welcome to Phone Shop</h1>
      <p>Discover the latest smartphones and accessories</p>
      <a href="index.php?action=products" class="cta-button">Shop Now</a>
    </div>
  </div>
  <div class="container">
    <h2>Featured Products</h2>
    <!-- Add featured products here -->
  </div>
</body>

</html>
