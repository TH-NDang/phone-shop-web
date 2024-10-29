<?php
class Database
{
    private static $instance = null;
    private $connection;
    private $retries = 5;
    private $retry_interval = 2; // seconds

    private function __construct()
    {
        $this->connect();
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect()
    {
        $retries = $this->retries;

        while ($retries > 0) {
            try {
                $dsn = "mysql:host=" . DB_HOST .
                    ";port=" . DB_PORT .
                    ";dbname=" . DB_NAME .
                    ";charset=utf8mb4";

                $this->connection = new PDO(
                    $dsn,
                    DB_USER,
                    DB_PASS,
                    array(
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                    )
                );
                return;

            } catch (PDOException $e) {
                $retries--;
                error_log("Database connection attempt failed: " . $e->getMessage());

                if ($retries == 0) {
                    throw new Exception("Database connection failed after {$this->retries} attempts: " . $e->getMessage());
                }
                sleep($this->retry_interval);
            }
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);

            // Bind parameters
            foreach ($params as $key => $value) {
                $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                if (is_int($key)) {
                    $stmt->bindValue($key + 1, $value, $paramType);
                } else {
                    $stmt->bindValue($key, $value, $paramType);
                }
            }

            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            error_log("Database query error: " . $e->getMessage());
            throw new Exception("Query failed: " . $e->getMessage());
        }
    }
}
