<?php
require_once '../src/autoload.php';

try {
    // Khởi tạo API Controller
    $apiController = new ApiController();
    $apiController->handleRequest();

    // Regular page routing
    $action = isset($_GET['action']) ? $_GET['action'] : 'home';
    $productId = isset($_GET['id']) ? $_GET['id'] : null;

    ob_start();
    switch ($action) {
        case 'home':
            include ROOT_DIR . '/src/Views/home.php';
            break;
        case 'product-detail':
            if ($productId) {
                $productModel = new Product();
                $result = $productModel->getProductById($productId);
                $product = $result['data'];
                include ROOT_DIR . '/src/Views/product_detail.php';
            } else {
                header('Location: /');
            }
            break;
        case 'cart': // Thêm case cart và in ra lỗi nếu có
            error_log("Loading cart page...");
            if (file_exists(ROOT_DIR . '/src/Views/cart.php')) {
                include ROOT_DIR . '/src/Views/cart.php';
            } else {
                error_log("Cart view file not found at: " . ROOT_DIR . '/src/Views/cart.php');
                echo '<div id="content" class="container">
                    <h1>Error</h1>
                    <p>Cart page is currently unavailable.</p>
                </div>';
            }
            break;
        case 'about_us':
            include ROOT_DIR . '/src/Views/about_us.php';
            break;
        case 'warranty_center':
            include ROOT_DIR . '/src/Views/warranty_center.php';
            break;
        case 'contact':
            include ROOT_DIR . '/src/Views/contact.php';
            break;
        case 'search':
            include ROOT_DIR . '/src/Views/search.php';
            break;
        default:
            echo '<div id="content" class="container">
                    <h1>404 Not Found</h1>
                    <p>The page you are looking for does not exist.</p>
                  </div>';
            break;
    }
    $content = ob_get_clean();
    include ROOT_DIR . '/src/Views/base.php';

} catch (Exception $e) {
    error_log($e->getMessage());
    if (!headers_sent()) {
        header('Content-Type: application/json');
        http_response_code(500);
    }
    echo json_encode(["error" => "Internal Server Error"]);
}
