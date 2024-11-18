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
                        <img src="data:image/png;base64,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">
                        <div>MIỄN PHÍ GIAO HÀNG TOÀN QUỐC</div>
                    </div>

                    <div class="area_promo">
                        <strong>Khuyến mãi</strong>
                        <div class="promo">
                            <img src="/assets/store/chitietsanpham/warranty.png">
                            <div>Giảm thêm đến 500.000đ khi thanh toán qua VNPAY</div>
                        </div>
                        <div class="promo">
                            <img src="/assets/store/chitietsanpham/warranty.png">
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

