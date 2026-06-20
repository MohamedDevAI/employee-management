<?php
/**
 * Automated Database Setup
 * Visit: http://localhost/employee-management/setup-database.php
 * This will create the database and all tables automatically
 */

echo "<!DOCTYPE html>
<html>
<head>
    <title>Database Setup</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .success { color: white; background: #28a745; padding: 15px; margin: 10px 0; border-radius: 4px; font-weight: bold; }
        .error { color: white; background: #dc3545; padding: 15px; margin: 10px 0; border-radius: 4px; font-weight: bold; }
        .info { color: #0c5460; background: #d1ecf1; padding: 15px; margin: 10px 0; border-radius: 4px; }
        h1 { color: #333; border-bottom: 3px solid #007bff; padding-bottom: 10px; }
        h2 { color: #555; margin-top: 20px; }
        .step { margin: 20px 0; padding: 15px; border-left: 4px solid #007bff; background: #f9f9f9; }
        code { background: #f4f4f4; padding: 2px 8px; border-radius: 3px; font-weight: bold; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class='container'>
    <h1> Employee Management - Database Setup</h1>";

$host = 'localhost';
$user = 'root';
$password = '';
$db_name = 'employee_management';

try {
    // Step 1: Connect to MySQL without selecting database
    echo "<h2>Step 1: Connecting to MySQL Server...</h2>";
    $conn = new PDO("mysql:host=$host", $user, $password);
    echo "<div class='success'>✓ Connected to MySQL Server</div>";
    
    // Step 2: Create Database
    echo "<h2>Step 2: Creating Database...</h2>";
    $conn->exec("CREATE DATABASE IF NOT EXISTS `$db_name` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<div class='success'>✓ Database '$db_name' created/verified</div>";
    
    // Step 3: Select Database
    echo "<h2>Step 3: Selecting Database...</h2>";
    $conn->exec("USE `$db_name`");
    echo "<div class='success'>✓ Database selected</div>";
    
    // Step 4: Create Tables
    echo "<h2>Step 4: Creating Tables...</h2>";
    
    // Employees table
    $conn->exec("
        CREATE TABLE IF NOT EXISTS employees (
            id INT PRIMARY KEY AUTO_INCREMENT,
            employee_id VARCHAR(50) UNIQUE NOT NULL,
            punch_id VARCHAR(50) UNIQUE NOT NULL,
            employee_name VARCHAR(100) NOT NULL,
            iqama_id VARCHAR(50) UNIQUE NOT NULL,
            nationality VARCHAR(50) NOT NULL,
            email VARCHAR(100),
            phone VARCHAR(20),
            department VARCHAR(50),
            position VARCHAR(50),
            hire_date DATE,
            salary DECIMAL(10, 2),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP NULL,
            is_deleted BOOLEAN DEFAULT FALSE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");
    echo "<div class='success'>✓ Employees table created</div>";
    
    // Attendance table
    $conn->exec("
        CREATE TABLE IF NOT EXISTS attendance (
            id INT PRIMARY KEY AUTO_INCREMENT,
            employee_id INT NOT NULL,
            check_in_time DATETIME NOT NULL,
            check_out_time DATETIME NULL,
            work_hours DECIMAL(5, 2) NULL,
            notes VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
            INDEX idx_employee_date (employee_id, check_in_time)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");
    echo "<div class='success'>✓ Attendance table created</div>";
    
    // Step 5: Create Indexes
    echo "<h2>Step 5: Creating Indexes...</h2>";
    $conn->exec("CREATE INDEX idx_employee_id ON employees(employee_id)");
    $conn->exec("CREATE INDEX idx_punch_id ON employees(punch_id)");
    $conn->exec("CREATE INDEX idx_iqama_id ON employees(iqama_id)");
    $conn->exec("CREATE INDEX idx_deleted ON employees(is_deleted)");
    echo "<div class='success'>✓ Indexes created for performance</div>";
    
    // Step 6: Verify Setup
    echo "<h2>Step 6: Verifying Setup...</h2>";
    $tables = $conn->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    $employee_count = $conn->query("SELECT COUNT(*) FROM employees")->fetchColumn();
    
    echo "<div class='success'>✓ Tables verified: " . implode(", ", $tables) . "</div>";
    echo "<div class='info'>Employee records: <strong>$employee_count</strong></div>";
    
    // Final message
    echo "<div class='step'>
        <h3>Database Setup Complete!</h3>
        <p>Your database is now ready to use.</p>
        <p><strong>Next steps:</strong></p>
        <ul>
            <li>Go to: <a href='http://localhost/employee-management/' target='_blank'>http://localhost/employee-management/</a></li>
            <li>Click 'Add Employee' to create your first employee</li>
            <li>Visit 'Attendance' page to track check-in/out</li>
        </ul>
    </div>";
    
} catch (Exception $e) {
    echo "<div class='error'>✗ Error: " . $e->getMessage() . "</div>";
    echo "<div class='step'>
        <h3>Troubleshooting:</h3>
        <ul>
            <li>Ensure <strong>Laragon is running</strong> (MySQL service must be active)</li>
            <li>Ensure <strong>MySQL username</strong> is 'root' with <strong>no password</strong></li>
            <li>If credentials are different, edit: <code>config/Database.php</code></li>
            <li>Try visiting the test page: <a href='test-connection.php'>test-connection.php</a></li>
        </ul>
    </div>";
}

echo "
</div>
</body>
</html>
";
?>
