<?php
$title = 'Thế giới điện thoại - ' . ($product['name'] ?? 'Chi tiết sản phẩm');
ob_start();
?>

<!-- thêm topnav -->
<?php include 'top_nav.php'; ?>
<!-- thêm header -->
<?php include 'header.php'; ?>

<section class="header">
    <div class="chitietSanpham">
        <?php if (isset($product) && $product): ?>
            <!-- Header -->
            <h1><?= htmlspecialchars($product['name']) ?></h1>
            <div class="rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i>
                <span> <?= rand(10, 1000) ?> đánh giá</span>
            </div>

            <!-- Body -->
            <div class="rowdetail">
                <!-- Bên trái -->
                <div class="picture">
                    <img src="<?= htmlspecialchars($product['image']) ?>" onclick="openModal()">
                </div>

                <!-- Bên phải -->
                <div class="price_sale">
                    <div class="area_price">
                        <strong><?= number_format($product['price'], 0, ',', '.') ?>₫</strong>
                        <?php if (isset($product['old_price'])): ?>
                            <span><?= number_format($product['old_price'], 0, ',', '.') ?>₫</span>
                        <?php endif; ?>
                        <label class="giamgia">Giảm <?= rand(5, 50) ?>%</label>
                    </div>

                    <div class="ship">
                        <img src="/assets/store/chitietsanpham/ship.png">
                        <div>MIỄN PHÍ GIAO HÀNG TOÀN QUỐC</div>
                    </div>

                    <div class="area_promo">
                        <strong>Khuyến mãi</strong>
                        <div class="promo">
                            <img src="/assets/store/chitietsanpham/icon-tick.png">
                            <div>Giảm thêm đến 500.000đ khi thanh toán qua VNPAY</div>
                        </div>
                        <div class="promo">
                            <img src="/assets/store/chitietsanpham/icon-tick.png">
                            <div>Giảm thêm 5% tối đa 500.000đ khi trả góp qua thẻ tín dụng</div>
                        </div>
                    </div>

                    <div class="area_order">
                        <a class="buy_now" onclick="themVaoGioHang(<?= $product['product_id'] ?>);">
                            <b>THÊM VÀO GIỎ HÀNG</b>
                            <p>Giao hàng miễn phí hoặc nhận tại shop</p>
                        </a>
                    </div>

                    <div class="policy">
                        <div>
                            <img src="/assets/store/chitietsanpham/box.png">
                            <p>Trong hộp có: Sạc, Tai nghe, Sách hướng dẫn, Cây lấy sim, Ốp lưng </p>
                        </div>
                        <div>
                            <img src="/assets/store/chitietsanpham/warranty.png">
                            <p>Bảo hành chính hãng 12 tháng.</p>
                        </div>
                        <div class="last">
                            <img src="/assets/store/chitietsanpham/refresh.png">
                            <p>1 đổi 1 trong 1 tháng nếu lỗi, đổi sản phẩm tại nhà trong 1 ngày.</p>
                        </div>
                    </div>
                </div>

                <!-- Thông số kỹ thuật -->
                <div class="info_product">
                    <h2>Thông số kỹ thuật</h2>
                    <ul class="info">
                        <li>
                            <p>Màn hình</p>
                            <div><?= htmlspecialchars($product['screen']) ?></div>
                        </li>
                        <li>
                            <p>CPU</p>
                            <div><?= htmlspecialchars($product['cpu']) ?></div>
                        </li>
                        <li>
                            <p>RAM</p>
                            <div><?= htmlspecialchars($product['ram']) ?></div>
                        </li>
                        <li>
                            <p>Bộ nhớ trong</p>
                            <div><?= htmlspecialchars($product['rom']) ?></div>
                        </li>
                        <li>
                            <p>Camera sau</p>
                            <div><?= htmlspecialchars($product['camera']) ?></div>
                        </li>
                        <li>
                            <p>Pin</p>
                            <div><?= htmlspecialchars($product['battery']) ?></div>
                        </li>
                        <li>
                            <p>Hệ điều hành</p>
                            <div><?= htmlspecialchars($product['os']) ?></div>
                        </li>
                        <li>
                            <p>Xuất xứ</p>
                            <div><?= htmlspecialchars($product['origin']) ?></div>
                        </li>
                        <li>
                            <p>Năm sản xuất</p>
                            <div><?= htmlspecialchars($product['year']) ?></div>
                        </li>
                    </ul>
                </div>

                <!-- Mô tả sản phẩm -->
                <div class="description">
                    <h2>Mô tả sản phẩm</h2>
                    <div class="description-content">
                        <?= nl2br(htmlspecialchars($product['description'])) ?>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="empty-product">
                <h2>Không tìm thấy sản phẩm</h2>
                <p>Sản phẩm không tồn tại hoặc đã bị xóa.</p>
                <a href="/" class="btn-back">Quay lại trang chủ</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Modal xem ảnh lớn -->
<div id="modalImg" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="img01">
</div>

<script>
    // Modal
    function openModal() {
        document.getElementById("modalImg").style.display = "block";
        document.getElementById("img01").src = document.querySelector(".picture img").src;
    }

    function closeModal() {
        document.getElementById("modalImg").style.display = "none";
    }
</script>

<!-- CSS cho modal -->
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    .close {
        position: absolute;
        right: 35px;
        top: 15px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }
</style>

<?php include 'footer.php'; ?>
<?php
$content = ob_get_clean();
include 'base.php';
?>

