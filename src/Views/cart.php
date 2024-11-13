<?php
$title = 'Giỏ hàng của bạn';
ob_start();
?>

<!-- thêm topnav -->
<?php include ROOT_DIR . '/src/Views/top_nav.php'; ?>
<!-- thêm header -->
<?php include ROOT_DIR . '/src/Views/header.php'; ?>

<section class="header">
    <div class="container" style="min-height: 85vh; padding: 20px;">
        <h1 style="margin-bottom: 20px;">Giỏ hàng của bạn</h1>

        <table id="cart-items" class="w-full" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f8f9fa;">
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Sản phẩm</th>
                    <th style="padding: 12px; text-align: right; border-bottom: 2px solid #dee2e6;">Giá</th>
                    <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Số lượng</th>
                    <th style="padding: 12px; text-align: right; border-bottom: 2px solid #dee2e6;">Tổng</th>
                    <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <!-- JavaScript sẽ render sản phẩm vào đây -->
            </tbody>
        </table>

        <div id="empty-cart-message" style="text-align: center; padding: 20px; display: none;">
            <p>Giỏ hàng của bạn đang trống</p>
            <a href="/" style="color: #007bff; text-decoration: none;">Tiếp tục mua sắm</a>
        </div>

        <div class="cart-summary" style="margin-top: 20px; text-align: right;">
            <h3>Tổng tiền: <span id="cart-total">0₫</span></h3>
            <?php if (isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated']): ?>
                <button onclick="window.location.href='/checkout'" style="
                    background-color: #28a745;
                    color: white;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 16px;
                    margin-top: 10px;">
                    Tiến hành thanh toán
                </button>
            <?php else: ?>
                <p style="color: #666;">Vui lòng <a href="#" onclick="checkLogin()" style="color: #007bff;">đăng nhập</a> để
                    tiến hành thanh toán</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- thêm footer -->
<?php include ROOT_DIR . '/src/Views/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Khởi tạo giỏ hàng
        CartManager.initCart();

        // Kiểm tra và hiển thị thông báo giỏ hàng trống
        const cart = CartManager.getCart();
        const emptyCartMessage = document.getElementById('empty-cart-message');
        if (cart.length === 0 && emptyCartMessage) {
            emptyCartMessage.style.display = 'block';
        }
    });
</script>

<?php
$content = ob_get_clean();
include ROOT_DIR . '/src/Views/base.php';
?>

