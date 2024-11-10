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
}