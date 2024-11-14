<!-- thay đổi title -->
<?php
$title = 'Trang cá nhân';
ob_start();
?>
<!-- thêm top_nav.php -->
<?php include 'top_nav.php'; ?>
<!-- thêm header.html -->
<?php include 'header.php'; ?>
<!-- hiện thông tin khách hàng -->
<section class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Thông tin khách hàng</h1>
                <!-- Thêm id "customer-table" vào thẻ table -->
                <table class="table table-bordered" id="customer-table">
                    <tr>
                        <th>Họ và tên</th>
                        <td>{{customer.last_name}} {{customer.first_name}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{customer.email}}</td>
                    </tr>
                    <tr>
                        <th>Số điện thoại</th>
                        <td>{{customer.tel}}</td>
                    </tr>
                    <tr>
                        <th>Địa chỉ</th>
                        <td>{{customer.address}}</td>
                    </tr>
                </table>
                <div id="changeInfoContainer">
                    <!-- Thêm nút và pop-up form để đổi mật khẩu -->
                    <div id="passwordChangeContainer">
                        <button id="changePasswordButton" onclick="openPasswordChangePopup()">Đổi Mật Khẩu</button>
                        <div id="passwordChangePopup" class="change-info-popup" style="display:none;">
                            <form onsubmit="changePassword(event)">
                                <label for="old_password">Mật khẩu cũ:</label><br>
                                <input type="password" id="old_password" name="old_password" required>
                                <i onclick="togglePasswordVisibility('old_password')" class="eye-icon"></i><br>
                                <label for="new_password">Mật khẩu mới:</label><br>
                                <input type="password" id="new_password" name="new_password" required>
                                <i onclick="togglePasswordVisibility('new_password')" class="eye-icon"></i><br>
                                <label for="confirm_password">Xác nhận mật khẩu mới:</label><br>
                                <input type="password" id="confirm_password" name="confirm_password" required>
                                <i onclick="togglePasswordVisibility('confirm_password')" class="eye-icon"></i><br>
                                <input type="submit" value="Xác nhận">
                                <button onclick="closePasswordChangePopup()">Hủy bỏ</button>
                            </form>
                        </div>
                    </div>

                    <!-- Thêm nút và pop-up form để sửa số điện thoại -->
                    <div id="phoneNumberChangeContainer">
                        <button id="editPhoneNumberButton" onclick="openPhoneNumberEditPopup()">Sửa Số Điện Thoại</button>
                        <div id="phoneNumberChangePopup" class="change-info-popup" style="display:none;">
                            <form onsubmit="changePhoneNumber(event)">
                                <label for="new_phone_number">Số điện thoại mới:</label><br>
                                <input type="text" id="new_phone_number" name="new_phone_number" required><br>
                                <input type="submit" value="Xác nhận">
                                <button onclick="closePhoneNumberChangePopup()">Hủy bỏ</button>
                            </form>
                        </div>
                    </div>

                    <!-- Thêm nút và pop-up form để sửa địa chỉ -->
                    <div id="addressChangeContainer">
                        <button id="editAddressButton" onclick="openAddressEditPopup()">Sửa Địa Chỉ</button>
                        <div id="addressChangePopup" class="change-info-popup" style="display:none;">
                            <form onsubmit="changeAddress(event)">
                                <label for="city">Thành phố/Tỉnh:</label><br>
                                <select id="city" name="city" onchange="updateDistricts()" required></select><br>
                                
                                <label for="district">Quận/Huyện:</label><br>
                                <select id="district" name="district" onchange="updateWards()" required></select><br>
                                
                                <label for="ward">Xã/Phường:</label><br>
                                <select id="ward" name="ward" required></select><br>
                                
                                <label for="new_address">Địa chỉ cụ thể:</label><br>
                                <input type="text" id="new_address" name="new_address" required><br>
                                
                                <input type="submit" value="Xác nhận">
                                <button type="button" onclick="closeAddressChangePopup()">Hủy bỏ</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
                <table class="table table-bordered" id="product-table">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Ngày đặt hàng</th>
                            <th>Trạng thái giao hàng</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for order_id, products in orders.items %}
                            {% for product in products %}
                                <tr>
                                    <td>{{ product.ten_san_pham }}</td>
                                    <td>{{ product.so_luong }}</td>
                                    <td>{{ product.gia }} VND</td>
                                    <td>{{ product.ngay_dat_hang|date:"d/m/Y H:i" }}</td>
                                    <td>{% if product.trang_thai_giao_hang %}Đã giao{% else %}Chưa giao{% endif %}</td>
                                </tr>
                            {% endfor %}
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>

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