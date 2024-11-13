<?php
require_once __DIR__ . '/../Models/Product.php';

class ApiController
{
    private $db;
    private $product;
    private $customer;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->customer = new Customer();
        $this->product = new Product();
    }

    public function handleRequest()
    {
        try {
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
            $segments = explode('/', trim($path, '/'));

            if ($segments[0] === 'api') {
                header('Content-Type: application/json');

                switch ($segments[1]) {
                    case 'auth':
                        switch ($segments[2] ?? '') {
                            case 'login':
                                $this->handleLogin();
                                break;
                            case 'register':
                                $this->handleRegister();
                                break;
                            case 'logout':
                                $this->handleLogout();
                                break;
                            default:
                                $this->sendResponse(404, ['status' => 'error', 'message' => 'Route không tồn tại']);
                                break;
                        }
                        break;
                    case 'customer':
                        if (!isset($_SESSION['customer_id'])) {
                            $this->sendResponse(401, ['status' => 'error', 'message' => 'Chưa đăng nhập']);
                            return;
                        }

                        switch ($segments[2] ?? '') {
                            case 'profile':
                                $this->handleCustomerProfile();
                                break;
                            case 'update':
                                $this->handleCustomerUpdate();
                                break;
                            case 'change-password':
                                $this->handlePasswordChange();
                                break;
                            default:
                                $this->sendResponse(404, ['status' => 'error', 'message' => 'Route không tồn tại']);
                                break;
                        }
                        break;
                    case 'cart':
                        switch ($segments[2] ?? '') {
                            case 'get':
                                $this->handleGetCart();
                                break;
                            case 'sync':
                                $this->handleSyncCart();
                                break;
                            default:
                                $this->sendResponse(404, [
                                    'status' => 'error',
                                    'message' => 'Route không tồn tại'
                                ]);
                                break;
                        }
                        break;
                    case 'products':
                        if (isset($segments[2])) {
                            if ($segments[2] === 'detail' && isset($segments[3])) {
                                $this->handleProductDetail($segments[3]);
                            } else {
                                $this->handleProducts($segments);
                            }
                        }
                        break;

                    case 'brands':
                        $this->handleBrands();
                        break;

                    case 'search':
                        $this->handleSearch();
                        break;
                    case 'filter':
                        $this->handleFilter();
                        break;

                    default:
                        $this->sendResponse(404, [
                            'status' => 'error',
                            'message' => 'Not found',
                            'data' => []
                        ]);
                        break;
                }
            }
        } catch (Exception $e) {
            $this->sendResponse(500, [
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    private function handleProducts($segments)
    {
        if (isset($segments[2])) {
            $page = intval($segments[2]);
            $result = $this->product->getAllProducts($page);
            $this->sendResponse(200, $result);
        } else {
            $this->sendResponse(400, [
                'status' => 'error',
                'message' => 'Page number required',
                'data' => []
            ]);
        }
    }

    private function handleBrands()
    {
        $result = $this->product->getAllBrands();
        $this->sendResponse(200, $result);
    }

    private function handleSearch()
    {
        if (isset($_GET['keyword'])) {
            $result = $this->product->searchByName($_GET['keyword']);
            $this->sendResponse(200, $result);
        } elseif (isset($_GET['brand'])) {
            $result = $this->product->getProductsByBrand($_GET['brand']);
            $this->sendResponse(200, $result);
        } else {
            $this->sendResponse(400, [
                'status' => 'error',
                'message' => 'Search parameter required',
                'data' => []
            ]);
        }
    }

    private function sendResponse($statusCode, $data)
    {
        http_response_code($statusCode);
        echo json_encode($data);
        exit();
    }

    private function handleProductDetail($productId)
    {
        $result = $this->product->getProductById($productId);

        if ($result['status'] === 'success') {
            $this->sendResponse(200, $result);
        } else {
            $this->sendResponse(404, $result);
        }
    }

    private function handleProductsByBrand($brandName)
    {
        $result = $this->product->getProductsByBrand($brandName);
        if ($result['status'] === 'success') {
            $this->sendResponse(200, $result);
        } else {
            $this->sendResponse(404, $result);
        }
    }

    private function handleFilter()
    {
        $priceRange = isset($_GET['data-price']) ? $_GET['data-price'] : '';
        $sortOrder = isset($_GET['sort-filter']) ? $_GET['sort-filter'] : '';
        $ram = isset($_GET['ram-filter']) ? $_GET['ram-filter'] : '';
        $rom = isset($_GET['rom-filter']) ? $_GET['rom-filter'] : '';

        // Ghi các tham số vào log để kiểm tra
        error_log("Received Filter Parameters - Price Range: $priceRange, Sort Order: $sortOrder, RAM: $ram, ROM: $rom");

        $result = $this->product->filterProducts($priceRange, $sortOrder, $ram, $rom);
        $this->sendResponse(200, $result);
    }

    private function handleLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendResponse(405, ['status' => 'error', 'message' => 'Method không được hỗ trợ']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['email']) || !isset($data['password'])) {
            $this->sendResponse(400, ['status' => 'error', 'message' => 'Thiếu thông tin đăng nhập']);
            return;
        }

        $result = $this->customer->login($data['email'], $data['password']);

        if ($result['status'] === 'success') {
            $_SESSION['customer_id'] = $result['data']['customers_id'];
            $_SESSION['customer_email'] = $result['data']['email'];
            $_SESSION['is_authenticated'] = true;
        }

        $this->sendResponse(
            $result['status'] === 'success' ? 200 : 401,
            $result
        );
    }

    private function handleRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendResponse(405, ['status' => 'error', 'message' => 'Method không được hỗ trợ']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $requiredFields = ['username', 'email', 'password', 'first_name', 'last_name'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                $this->sendResponse(400, [
                    'status' => 'error',
                    'message' => "Thiếu thông tin bắt buộc: $field"
                ]);
                return;
            }
        }

        $result = $this->customer->register($data);
        $this->sendResponse(
            $result['status'] === 'success' ? 201 : 400,
            $result
        );
    }

    private function handleLogout()
    {
        session_destroy();
        $this->sendResponse(200, [
            'status' => 'success',
            'message' => 'Đăng xuất thành công'
        ]);
    }

    private function handleCustomerProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->sendResponse(405, ['status' => 'error', 'message' => 'Method không được hỗ trợ']);
            return;
        }

        $result = $this->customer->getCustomerById($_SESSION['customer_id']);
        $this->sendResponse(
            $result['status'] === 'success' ? 200 : 404,
            $result
        );
    }

    private function handleCustomerUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendResponse(405, ['status' => 'error', 'message' => 'Method không được hỗ trợ']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $result = $this->customer->updateProfile($_SESSION['customer_id'], $data);

        $this->sendResponse(
            $result['status'] === 'success' ? 200 : 400,
            $result
        );
    }

    private function handlePasswordChange()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendResponse(405, ['status' => 'error', 'message' => 'Method không được hỗ trợ']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['old_password']) || !isset($data['new_password'])) {
            $this->sendResponse(400, [
                'status' => 'error',
                'message' => 'Thiếu thông tin mật khẩu cũ hoặc mới'
            ]);
            return;
        }

        $result = $this->customer->changePassword(
            $_SESSION['customer_id'],
            $data['old_password'],
            $data['new_password']
        );

        $this->sendResponse(
            $result['status'] === 'success' ? 200 : 400,
            $result
        );
    }

    private function handleAuthStatus()
    {
        if (isset($_SESSION['customer_id'])) {
            // Lấy thông tin user từ database
            try {
                $sql = "SELECT customers_id, username, email, first_name, last_name 
                   FROM customers WHERE customers_id = ?";
                $stmt = $this->db->query($sql, [$_SESSION['customer_id']]);
                $user = $stmt->fetch();

                if ($user) {
                    $this->sendResponse(200, [
                        'status' => 'success',
                        'data' => $user
                    ]);
                    return;
                }
            } catch (Exception $e) {
                error_log("Error in handleAuthStatus: " . $e->getMessage());
            }
        }

        $this->sendResponse(200, [
            'status' => 'error',
            'message' => 'Chưa đăng nhập'
        ]);
    }

    private function handleGetCart()
    {
        if (!isset($_SESSION['customer_id'])) {
            $this->sendResponse(401, [
                'status' => 'error',
                'message' => 'Chưa đăng nhập'
            ]);
            return;
        }

        try {
            $sql = "SELECT c.*, p.name, p.price, p.image 
                   FROM cart c 
                   JOIN product p ON c.product_id = p.product_id 
                   WHERE c.customers_id = ?";

            $stmt = $this->db->query($sql, [$_SESSION['customer_id']]);
            $cartItems = $stmt->fetchAll();

            $formattedItems = array_map(function ($item) {
                return [
                    'product_id' => (int) $item['product_id'],
                    'name' => $item['name'],
                    'price' => (float) $item['price'],
                    'quantity' => (int) $item['quantity'],
                    'image' => $item['image']
                ];
            }, $cartItems);

            $this->sendResponse(200, [
                'status' => 'success',
                'data' => $formattedItems
            ]);
        } catch (Exception $e) {
            error_log("Error in handleGetCart: " . $e->getMessage());
            $this->sendResponse(500, [
                'status' => 'error',
                'message' => 'Lỗi khi lấy giỏ hàng'
            ]);
        }
    }

    private function handleSyncCart()
    {
        if (!isset($_SESSION['customer_id'])) {
            $this->sendResponse(401, [
                'status' => 'error',
                'message' => 'Chưa đăng nhập'
            ]);
            return;
        }

        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (!isset($data['cart']) || !is_array($data['cart'])) {
                $this->sendResponse(400, [
                    'status' => 'error',
                    'message' => 'Dữ liệu giỏ hàng không hợp lệ'
                ]);
                return;
            }

            $this->db->getConnection()->beginTransaction();

            try {
                $deleteSQL = "DELETE FROM cart WHERE customers_id = ?";
                $this->db->query($deleteSQL, [$_SESSION['customer_id']]);

                if (!empty($data['cart'])) {
                    $insertSQL = "INSERT INTO cart (customers_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
                    foreach ($data['cart'] as $item) {
                        $priceSQL = "SELECT price FROM product WHERE product_id = ?";
                        $priceStmt = $this->db->query($priceSQL, [$item['product_id']]);
                        $productPrice = $priceStmt->fetchColumn();

                        if ($productPrice !== false) {
                            $this->db->query($insertSQL, [
                                $_SESSION['customer_id'],
                                $item['product_id'],
                                $item['quantity'],
                                $productPrice
                            ]);
                        }
                    }
                }

                $this->db->getConnection()->commit();

                $this->sendResponse(200, [
                    'status' => 'success',
                    'message' => 'Đồng bộ giỏ hàng thành công'
                ]);

            } catch (Exception $e) {
                $this->db->getConnection()->rollBack();
                throw $e;
            }

        } catch (Exception $e) {
            error_log("Error in handleSyncCart: " . $e->getMessage());
            $this->sendResponse(500, [
                'status' => 'error',
                'message' => 'Lỗi khi đồng bộ giỏ hàng'
            ]);
        }
    }


}
