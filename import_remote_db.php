<?php
require_once 'config.php';

try {
    $sql = file_get_contents('database/schema.sql');
    if (!$sql) {
        die("Could not read schema file.");
    }
    
    // Execute the SQL schema
    $conn->exec($sql);
    echo "<h1>Database Imported Successfully!</h1>";
    
} catch (PDOException $e) {
    echo "<h1>Error Importing Database:</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>
