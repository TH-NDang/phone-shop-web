<?php

class Order
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getOrdersByCustomerId($customer_id)
    {
        $sql = "SELECT * FROM orders WHERE customer_id = ?";
        $stmt = $this->db->query($sql, [$customer_id]);
        $orders = $stmt->fetchAll();

        foreach ($orders as &$order) {
            $order['items'] = $this->getOrderItems($order['order_id']);
        }

        return $orders;
    }

    private function getOrderItems($order_id)
    {
        $sql = "SELECT p.name, oi.quantity, oi.price 
                FROM order_items oi 
                JOIN product p ON oi.product_id = p.product_id 
                WHERE oi.order_id = ?";
        $stmt = $this->db->query($sql, [$order_id]);
        return $stmt->fetchAll();
    }
}