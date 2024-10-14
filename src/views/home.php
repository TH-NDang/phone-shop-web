<?php
$title = 'Thế giới điện thoại - Home Page';
ob_start();
?>

<!-- thêm top_nav.php -->
<?php include 'top_nav.php'; ?>
<!-- thêm header.html -->
<?php include 'header.php'; ?>
<!-- thêm banner -->
<?php include 'banner.php'; ?>
<!-- thêm filter -->
<?php include 'filter.php'; ?>
<script>
   //lấy dữ liệu brand
   fetch('/api/brands/')
      .then(response => response.json())
      .then(data => {
         var companyMenu = document.querySelector('.companyMenu');
         data.forEach(function (brand) {
            let img = document.createElement('img');
            img.src = brand.image_url;
            img.alt = brand.name; // thêm tên ảnh vào thuộc tính alt
            img.title = brand.name; // thêm tên ảnh vào thuộc tính title
            companyMenu.appendChild(img);
            // thêm sự kiện click vào thẻ img
            img.addEventListener('click', function () {
               // Gọi hàm với tham số là api/search/?keyword= cộng với tên thương hiệu
               displayProducts(brand.name);
            });
         });
      })
      .catch(error => console.error('Error:', error));
</script>
<!-- thêm contain_product -->
<?php include 'contain_product.php'; ?>
<!-- thêm footer -->
<?php include 'footer.php'; ?>
<?php
$content = ob_get_clean();
include 'base.php';
?>