<?php
require_once __DIR__ . '/../Config/Database.php';

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllProducts($page = 1, $limit = 10)
    {
        try {
            $offset = ($page - 1) * $limit;

            $sql = "SELECT p.*, b.name as brand_name 
                    FROM product p 
                    LEFT JOIN phone_brands b ON p.brand_id = b.id 
                    ORDER BY p.product_id 
                    LIMIT ? OFFSET ?";

            $stmt = $this->db->query($sql, [(int) $limit, (int) $offset]);
            $products = $stmt->fetchAll();

            return [
                'status' => 'success',
                'data' => array_map(function ($product) {
                    return [
                        'product_id' => $product['product_id'],
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'image' => $this->formatImageUrl($product['image']),
                        'brand_name' => $product['brand_name'],
                        'description' => $product['description'] ?? ''
                    ];
                }, $products)
            ];

        } catch (Exception $e) {
            error_log("Error in getAllProducts: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getAllBrands()
    {
        try {
            $sql = "SELECT * FROM phone_brands";
            $stmt = $this->db->query($sql);
            $brands = $stmt->fetchAll();

            return [
                'status' => 'success',
                'data' => $brands
            ];
        } catch (Exception $e) {
            error_log("Error in getAllBrands: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getProductsByBrand($brandName)
    {
        try {
            $sql = "SELECT p.*, b.name as brand_name 
                    FROM product p
                    JOIN phone_brands b ON p.brand_id = b.id 
                    WHERE b.name LIKE ?";

            $stmt = $this->db->query($sql, ["%$brandName%"]);
            $products = $stmt->fetchAll();

            return [
                'status' => 'success',
                'data' => array_map(function ($product) {
                    return [
                        'product_id' => $product['product_id'],
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'image' => $this->formatImageUrl($product['image']),
                        'brand_name' => $product['brand_name'],
                        'description' => $product['description'] ?? ''
                    ];
                }, $products)
            ];

        } catch (Exception $e) {
            error_log("Error in getProductsByBrand: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => []
            ];
        }
    }

    private function formatImageUrl($url)
    {
        if (empty($url))
            return '/assets/store/products/default.jpg';
        return strpos($url, '/') === 0 ? $url : '/' . $url;
    }
}
