CREATE DATABASE IF NOT EXISTS phone_shop_web;
USE phone_shop_web;
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    image_url VARCHAR(255)
);
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
CREATE TABLE IF NOT EXISTS product_category (
    product_id INT,
    category_id INT,
    PRIMARY KEY (product_id, category_id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
-- Insert sample data
INSERT INTO categories (name)
VALUES ('Smartphone'),
    ('Tablet'),
    ('Accessory');
INSERT INTO products (name, description, price, stock, image_url)
VALUES (
        'iPhone 12',
        'Apple iPhone 12 with A14 Bionic chip',
        799.99,
        50,
        'iphone12.jpg'
    ),
    (
        'Samsung Galaxy S21',
        'Samsung Galaxy S21 with 5G support',
        699.99,
        30,
        'galaxys21.jpg'
    ),
    (
        'iPad Air',
        'Apple iPad Air with 10.9-inch display',
        599.99,
        25,
        'ipadair.jpg'
    ),
    (
        'AirPods Pro',
        'Apple AirPods Pro with Active Noise Cancellation',
        249.99,
        100,
        'airpodspro.jpg'
    );
INSERT INTO product_category (product_id, category_id)
VALUES (1, 1),
    (2, 1),
    (3, 2),
    (4, 3);
INSERT INTO users (username, password, email)
VALUES (
        'john_doe',
        'hashed_password',
        'john@example.com'
    );
