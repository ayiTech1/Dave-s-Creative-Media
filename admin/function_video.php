<?php
session_start();
require_once 'db.php'; // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Initialize variables
$message = '';
$error = false;

// Function to display success or error messages
function displayMessage($message, $error) {
    $alertType = $error ? 'alert-danger' : 'alert-success';
    return '<div class="alert ' . $alertType . ' mt-3" role="alert">' . $message . '</div>';
}

// Function to upload video and thumbnail
function uploadVideoAndThumbnail($videoFile, $thumbnailFile, $conn) {
    $targetVideoDirectory = "../uploads/video/";
    $targetThumbnailDirectory = "../uploads/thumbnails/";

    // Ensure the target directories exist
    if (!file_exists($targetVideoDirectory)) {
        mkdir($targetVideoDirectory, 0777, true); // Create directory recursively
    }
    if (!file_exists($targetThumbnailDirectory)) {
        mkdir($targetThumbnailDirectory, 0777, true); // Create directory recursively
    }

    $targetVideoFile = $targetVideoDirectory . basename($videoFile['name']);
    $targetThumbnailFile = $targetThumbnailDirectory . basename($thumbnailFile['name']);

    $videoFileType = strtolower(pathinfo($targetVideoFile, PATHINFO_EXTENSION));
    $thumbnailFileType = strtolower(pathinfo($targetThumbnailFile, PATHINFO_EXTENSION));

    // Allowed extensions
    $allowedVideoExtensions = array("mp4", "avi", "mov", "wmv", "flv", "mkv", "webm");
    $allowedImageExtensions = array("jpg", "jpeg", "png", "gif", "bmp", "webp");

    // Check video file extension
    if (!in_array($videoFileType, $allowedVideoExtensions)) {
        return "Sorry, only MP4, AVI, MOV, WMV, FLV, MKV, and WEBM video files are allowed.";
    }

    // Check thumbnail file extension
    if (!in_array($thumbnailFileType, $allowedImageExtensions)) {
        return "Sorry, only JPG, JPEG, PNG, GIF, BMP, and WEBP image files are allowed.";
    }

    // Check if files already exist
    if (file_exists($targetVideoFile)) {
        return "Sorry, video file already exists.";
    }
    if (file_exists($targetThumbnailFile)) {
        return "Sorry, thumbnail file already exists.";
    }

    // Check file sizes
    if ($videoFile["size"] > 90000000) { // Adjust size limit as needed
        return "Sorry, your video file is too large.";
    }
    if ($thumbnailFile["size"] > 5000000) { // Adjust size limit as needed
        return "Sorry, your thumbnail file is too large.";
    }

    // Upload files
    if (move_uploaded_file($videoFile["tmp_name"], $targetVideoFile) && move_uploaded_file($thumbnailFile["tmp_name"], $targetThumbnailFile)) {
        // Insert into database
        $videoRelativePath = "uploads/video/" . basename($videoFile['name']);
        $thumbnailRelativePath = "uploads/thumbnails/" . basename($thumbnailFile['name']);
        $sql = "INSERT INTO videos (video_url, thumbnail_url, title, description) VALUES (:video_url, :thumbnail_url, :title, :description)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':video_url', $videoRelativePath);
        $stmt->bindParam(':thumbnail_url', $thumbnailRelativePath);
        $stmt->bindParam(':title', $_POST['title']);
        $stmt->bindParam(':description', $_POST['description']);
        if ($stmt->execute()) {
            // Redirect back to index.php after successful upload
            header('Location: index.php');
            exit;
        } else {
            unlink($targetVideoFile); // Remove video file if insert fails
            unlink($targetThumbnailFile); // Remove thumbnail file if insert fails
            return "Error uploading files. SQL Error: " . var_export($stmt->errorInfo(), true);
        }
    } else {
        return "Error uploading files.";
    }
}

// Handle form submission for adding a video and thumbnail
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_video'])) {
    $message = uploadVideoAndThumbnail($_FILES['file'], $_FILES['thumbnail'], $conn);
    $error = strpos($message, "Error") !== false;
}

// If execution reaches here without redirecting, display the message if any
if (!empty($message)) {
    echo displayMessage($message, $error);
}
?>
