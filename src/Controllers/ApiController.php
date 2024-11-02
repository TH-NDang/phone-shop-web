<?php
require_once __DIR__ . '/../Models/Product.php';

class ApiController
{
    private $product;

    public function __construct()
    {
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
        if (isset($_GET['brand'])) {
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
}
