<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Phone Shop - Home</title>
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body class="page">
  <?php include 'header.php' ?>
  <div id="content" class="container">
    <div class="hero">
      <div class="container">
        <h1 class="hero__title">Welcome to Phone Shop</h1>
        <p>Discover the latest smartphones and accessories</p>
        <a class="hero__cta-button">Shop Now</a>
      </div>
    </div>
    <div class="container">
      <h2>Featured Products</h2>
      <!-- Add featured products here -->
    </div>
  </div>
  <?php include 'footer.php' ?>

  <script>
    $(function() {
      var currentAction = window.location.search.split('action=')[1] || 'home';

      $(".header__nav-link").click(function(e) {
        e.preventDefault();
        var action = $(this).data("action");

        if (action !== currentAction) {
          currentAction = action;

          let replacePart = action === 'home' ? ".page" : "#content";
          $(replacePart).load("index.php?action=" + action);
          window.history.pushState(null, null, "index.php?action=" + action);
        }
      });

      // Handle the initial page load
      if (currentAction !== 'home') {
        $(".page").load("index.php?action=" + currentAction);
      }

      // Handle browser back/forward buttons
      window.onpopstate = function() {
        var action = window.location.search.split('action=')[1] || 'home';
        if (action !== currentAction) {
          currentAction = action;
          $("#content").load("index.php?action=" + action);
        }
      };
    });
  </script>
</body>

</html>
