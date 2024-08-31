<?php
session_start();
require_once 'db.php'; // Include your database connection file

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'function_design.php'; // Include necessary functions
$message = '';
$error = false;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_design'])) {
    require_once 'upload_design_handler.php'; // Include the file handling upload logic
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Upload Design</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<?php include_once 'navbar.php'; // Include your navigation bar ?>

<div class="container">
    <h1>Upload Design</h1>
    <form action="" method="post" enctype="multipart/form-data" id="uploadForm">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="file">Design File</label>
            <input type="file" name="file" id="file" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" name="add_design" class="btn btn-primary">Upload</button>
    </form>
    <?php
    if (!empty($message)) {
        echo displayMessage($message, $error); // Display success or error message
    }
    ?>
</div>

<!-- Modal for upload status -->
<div class="modal fade" id="uploadStatusModal" tabindex="-1" role="dialog" aria-labelledby="uploadStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadStatusModalLabel">Upload Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="uploadStatusMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to show modal on page load if there's a message -->
<script>
    $(document).ready(function() {
        <?php if (!empty($message)) : ?>
            $('#uploadStatusMessage').text('<?php echo addslashes($message); ?>');
            $('#uploadStatusModal').modal('show');
        <?php endif; ?>
    });
</script>

</body>
</html>
