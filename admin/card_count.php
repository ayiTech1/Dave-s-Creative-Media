<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'db.php';

// Function to fetch count of items from database
function fetchItemCount($conn, $table) {
    $sql = "SELECT COUNT(*) AS total_items FROM $table";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_items'];
    } else {
        return 0; // Return 0 if query fails
    }
}

// Function to fetch count of unread messages (or unreply messages)
function fetchUnreadMessageCount($conn) {
    $sql = "SELECT COUNT(*) AS unread_count FROM messages WHERE id NOT IN (SELECT message_id FROM replies)";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['unread_count'];
    } else {
        return 0; // Return 0 if query fails
    }
}

// Fetch counts for each section
$totalPhotographs = fetchItemCount($conn, 'photographs');
$totalVideos = fetchItemCount($conn, 'videos');
$totalGalleries = fetchItemCount($conn, 'galleries');
$totalDesigns = fetchItemCount($conn, 'designs');
$totalService = fetchItemCount($conn, 'services');

// Fetch unread message count
$unreadMessages = fetchUnreadMessageCount($conn);
?>
