<?php
// Include configuration
require_once 'config.php';

// Database configuration
$servername = DB_HOST;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$dbname = DB_NAME;

// Create connection with error handling
try {
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    if (!$conn) {
        error_log("Database connection failed: " . mysqli_connect_error());
        if (DEBUG_MODE) {
            die("Database connection failed: " . mysqli_connect_error());
        } else {
            die("Database connection failed. Please check your configuration.");
        }
    }
    
    // Set charset to ensure proper encoding
    mysqli_set_charset($conn, "utf8mb4");
    
} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    if (DEBUG_MODE) {
        die("Database connection error: " . $e->getMessage());
    } else {
        die("Database connection error occurred.");
    }
}
?>
