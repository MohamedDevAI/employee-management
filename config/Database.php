<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'employee_management';
    private $user = 'root';
    private $password = '';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=utf8mb4',
                $this->user,
                $this->password,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                )
            );
            return $this->conn;
        } catch (PDOException $e) {
            $error_message = "Database Connection Error: " . $e->getMessage();
            
            // Log error for debugging
            error_log($error_message);
            
            // Return error in JSON if this is an API call
            if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Database connection failed. Please check configuration.',
                    'debug' => $e->getMessage()
                ]);
                exit;
            }
            
            // Display error for regular page requests
            die($error_message . "\n\nPlease ensure:\n1. MySQL is running\n2. Database 'employee_management' exists\n3. Visit http://localhost/employee-management/test-connection.php for diagnostics");
        }
    }
}
?>
