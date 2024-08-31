<?php
session_start();
require_once 'db.php'; // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Function to sanitize output
function sanitize($data) {
    return htmlspecialchars($data);
}

// Check if form is submitted for updating photo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_photo'])) {
    $photoId = $_POST['photo_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Update photo details in database
    $sql = "UPDATE photographs SET title = :title, description = :description WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id', $photoId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        // Redirect to view photographs page after successful update
        header('Location: view_photograph.php');
        exit;
    } else {
        $updateError = "Error updating photograph.";
    }
}

// Fetch photo details for editing
if (isset($_GET['id'])) {
    $photoId = $_GET['id'];

    // Retrieve photo details from database
    $sql = "SELECT * FROM photographs WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $photoId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        $photo = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$photo) {
            // Photo not found, handle error or redirect
            header('Location: view_photograph.php');
            exit;
        }
    } else {
        // Handle error fetching photo details
        header('Location: view_photograph.php');
        exit;
    }
} else {
    // If no ID is provided, redirect back to view photographs page
    header('Location: view_photograph.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Photograph</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
        }

        .container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .form-container {
            width: 50%;
            margin-top: 20px;
        }

        .current-image {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
<?php include_once 'navbar.php' ?>
    <div class="container mt-4">
        <div class="col-md-12">
            <h2>Edit Photograph</h2>

            <div class="form-container">
                <?php if (isset($updateError)) echo "<p class='text-danger'>$updateError</p>"; ?>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo sanitize($photo['title']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo sanitize($photo['description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="current_image">Current Image</label><br>
                        <img src="../<?php echo sanitize($photo['image_url']); ?>" class="current-image" alt="Current Image">
                    </div>
                    <div class="form-group">
                        <label for="new_image">New Image (Optional)</label>
                        <input type="file" class="form-control-file" id="new_image" name="new_image">
                    </div>
                    <input type="hidden" name="photo_id" value="<?php echo $photo['id']; ?>">
                    <button type="submit" class="btn btn-primary" name="update_photo">Update Photograph</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
