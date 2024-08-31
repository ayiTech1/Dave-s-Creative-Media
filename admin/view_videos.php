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
if (isset($_POST['delete_video'])) {
    $videoId = $_POST['video_id'];

    // Perform delete operation
    $sql = "DELETE FROM videos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $videoId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        // Redirect to self to refresh the table
        header('Location: view_videos.php');
        exit;
    } else {
        $deleteError = "Error deleting video.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Videos</title>
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
        .nav-pills .show > .nav-link {
            color: #fff;
            background-color: #007bff;
        }

        .table-container {
            margin-top: 20px;
        }

        .add-video-btn {
            display: block;
            width: fit-content;
            margin-top: 20px; /* Adjust margin top as needed */
        }

        .video-thumbnail {
            max-width: 200px;
            max-height: 150px;
        }
    </style>
</head>
<body>
<?php include_once 'navbar.php' ?>

    <div class="container mt-4">
        <div class="col-md-12">
            <!-- View Videos Tab -->
            <div class="text-center mb-4">
                <h2>View Videos</h2>
            </div>

            <!-- Table to display existing videos -->
            <div class="table-container">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Video</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch videos from database
                        $sql = "SELECT * FROM videos";
                        $stmt = $conn->prepare($sql);
                        if ($stmt->execute()) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . sanitize($row['id']) . "</td>";
                                echo "<td>" . sanitize($row['title']) . "</td>";
                                echo "<td><video class='video-thumbnail' controls><source src='" . sanitize($row['video_url']) . "' type='video/mp4'></video></td>";
                                echo "<td>" . sanitize($row['description']) . "</td>";
                                echo "<td>";
                                echo "<form method='post' style='display: inline-block; margin-right: 5px;'>";
                                echo "<input type='hidden' name='video_id' value='" . sanitize($row['id']) . "'>";
                                echo "<button type='submit' class='btn btn-danger' name='delete_video'>Delete</button>";
                                echo "</form>";
                                echo "<a href='edit_video.php?id=" . sanitize($row['id']) . "' class='btn btn-primary'>Edit</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No videos found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <?php if (isset($deleteError)) echo "<p class='text-danger'>$deleteError</p>"; ?>
            </div>

            <!-- Link to add a new video -->
            <div class="text-center mb-4">
                <a href="upload_video.php" class="btn btn-primary add-video-btn">Add Video</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
