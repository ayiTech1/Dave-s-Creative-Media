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

// Check if delete action is triggered
if (isset($_POST['delete_gallery'])) {
    $photoId = $_POST['photo_id'];

    // Perform delete operation
    $sql = "DELETE FROM galleries WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $photoId, PDO::PARAM_INT);

    // Debugging: Output SQL query and photo ID for verification
    // var_dump($sql, $photoId); // Uncomment for debugging

    if ($stmt->execute()) {

        // Redirect to self to refresh the table
        header('Location: view_galleries.php');
        exit;
    } else {
        $deleteError = "Error deleting galleries: " . implode(", ", $stmt->errorInfo());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Gallery</title>
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

        .table-container {
            margin-top: 20px;
        }

        .add-galleries-btn {
            display: block;
            width: fit-content;
            margin-top: 20px; /* Adjust margin top as needed */
        }
    </style>
</head>
<body>
<?php include_once 'navbar.php' ?>
    <div class="container mt-4">
        <div class="col-md-12">
            
            <div class="text-center mb-4">
                <h2>View Gallery</h2>
            </div>

            
            <div class="table-container">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        $sql = "SELECT * FROM galleries";
                        $stmt = $conn->prepare($sql);
                        if ($stmt->execute()) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . sanitize($row['id']) . "</td>";
                                echo "<td>" . sanitize($row['title']) . "</td>";
                                echo "<td><img src='" . sanitize($row['image_url']) . "' height='50'></td>";
                                echo "<td>" . sanitize($row['description']) . "</td>";
                                echo "<td>";
                                echo "<form method='post' style='display: inline-block; margin-right: 5px;'>";
                                echo "<input type='hidden' name='photo_id' value='" . sanitize($row['id']) . "'>";
                                echo "<button type='submit' class='btn btn-danger' name='delete_gallery'>Delete</button>";
                                echo "</form>";
                                echo "<a href='edit_gallery.php?id=" . sanitize($row['id']) . "' class='btn btn-primary'>Edit</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No galleries found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <?php if (isset($deleteError)) echo "<p class='text-danger'>$deleteError</p>"; ?>
            </div>

            
            <div class="text-center mb-4">
                <a href="upload_gallery.php" class="btn btn-primary add-galleries-btn">Add Gallery</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
