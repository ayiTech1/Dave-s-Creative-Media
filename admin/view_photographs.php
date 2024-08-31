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

// Initialize deleteError variable
$deleteError = '';

// Check if delete action is triggered
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_photo'])) {
    $photoId = $_POST['photo_id'];

    // Debugging: Check if photo_id is set correctly
    error_log("Photo ID to delete: " . $photoId);

    // Perform delete operation
    $sql = "DELETE FROM photographs WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $photoId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Debugging: Confirm successful deletion
        error_log("Successfully deleted photo with ID: " . $photoId);

        // Redirect to self to refresh the table
        header('Location: view_photographs.php');
        exit;
    } else {
        // Handle delete error
        $deleteError = "Error deleting photograph: " . implode(", ", $stmt->errorInfo());
        // Debugging: Log the error
        error_log("Error deleting photograph: " . implode(", ", $stmt->errorInfo()));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Photographs</title>
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

        .table-container {
            margin-top: 20px;
        }

        .add-photograph-btn {
            display: block;
            width: fit-content;
            margin-top: 20px; /* Adjust margin top as needed */
        }

        /* Custom styling for table */
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: #fff;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            background-color: #007bff;
            color: #fff;
        }

        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }

        .table .btn {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>

<?php include_once 'navbar.php' ?>
    <div class="container mt-4">
        <div class="col-md-12">
            <!-- View Photographs Tab -->
            <div class="text-center mb-4">
                <h2>View Photographs</h2>
            </div>

            <!-- Table to display existing photographs -->
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
                        // Fetch photographs from database
                        $sql = "SELECT * FROM photographs";
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
                                echo "<button type='submit' class='btn btn-danger' name='delete_photo'>Delete</button>";
                                echo "</form>";
                                echo "<a href='edit_photograph.php?id=" . sanitize($row['id']) . "' class='btn btn-primary'>Edit</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No photographs found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <?php if (!empty($deleteError)) echo "<p class='text-danger'>$deleteError</p>"; ?>
            </div>

            <!-- Link to add a new photograph -->
            <div class="text-center mb-4">
                <a href="upload_photograph.php" class="btn btn-primary add-photograph-btn">Add Photograph</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
