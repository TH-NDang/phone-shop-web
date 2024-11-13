<?php

class Customer
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function register($userData)
    {
        try {
            // Kiểm tra email đã tồn tại
            $checkSql = "SELECT COUNT(*) FROM customers WHERE email = ?";
            $stmt = $this->db->query($checkSql, [$userData['email']]);
            if ($stmt->fetchColumn() > 0) {
                return [
                    'status' => 'error',
                    'message' => 'Email đã tồn tại'
                ];
            }

            $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO customers (username, email, password, first_name, last_name, tel, address, date_joined) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

            $this->db->query($sql, [
                $userData['username'],
                $userData['email'],
                $hashedPassword,
                $userData['first_name'],
                $userData['last_name'],
                $userData['tel'] ?? null,
                $userData['address'] ?? null
            ]);

            return [
                'status' => 'success',
                'message' => 'Đăng ký thành công'
            ];
        } catch (Exception $e) {
            error_log("Error in register: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Đăng ký thất bại: ' . $e->getMessage()
            ];
        }
    }

    public function login($email, $password)
    {
        try {
            $sql = "SELECT * FROM customers WHERE email = ?";
            $stmt = $this->db->query($sql, [$email]);
            $user = $stmt->fetch();

            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'Email không tồn tại'
                ];
            }

            if (!password_verify($password, $user['password'])) {
                return [
                    'status' => 'error',
                    'message' => 'Mật khẩu không đúng'
                ];
            }

            $this->updateLastLogin($user['customers_id']);

            unset($user['password']);

            return [
                'status' => 'success',
                'message' => 'Đăng nhập thành công',
                'data' => $user
            ];
        } catch (Exception $e) {
            error_log("Error in login: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Đăng nhập thất bại: ' . $e->getMessage()
            ];
        }
    }

    private function updateLastLogin($userId)
    {
        $sql = "UPDATE customers SET last_login = NOW() WHERE customers_id = ?";
        $this->db->query($sql, [$userId]);
    }

    public function updateProfile($userId, $userData)
    {
        try {
            $updates = [];
            $params = [];

            // Xây dựng câu query động dựa trên dữ liệu được cung cấp
            if (isset($userData['first_name'])) {
                $updates[] = "first_name = ?";
                $params[] = $userData['first_name'];
            }
            if (isset($userData['last_name'])) {
                $updates[] = "last_name = ?";
                $params[] = $userData['last_name'];
            }
            if (isset($userData['tel'])) {
                $updates[] = "tel = ?";
                $params[] = $userData['tel'];
            }
            if (isset($userData['address'])) {
                $updates[] = "address = ?";
                $params[] = $userData['address'];
            }

            if (empty($updates)) {
                return [
                    'status' => 'error',
                    'message' => 'Không có thông tin cần cập nhật'
                ];
            }

            $params[] = $userId;
            $sql = "UPDATE customers SET " . implode(", ", $updates) . " WHERE customers_id = ?";
            $this->db->query($sql, $params);

            return [
                'status' => 'success',
                'message' => 'Cập nhật thông tin thành công'
            ];
        } catch (Exception $e) {
            error_log("Error in updateProfile: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Cập nhật thất bại: ' . $e->getMessage()
            ];
        }
    }

    public function changePassword($userId, $oldPassword, $newPassword)
    {
        try {
            $sql = "SELECT password FROM customers WHERE customers_id = ?";
            $stmt = $this->db->query($sql, [$userId]);
            $user = $stmt->fetch();

            if (!password_verify($oldPassword, $user['password'])) {
                return [
                    'status' => 'error',
                    'message' => 'Mật khẩu cũ không đúng'
                ];
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE customers SET password = ? WHERE customers_id = ?";
            $this->db->query($sql, [$hashedPassword, $userId]);

            return [
                'status' => 'success',
                'message' => 'Đổi mật khẩu thành công'
            ];
        } catch (Exception $e) {
            error_log("Error in changePassword: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Đổi mật khẩu thất bại: ' . $e->getMessage()
            ];
        }
    }

    public function getCustomerById($userId)
    {
        try {
            $sql = "SELECT customers_id, username, email, first_name, last_name, tel, address, date_joined, last_login 
                   FROM customers WHERE customers_id = ?";
            $stmt = $this->db->query($sql, [$userId]);
            $user = $stmt->fetch();

            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'Không tìm thấy người dùng'
                ];
            }

            return [
                'status' => 'success',
                'data' => $user
            ];
        } catch (Exception $e) {
            error_log("Error in getCustomerById: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Lỗi khi lấy thông tin người dùng: ' . $e->getMessage()
            ];
        }
    }
}
