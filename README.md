# Phone Shop Project

## Tổng quan
Dự án Phone Shop là một ứng dụng web đơn giản được xây dựng bằng PHP, sử dụng mô hình MVC. Ứng dụng này cho phép người dùng xem danh sách sản phẩm điện thoại và thông tin chi tiết của chúng.

## Công nghệ sử dụng
- PHP 7.4
- MySQL 5.7
- Docker và Docker Compose
- HTML, CSS, JavaScript (với jQuery)

## Cài đặt

### Yêu cầu
- Docker
- Docker Compose

### Các bước cài đặt
1. Clone repository này về máy local của bạn.
2. Tạo file `.env` trong thư mục gốc của dự án với nội dung sau:
   ```
   MYSQL_HOST=db
   MYSQL_DATABASE=phone_shop
   MYSQL_PORT=3306
   MYSQL_USER=user
   MYSQL_PASSWORD=password
   ```
3. Mở terminal, di chuyển đến thư mục gốc của dự án.
4. Chạy lệnh sau để xây dựng và khởi động các container:
   ```
   docker-compose up --build -d
   ```
5. Đợi một vài phút để các container khởi động hoàn tất.

## Sử dụng
- Truy cập http://localhost để xem trang chủ của ứng dụng.
- Truy cập http://localhost/index.php?action=products để xem danh sách sản phẩm.
- Truy cập http://localhost:8080 để sử dụng phpMyAdmin (username: root, password: rootpassword).

## Cấu trúc dự án
```
phone-shop/
├── docker-compose.yml
├── Dockerfile
├── init.sql
├── .env
└── src/
    ├── config/
    │   └── config.php
    ├── controllers/
    ├── models/
    │   └── Product.php
    ├── views/
    │   ├── home.php
    │   └── products.php
    └── index.php
```

## Phát triển

### Thêm tính năng mới
1. Tạo controller mới trong thư mục `src/controllers/`.
2. Tạo model mới trong thư mục `src/models/` nếu cần.
3. Tạo view mới trong thư mục `src/views/`.
4. Cập nhật `src/index.php` để xử lý routing cho tính năng mới.

### Sửa đổi cơ sở dữ liệu
1. Cập nhật file `init.sql` với các thay đổi schema cần thiết.
2. Rebuild các container bằng lệnh:
   ```
   docker-compose down -v
   docker-compose up --build -d
   ```
