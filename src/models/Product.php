<?php
class Product
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $query = "SELECT p.*, c.name as category_name 
                  FROM products p 
                  LEFT JOIN product_category pc ON p.id = pc.product_id 
                  LEFT JOIN categories c ON pc.category_id = c.id";
        $stmt = $this->pdo->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $query = "SELECT p.*, c.name as category_name 
                  FROM products p 
                  LEFT JOIN product_category pc ON p.id = pc.product_id 
                  LEFT JOIN categories c ON pc.category_id = c.id 
                  WHERE p.id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
