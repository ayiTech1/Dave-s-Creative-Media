<?php

function displayMessage($message, $error) {
    $alertType = $error ? 'alert-danger' : 'alert-success';
    return '<div class="alert ' . $alertType . ' mt-3" role="alert">' . $message . '</div>';
}

function uploadPhotograph($file, $conn) {
    $targetDirectory = "../uploads/photographs/";

    
    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true); 
    }

    $targetFile = $targetDirectory . basename($file['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    
    if (isset($_POST["submit"])) {
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            return "File is not an image.";
        }
    }

    
    if (file_exists($targetFile)) {
        return "Sorry, file already exists.";
    }

    
    if ($file["size"] > 5000000) {
        return "Sorry, your file is too large.";
    }

    
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        
        $relativePath = "uploads/photographs/" . basename($file['name']);
        $sql = "INSERT INTO photographs (image_url, title, description) VALUES (:image_url, :title, :description)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':image_url', $relativePath);
        $stmt->bindParam(':title', $_POST['title']);
        $stmt->bindParam(':description', $_POST['description']);
        if ($stmt->execute()) {
            
            header('Location: index.php');
            exit;
        } else {
            unlink($targetFile); 
            return "Error uploading file. SQL Error: " . var_export($stmt->errorInfo(), true);
        }
    } else {
        return "Error uploading file.";
    }
}
?>
