<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Include your database connection file
require_once 'db.php';

// Initialize message variables
$message = '';
$error = false;

// Fetch existing about data if needed
$query = $conn->prepare("SELECT * FROM about WHERE id = 1");
$query->execute();
$aboutData = $query->fetch(PDO::FETCH_ASSOC);

// Function to display messages
function displayMessage($message, $error) {
    $alertType = $error ? 'alert-danger' : 'alert-success';
    return '<div class="alert ' . $alertType . ' mt-3" role="alert">' . $message . '</div>';
}

// Function to upload the image and return the relative path
function uploadImage($file) {
    $targetDirectory = '../uploads/about/';

    // Ensure target directory exists; if not, create it
    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }

    $targetFile = $targetDirectory . basename($file['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return ["error" => "File is not an image."];
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        return ["error" => "Sorry, file already exists."];
    }

    // Check file size
    if ($file["size"] > 5000000) {
        return ["error" => "Sorry, your file is too large."];
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        return ["error" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."];
    }

    // Attempt to upload file
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return ["path" => 'uploads/about/' . basename($file['name'])]; // Return relative path
    } else {
        return ["error" => "Error uploading file."];
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_about'])) {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $image1 = isset($aboutData['image_url']) ? $aboutData['image_url'] : '';

    // Handle file upload for image1
    if (isset($_FILES['file1']) && $_FILES['file1']['error'] == 0) {
        $uploadResult = uploadImage($_FILES['file1']);
        if (isset($uploadResult['error'])) {
            $error = true;
            $message = $uploadResult['error'];
        } else {
            $image1 = $uploadResult['path'];
        }
    }

    // Update database
    if (!$error) {
        if ($aboutData) {
            $stmt = $conn->prepare("UPDATE about SET title = ?, description = ?, image_url = ? WHERE id = 1");
        } else {
            $stmt = $conn->prepare("INSERT INTO about (title, description, image_url) VALUES (?, ?, ?)");
        }
        if ($stmt->execute([$title, $description, $image1])) {
            $message = "About section updated successfully.";
        } else {
            $error = true;
            $message = "Error updating about section.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage About</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .nav-pills .nav-link {
            color: #495057;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #007bff;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <!-- Manage About Section -->
                <div>
                    <h2>Manage About</h2>
                    <?php echo !empty($message) ? displayMessage($message, $error) : ''; ?>

                    <!-- Form to update About section -->
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="mb-4" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($aboutData['title'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($aboutData['description'] ?? ''); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="file1">Choose Image</label>
                            <input type="file" class="form-control-file" id="file1" name="file1">
                        </div>
                        <button type="submit" class="btn btn-primary" name="update_about">Update About</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
