# 📱 Phone Shop Project

## 📋 Tổng quan

Dự án Phone Shop là một ứng dụng web đơn giản được xây dựng bằng PHP, sử dụng mô hình MVC. Ứng dụng này cho phép người dùng xem danh sách sản phẩm điện thoại và thông tin chi tiết của chúng.

## 🛠️ Công nghệ sử dụng

- PHP 8.3
- MySQL latest
- Docker và Docker Compose
- HTML, CSS, JavaScript (với jQuery)

## 🌐 Truy cập website

- Website: http://localhost
- phpMyAdmin: http://localhost:8080

### ⚙️ Yêu cầu

- Docker
- Docker Compose

## 📝 Sử dụng

- Truy cập http://localhost để xem trang chủ của ứng dụng.
- Truy cập http://localhost/index.php?action=products để xem danh sách sản phẩm.
- Truy cập http://localhost:8080 để sử dụng phpMyAdmin (username: root, password: rootpassword).

## 📂 Cấu trúc dự án

```
phone-shop-web/
├── public/              # Web root directory
│   ├── assets/         # Static files (images, js, css)
│   ├── css/           # CSS files
│   ├── index.php      # Entry point
│   └── .htaccess      # Apache configuration
├── src/                # Source code
│   ├── Config/        # Configuration files
│   ├── Controllers/   # Controllers
│   ├── Models/        # Models
│   ├── Views/         # Views
│   └── Helpers/       # Helper functions
├── docker-compose.yml  # Docker configuration
├── Dockerfile         # Docker build file
└── README.md          # Project documentation
```

## 🏅 Cảm ơn những người đóng góp

[![Contributors](https://contrib.rocks/image?repo=TH-NDang/phone-shop-web)](https://github.com/TH-NDang/phone-shop-web/graphs/contributors)

