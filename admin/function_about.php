<?php
session_start();
require_once 'config/connect.php'; // Include your database connection file

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

// Function to fetch About section data
function getAboutData($pdo) {
    try {
        // Query to fetch about information
        $query = "SELECT id, description, image_url FROM about WHERE id = 1"; // Adjust table and conditions as needed
        
        // Prepare and execute the query
        $stmt = $pdo->query($query);
        
        // Fetch the data as an associative array
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle query errors
        return array('error' => 'Query error: ' . $e->getMessage());
    }
}

// Function to update About section data
function updateAboutData($pdo, $description, $image_url) {
    try {
        // Prepare update query
        $query = "UPDATE about SET description = :description, image_url = :image_url WHERE id = 1"; // Adjust table and conditions as needed
        
        // Prepare statement
        $stmt = $pdo->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image_url', $image_url);
        
        // Execute the update
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // Handle query errors
        return false;
    }
}

// Handle form submission for updating About section
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_about'])) {
    $description = $_POST['description']; // Assuming form field name is 'description'
    $image_url = ''; // Handle image upload separately if needed

    // Call function to update about data
    if (updateAboutData($pdo, $description, $image_url)) {
        $message = 'About data updated successfully.';
    } else {
        $message = 'Failed to update about data.';
        $error = true;
    }
}

?>
