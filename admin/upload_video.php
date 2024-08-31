<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Videos</title>
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
                <!-- Manage Videos Tab -->
                <div>
                    <h2>Manage Videos</h2>
                    <?php echo !empty($message) ? displayMessage($message, $error) : ''; ?>

                    <!-- Form to add video -->
                    <form method="post" enctype="multipart/form-data" action="function_video.php" class="mb-4">
                        <div class="form-group">
                            <label for="file">Choose Video</label>
                            <input type="file" class="form-control-file" id="file" name="file" required>
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Choose Thumbnail</label>
                            <input type="file" class="form-control-file" id="thumbnail" name="thumbnail" required>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="add_video">Submit</button>
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
