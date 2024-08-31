<?php
require 'db.php';

$username = 'admin';
$email = 'admin@example.com';
$password = password_hash('step', PASSWORD_DEFAULT);

try {
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    echo "User created successfully";
} catch(PDOException $e) {
    echo "Error creating user: " . $e->getMessage();
}
?>
