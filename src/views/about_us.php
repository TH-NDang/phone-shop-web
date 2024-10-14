<?php
$title = 'Thế giới điện thoại - About Us';
ob_start();
?>

<!-- nội dung trong thẻ body -->
<!-- thêm topnav -->
<?php include 'top_nav.php'; ?>
    <!-- thêm header -->
<?php include 'header.php'; ?>
 <section class="header">
    <div class="container mt-5 vh-100">
        <h1>Giới thiệu</h1>
        <p>Chúng tôi là một công ty chuyên cung cấp các sản phẩm và dịch vụ chất lượng cao cho khách hàng. Mục tiêu của chúng tôi là vượt quá mong đợi của khách hàng bằng cách cung cấp giá trị và dịch vụ đặc biệt.</p>
        <h2>Thành viên</h2>
        <style>
            .row {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }
            
            .col-md-3 {
                flex: 0 0 calc(25% - 20px);
                margin-bottom: 20px;
                text-align: center;
            }
            
            .col-md-3 img {
                width: 100%;
                height: auto;
            }
            
            .col-md-3 h4 {
                margin-top: 10px;
            }
        </style>
        <div class="row">
            <div class="col-md-3">
                <a target="_blank" href="assets/store/about_us/img1.jpg">
                    <img src="assets/store/about_us/img1.jpg" class="rounded-circle">
                </a>
                <h4>Nguyễn Ngọc Đặng</h4>
                <!-- <p>CFO</p> -->
            </div>
            <div class="col-md-3">
                <a target="_blank" href="assets/store/about_us/img1.jpg">
                    <img src="assets/store/about_us/img1.jpg" class="rounded-circle">
                </a>
                <h4>Nguyễn Ngọc Tâm</h4>
                <!-- <p>CTO</p> -->
            </div>
        </div>
    </div>
 </section>
<!-- thêm footer -->
<?php include 'footer.php'; ?>
<?php
$content = ob_get_clean();
include 'base.php';
?>