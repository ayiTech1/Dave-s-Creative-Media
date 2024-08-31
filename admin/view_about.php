<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Include your database connection file
require_once 'db.php'; // Adjusted path

// Fetch existing about data
$query = $conn->prepare("SELECT * FROM about WHERE id = 1");
$query->execute();
$aboutData = $query->fetch(PDO::FETCH_ASSOC);

// Check if data is available
$title = $aboutData['title'] ?? 'Default Title';
$description = $aboutData['description'] ?? 'Default Description';
$image_url = $aboutData['image_url'] ?? '../uploads/about/default.jpg'; // Adjusted path
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View About Section</title>
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

        .nav-pills .nav-link {
            color: #495057;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #007bff;
        }

        .about-container {
            margin-top: 20px;
        }

        .about-image {
            max-width: 100%;
            height: auto;
            max-height: 300px; /* Adjust image height as needed */
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<?php include_once 'navbar.php'; ?>
    <div class="container mt-4">
        <div class="col-md-8">
            <!-- View About Section -->
            <div class="text-center mb-4">
                <h2>About Us</h2>
            </div>

            <!-- Display About Section Data -->
            <div class="about-container">
                <div class="row">
                    <div class="col-md-4">
                        <!-- Display About Image -->
                        <img src="<?php echo htmlspecialchars($image_url); ?>" alt="About Image" class="about-image">
                    </div>
                    <div class="col-md-8">
                        <!-- Display About Description -->
                        <p><?php echo htmlspecialchars($description); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
