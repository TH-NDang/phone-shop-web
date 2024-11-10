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

    public function getProductById($productId)
    {
        try {
            $sql = "SELECT p.*, b.name as brand_name 
                FROM product p
                LEFT JOIN phone_brands b ON p.brand_id = b.id 
                WHERE p.product_id = ?";

            $stmt = $this->db->query($sql, [(int) $productId]);
            $product = $stmt->fetch();

            if (!$product) {
                return [
                    'status' => 'error',
                    'message' => 'Product not found',
                    'data' => null
                ];
            }

            // Format product data
            $formattedProduct = [
                'product_id' => $product['product_id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'old_price' => isset($product['old_price']) ? $product['old_price'] : null,
                'image' => $this->formatImageUrl($product['image']),
                'brand_name' => $product['brand_name'],
                'description' => $product['description'],
                'screen' => $product['screen'],
                'cpu' => $product['cpu'],
                'ram' => $product['ram'],
                'rom' => $product['rom'],
                'camera' => $product['camera'],
                'battery' => $product['battery'],
                'os' => $product['os'],
                'origin' => $product['origin'],
                'year' => $product['year']
            ];

            return [
                'status' => 'success',
                'data' => $formattedProduct
            ];

        } catch (Exception $e) {
            error_log("Error in getProductById: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => null
            ];
        }
    }

    public function searchByName($keyword)
    {
        try {
            // Chuẩn bị câu truy vấn
            $sql = "SELECT * FROM product WHERE name LIKE ?";
            $stmt = $this->db->query($sql, ['%' . $keyword . '%']);

            // Lấy kết quả
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'status' => 'success',
                'products' => $results
            ];
        } catch (PDOException $e) {
            error_log("Error in searchByName: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    public function filterProducts($priceRange, $sortOrder, $ram, $rom)
    {
        try {
            $sql = "SELECT * FROM product WHERE 1=1";
            error_log("Filter Parameters - Price Range: $priceRange, Sort Order: $sortOrder, RAM: $ram, ROM: $rom");
            // Lọc theo giá tiền
            if (!empty($priceRange)) {
                list($minPrice, $maxPrice) = explode('-', $priceRange);
                $sql .= " AND price BETWEEN $minPrice AND $maxPrice";
            }

            // Sắp xếp theo giá
            if (!empty($sortOrder)) {
                if ($sortOrder == 'asc') {
                    $sql .= " ORDER BY price ASC";
                } elseif ($sortOrder == 'desc') {
                    $sql .= " ORDER BY price DESC";
                }
            }

            // Lọc theo RAM
            if (!empty($ram)) {
                $sql .= " AND ram = $ram";
            }

            // Lọc theo ROM
            if (!empty($rom)) {
                $sql .= " AND rom = $rom";
            }

            // Ghi câu lệnh truy vấn vào log
            error_log("SQL Query: " . $sql);
            $stmt = $this->db->query($sql);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'status' => 'success',
                'data' => $products
            ];
        } catch (Exception $e) {
            error_log("Error in filterProducts: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => []
            ];
        }
    }
}

