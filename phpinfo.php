<?php 
echo "Available PDO Drivers: ";
if (class_exists('PDO')) {
    print_r(PDO::getAvailableDrivers());
} else {
    echo "PDO class not found!";
}
?>
