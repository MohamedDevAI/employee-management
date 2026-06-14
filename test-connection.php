<?php
/**
 * Database Connection Test Script
 * Visit: http://localhost/employee-management/test-connection.php
 */

echo "<!DOCTYPE html>
<html>
<head>
    <title>Database Connection Test</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        .success { color: green; background: #d4edda; padding: 10px; margin: 10px 0; border-radius: 4px; }
        .error { color: red; background: #f8d7da; padding: 10px; margin: 10px 0; border-radius: 4px; }
        .info { color: #0c5460; background: #d1ecf1; padding: 10px; margin: 10px 0; border-radius: 4px; }
        h2 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
<div class='container'>
    <h1>🔧 Employee Management - Database Test</h1>";

// Test 1: PHP Version
echo "<h2>1. PHP Version Check</h2>";
echo "<div class='success'>✓ PHP Version: " . phpversion() . "</div>";

// Test 2: PDO Extension
echo "<h2>2. PDO Extension Check</h2>";
if (extension_loaded('pdo') && extension_loaded('pdo_mysql')) {
    echo "<div class='success'>✓ PDO and PDO_MySQL extensions are installed</div>";
} else {
    echo "<div class='error'>✗ PDO or PDO_MySQL not found. Install these extensions.</div>";
}

// Test 3: Database Connection
echo "<h2>3. Database Connection Test</h2>";

$host = 'localhost';
$user = 'root';
$password = '';

try {
    // First, try to connect without specifying database
    $conn = new PDO("mysql:host=$host", $user, $password);
    echo "<div class='success'>✓ Connected to MySQL Server</div>";
    
    // Check if database exists
    $result = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'employee_management'");
    
    if ($result->rowCount() > 0) {
        echo "<div class='success'>✓ Database 'employee_management' EXISTS</div>";
        
        // Connect to the database
        $conn = new PDO("mysql:host=$host;dbname=employee_management", $user, $password);
        
        // Check tables
        echo "<h2>4. Table Check</h2>";
        
        $tables = $conn->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        
        if (count($tables) > 0) {
            echo "<div class='success'>✓ Tables found: " . implode(", ", $tables) . "</div>";
            
            // Check employee count
            $employeeCount = $conn->query("SELECT COUNT(*) FROM employees WHERE is_deleted = FALSE")->fetchColumn();
            echo "<div class='info'>Current Employees: <strong>$employeeCount</strong></div>";
            
            // Check attendance count
            $attendanceCount = $conn->query("SELECT COUNT(*) FROM attendance")->fetchColumn();
            echo "<div class='info'>Attendance Records: <strong>$attendanceCount</strong></div>";
        } else {
            echo "<div class='error'>✗ No tables found in database. Need to import schema.sql</div>";
            echo "<div class='info'><strong>Solution:</strong> Go to phpMyAdmin and import database/schema.sql file.</div>";
        }
    } else {
        echo "<div class='error'>✗ Database 'employee_management' DOES NOT EXIST</div>";
        echo "<div class='info'><strong>Solution:</strong> Follow steps below to create it.</div>";
    }
    
} catch (PDOException $e) {
    echo "<div class='error'>✗ Connection Error: " . $e->getMessage() . "</div>";
}

// Instructions
echo "<h2>📋 Setup Instructions</h2>";
echo "<div class='info'>
    <h3>Step 1: Create Database</h3>
    <ul>
        <li>Open Laragon Control Panel</li>
        <li>Click <strong>Database</strong> button (opens phpMyAdmin)</li>
        <li>In left sidebar, click <strong>New</strong></li>
        <li>Enter database name: <code>employee_management</code></li>
        <li>Click <strong>Create</strong></li>
    </ul>
</div>";

echo "<div class='info'>
    <h3>Step 2: Import Schema</h3>
    <ul>
        <li>In phpMyAdmin, select <code>employee_management</code> database</li>
        <li>Go to <strong>Import</strong> tab</li>
        <li>Click <strong>Choose File</strong></li>
        <li>Select: <code>database/schema.sql</code></li>
        <li>Click <strong>Import</strong></li>
    </ul>
</div>";

echo "<div class='info'>
    <h3>Step 3: Verify Setup</h3>
    <ul>
        <li>Refresh this page</li>
        <li>All checks should show <span style='color: green;'>✓</span></li>
        <li>Visit <code>http://localhost/employee-management/</code></li>
    </ul>
</div>";

echo "</div>
</body>
</html>";
?>
