<?php
/**
 * DATABASE CONFIGURATION
 * Using PDO for secure prepared statements
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'lifestream_db');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);

    // Corrected error mode attribute
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set default fetch mode to associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // If connection fails, stop and show error
    die("Connection failed: " . $e->getMessage());
}
?>