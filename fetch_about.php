<?php
require_once 'config.php'; // Include your database connection file

// Fetch data from the database
$sql = "SELECT title, description, image_url FROM about LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$about = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if data is fetched
if ($about) {
    $title = htmlspecialchars($about['title'], ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($about['description'], ENT_QUOTES, 'UTF-8');
    $image_url = htmlspecialchars($about['image_url'], ENT_QUOTES, 'UTF-8');
} else {
    // Default values if no data is found
    $title = 'About Us';
    $description = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti dolorem eum consequuntur ipsam repellat dolor soluta aliquid laborum, eius odit consectetur vel quasi in quidem, eveniet ab est corporis tempore.';
    $image_url = 'images/Dave\'s_about.jpg';
}
?>