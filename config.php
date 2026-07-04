<?php
require_once __DIR__ . '/includes/security.php';
/**
 * DATABASE CONFIGURATION
 * Using PDO for secure prepared statements
 */

// Database credentials
// Database credentials - Supports Railway defaults and local XAMPP
define('DB_HOST', getenv('MYSQLHOST') ?: (getenv('DB_HOST') ?: 'localhost'));
define('DB_NAME', getenv('MYSQLDATABASE') ?: (getenv('DB_NAME') ?: 'lifestream_db'));
define('DB_USER', getenv('MYSQLUSER') ?: (getenv('DB_USER') ?: 'root'));
define('DB_PASS', getenv('MYSQLPASSWORD') ?: (getenv('DB_PASS') ?: ''));
define('DB_PORT', getenv('MYSQLPORT') ?: (getenv('DB_PORT') ?: '3306'));

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    
    // Corrected error mode attribute
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // Ensure audit_logs table exists
    $conn->exec("CREATE TABLE IF NOT EXISTS audit_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT DEFAULT NULL,
        user_email VARCHAR(255) DEFAULT NULL,
        action VARCHAR(100) NOT NULL,
        details TEXT DEFAULT NULL,
        ip_address VARCHAR(45) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;");
    
} catch(PDOException $e) {
    // If connection fails, stop and show error
    die("Connection failed: " . $e->getMessage());
}
?>