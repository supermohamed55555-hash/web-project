<?php
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
    
} catch(PDOException $e) {
    // If connection fails, stop and show error
    die("Connection failed: " . $e->getMessage());
}
?>