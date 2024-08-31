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
if (isset($_POST['delete_service'])) {
    $photoId = $_POST['photo_id'];

    // Perform delete operation
    $sql = "DELETE FROM services WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $photoId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Redirect to self to refresh the table
        header('Location: view_service.php');
        exit;
    } else {
        $deleteError = "Error deleting service: " . implode(", ", $stmt->errorInfo());
    }
}

// Check if update action is triggered
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_service'])) {
    $photoId = $_POST['photo_id'];
    $title = sanitize($_POST['title']);
    $description = sanitize($_POST['description']);
    $image = sanitize($_POST['image']);

    // Perform update operation
    $sql = "UPDATE services SET title = :title, description = :description, image = :image WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':id', $photoId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Redirect to self to refresh the table
        header('Location: view_service.php');
        exit;
    } else {
        $updateError = "Error updating service: " . implode(", ", $stmt->errorInfo());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Service</title>
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

        .add-service-btn {
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
                <h2>View Service</h2>
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
                        $sql = "SELECT * FROM services";
                        $stmt = $conn->prepare($sql);
                        if ($stmt->execute()) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . sanitize($row['id']) . "</td>";
                                echo "<td>" . sanitize($row['title']) . "</td>";
                                echo "<td><img src='" . sanitize($row['image']) . "' height='50'></td>";
                                echo "<td>" . sanitize($row['description']) . "</td>";
                                echo "<td>";
                                echo "<form method='post' style='display: inline-block; margin-right: 5px;'>";
                                echo "<input type='hidden' name='photo_id' value='" . sanitize($row['id']) . "'>";
                                echo "<button type='submit' class='btn btn-danger' name='delete_service'>Delete</button>";
                                echo "</form>";
                                echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#editModal' data-id='" . sanitize($row['id']) . "' data-title='" . sanitize($row['title']) . "' data-description='" . sanitize($row['description']) . "' data-image='" . sanitize($row['image']) . "'>Edit</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No services found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <?php if (isset($deleteError)) echo "<p class='text-danger'>$deleteError</p>"; ?>
                <?php if (isset($updateError)) echo "<p class='text-danger'>$updateError</p>"; ?>
            </div>

            <div class="text-center mb-4">
                <a href="upload_service.php" class="btn btn-primary add-service-btn">Add Service</a>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <input type="hidden" id="edit-photo-id" name="photo_id">
                        <div class="form-group">
                            <label for="edit-title">Title</label>
                            <input type="text" class="form-control" id="edit-title" name="title">
                        </div>
                        <div class="form-group">
                            <label for="edit-description">Description</label>
                            <textarea class="form-control" id="edit-description" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit-image">Image URL</label>
                            <input type="text" class="form-control" id="edit-image" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary" name="update_service">Update Service</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id');
            var title = button.data('title');
            var description = button.data('description');
            var image = button.data('image');

            var modal = $(this);
            modal.find('#edit-photo-id').val(id);
            modal.find('#edit-title').val(title);
            modal.find('#edit-description').val(description);
            modal.find('#edit-image').val(image);
        });
    </script>
</body>
</html>
