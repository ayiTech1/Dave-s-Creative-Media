<?php

function displayMessage($message, $error) {
    $alertType = $error ? 'alert-danger' : 'alert-success';
    return '<div class="alert ' . $alertType . ' mt-3" role="alert">' . $message . '</div>';
}

function uploadService($file, $conn) {
    $targetDirectory = "../uploads/service/";

    // Ensure target directory exists; if not, create it
    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true); 
    }

    $targetFile = $targetDirectory . basename($file['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            return "File is not an image.";
        }
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        return "Sorry, file already exists.";
    }

    // Check file size
    if ($file["size"] > 5000000) {
        return "Sorry, your file is too large.";
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    // Attempt to upload file
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        // File uploaded successfully, now insert into database
        $relativePath = "uploads/service/" . basename($file['name']);
        $sql = "INSERT INTO services (title, image, description) VALUES (:title, :image, :description)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $_POST['title']);
        $stmt->bindParam(':image', $relativePath);
        $stmt->bindParam(':description', $_POST['description']);

        if ($stmt->execute()) {
            // Redirect to success page or main page
            header('Location: index.php');
            exit;
        } else {
            // If insertion fails, delete the uploaded file
            unlink($targetFile); 
            return "Error uploading file. SQL Error: " . var_export($stmt->errorInfo(), true);
        }
    } else {
        return "Error uploading file.";
    }
}

?>
