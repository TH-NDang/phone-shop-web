<?php

if (!isset($_SESSION['customer_id'])) {
    header('Location: /');
    exit();
}

require_once __DIR__ . '/../Models/Customer.php';
require_once __DIR__ . '/../Models/Order.php';

$customer_id = $_SESSION['customer_id'];

// Lấy thông tin người dùng
$customerModel = new Customer();
$customerResult = $customerModel->getCustomerById($customer_id);
$customer = $customerResult['data'] ?? null;

if (!$customer) {
    echo 'Không tìm thấy thông tin người dùng';
    exit();
}

// Lấy danh sách đơn hàng của người dùng
$orderModel = new Order();
$orders = $orderModel->getOrdersByCustomerId($customer_id);

$title = 'Trang cá nhân';
ob_start();
?>

<!-- Thêm top_nav.php -->
<?php include 'top_nav.php'; ?>
<!-- Thêm header.html -->
<?php include 'header.php'; ?>

<!-- Hiển thị thông tin khách hàng -->
<section class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Thông tin khách hàng</h1>
                <table class="table table-bordered" id="customer-table">
                    <tr>
                        <th>Họ và tên</th>
                        <td><?php echo htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']); ?></td>
                    </tr>
                    <tr>
                        <th>Tên đăng nhập</th>
                        <td><?php echo htmlspecialchars($customer['username']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($customer['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Số điện thoại</th>
                        <td><?php echo htmlspecialchars($customer['tel']); ?></td>
                    </tr>
                    <tr>
                        <th>Địa chỉ</th>
                        <td><?php echo htmlspecialchars($customer['address']); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Thêm footer -->
<?php include 'footer.php'; ?>

<?php
$content = ob_get_clean();
include 'base.php';
?>