<?php
require 'db.php';

$type = $_POST['type'];
$title = $_POST['title'];
$url = $_POST['url'];
$table = '';

switch ($type) {
    case 'photographs':
        $table = 'photographs';
        break;
    case 'galleries':
        $table = 'galleries';
        break;
    case 'videos':
        $table = 'videos';
        break;
    default:
        die('Invalid type');
}

try {
    $column = $type == 'videos' ? 'video_url' : 'image_url';
    $stmt = $conn->prepare("INSERT INTO $table (title, $column) VALUES (:title, :url)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':url', $url);
    $stmt->execute();
    echo "New record created successfully";
} catch(PDOException $e) {
    echo "Error adding item: " . $e->getMessage();
}
?>
