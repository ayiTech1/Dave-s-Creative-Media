<?php
include 'config.php'; // Include your database connection details

try {
    // PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch services data
    $stmt = $conn->prepare("SELECT title, description, image FROM services");
    $stmt->execute();

    // Fetch all rows as associative array
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    // Display error message if connection or query fails
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;

// Function to truncate text to a certain number of words
function truncateText($text, $limit) {
    $words = explode(' ', $text);
    if (count($words) > $limit) {
        return implode(' ', array_slice($words, 0, $limit)) . ' ...';
    } else {
        return $text;
    }
}
?>
