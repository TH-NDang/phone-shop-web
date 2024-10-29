<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title ?? 'Default Title'; ?></title>
    <link rel="icon" href="path/to/your/favicon.ico" />
    <!-- Load font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- owl carousel libraries -->
    <link rel="stylesheet" href="assets/js/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/js/owlcarousel/owl.theme.default.min.css">
    <script src="assets/js/Jquery/jquery.min.js"></script>
    <script src="assets/js/owlcarousel/owl.carousel.min.js"></script>
    <!-- tidio - live chat -->
    <!-- <script src="//code.tidio.co/bfiiplaaohclhqwes5xivoizqkq56guu.js"></script> -->

    <!-- our files -->
    <!-- css -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/topnav.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/banner.css">
    <link rel="stylesheet" href="css/taikhoan.css">
    <link rel="stylesheet" href="css/trangchu.css">
    <link rel="stylesheet" href="css/home_products.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/baohanh.css">
    <link rel="stylesheet" href="css/lienhe.css">
    <link rel="stylesheet" href="css/chitietsanpham.css">
    <link rel="stylesheet" href="css/gioHang.css">
    <link rel="stylesheet" href="css/nguoidung.css">
    <!-- js -->
    <script src="assets/js/getProduct.js"></script>
    <script src="assets/js/search.js"></script>
    <script src="assets/js/account.js"></script>
    <script src="assets/js/cart.js"></script>
</head>

<body>
    <?php echo $content ?? ''; ?>
    <script src="assets/js/filter.js"></script>
</body>

</html>