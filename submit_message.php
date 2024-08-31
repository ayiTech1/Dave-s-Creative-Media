<?php
session_start(); // Start session if not already started
include 'config.php'; // Your database connection configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO messages (user_name, phone_number, user_email, message) VALUES (:name, :phone, :email, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);

        $stmt->execute();

        // Set success message in session
        $_SESSION['success_message'] = "Message sent successfully!";
        
        // Redirect back to the main page
        header("Location: index.php");
        exit;
    } catch(PDOException $e) {
        // Handle the error if needed
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>
