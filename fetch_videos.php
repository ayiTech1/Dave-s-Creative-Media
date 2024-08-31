<?php
include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch all items from the 'videos' table
$sql = "SELECT video_url, thumbnail_url FROM videos";
$result = $conn->query($sql);

$videos = [];
if ($result->num_rows > 0) {
    // Fetch all rows
    while($row = $result->fetch_assoc()) {
        $videos[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();
?>

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
$sql = "SELECT video_url, thumbnail_url FROM videos ORDER BY id DESC";
$result = $conn->query($sql);

$videos = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $videos[] = $row;
    }
}

$conn->close();
?>
