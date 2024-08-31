<?php
include 'db.php'; // Your database connection configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message_id = $_POST['message_id'];
    $reply = $_POST['reply'];

    // Debugging: Check if 'reply' field is set
    if (!isset($reply)) {
        echo "Error: 'reply' field is not set.";
        exit();
    }

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the message_id exists in the messages table
        $stmt = $conn->prepare("SELECT id FROM messages WHERE id = :message_id");
        $stmt->bindParam(':message_id', $message_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Insert the reply into the replies table
            $stmt = $conn->prepare("INSERT INTO replies (message_id, reply) VALUES (:message_id, :reply)");
            $stmt->bindParam(':message_id', $message_id);
            $stmt->bindParam(':reply', $reply);
            $stmt->execute();

            // Fetch the user's email for the given message_id
            $stmt = $conn->prepare("SELECT user_email, user_name FROM messages WHERE id = :message_id");
            $stmt->bindParam(':message_id', $message_id);
            $stmt->execute();
            $message = $stmt->fetch(PDO::FETCH_ASSOC);

            $user_email = $message['user_email'];
            $user_name = $message['user_name'];

            // Send an email to the user with the reply
            $to = $user_email;
            $subject = "Reply to your message";
            $body = "Dear $user_name,\n\nThank you for reaching out to us. Here is our reply to your message:\n\n$reply\n\nBest regards,\nYour Company";
            $headers = "From: your-email@example.com";

            if (mail($to, $subject, $body, $headers)) {
                echo "Reply sent successfully!";
            } else {
                echo "Failed to send email.";
            }

            // Redirect to index.php after processing
            header("Location: index.php");
            exit();
        } else {
            echo "Invalid message ID.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
} else {
    $message_id = $_GET['message_id'];
}
?>
