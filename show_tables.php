<?php
require_once 'config.php';

try {
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "<h1>Tables in database:</h1><ul>";
    foreach ($tables as $table) {
        echo "<li>$table</li>";
    }
    echo "</ul>";
} catch (PDOException $e) {
    echo "<h1>Error:</h1><p>" . $e->getMessage() . "</p>";
}
?>
