<?php
$title = 'Tìm kiếm sản phẩm';
ob_start();
?>
<!-- thêm topnav -->
<?php include 'top_nav.php'; ?>
<!-- thêm header -->
<?php include 'header.php'; ?>
<!-- thêm filter -->
<?php include 'filter.php'; ?>

<section class="header">
   <h2> Tất cả sản phẩm</h2>
   <ul id="products" class="homeproduct group flexContain">
     <button id="loadMore" class="xemTatCa" href="/?star=3&amp;sort=rateCount-decrease" style="border-left: 2px solid #ff9c00; border-right: 2px solid #ff9c00;">
              Xem thêm
     </button>
   </ul><!-- End products -->
   <script>
      var params = new URLSearchParams(window.location.search);
      var keyword = params.get('keyword');
  
      // Gọi hàm displayProducts với keyword là đối số
      displayProducts(keyword);
   </script>
</section>
<!-- thêm footer -->
<?php include 'footer.php'; ?>
<?php
$content = ob_get_clean();
include 'base.php';
?>