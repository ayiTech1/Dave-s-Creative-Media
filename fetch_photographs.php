<?php
// session_start(); // Start PHP session

include 'config.php';

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all images from the 'designs' table ordered by the most recent
$sql = "SELECT image_url FROM photographs ORDER BY id DESC";
$result = $conn->query($sql);

$images = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $photos[] = $row["image_url"];
    }
}

$conn->close();
?>
