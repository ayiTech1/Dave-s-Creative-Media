<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "media_library";

try {
    // PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set charset to UTF-8 (optional, but recommended)
    $conn->exec("SET NAMES utf8mb4");
} catch(PDOException $e) {
    // Display error message if connection fails
    die("Connection failed: " . $e->getMessage());
}
?>
