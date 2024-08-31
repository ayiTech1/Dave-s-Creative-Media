<?php require_once 'card_count.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        .wrapper {
            display: flex;
            flex: 1;
        }
        .sidebar {
            width: 250px;
            background: #343a40;
            color: #fff;
            flex-shrink: 0;
            padding-top: 20px;
            position: fixed;
            height: 100%;
            overflow-y: auto;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
        }
        .sidebar .nav-link.active {
            background-color: #495057;
        }
        .content {
            flex: 1;
            padding: 20px;
            margin-left: 250px; /* Adjusted for sidebar width */
        }
        .dropdown-menu-dark {
            background-color: #343a40;
            color: #fff;
        }
        .dropdown-menu-dark .dropdown-item {
            color: #fff;
        }
        .dropdown-menu-dark .dropdown-item:hover, .dropdown-menu-dark .dropdown-item:focus {
            background-color: #495057;
        }
        .navbar-nav .dropdown-menu {
            right: 0;
            left: auto;
        }
        .card {
            background-color: #007bff; /* Blue background color */
            color: #fff; /* White text color */
            margin-bottom: 20px;
            transition: background-color 0.3s ease;
        }
        .card:hover {
            background-color: #0056b3; /* Darker blue on hover */
            cursor: pointer;
        }
        .card a {
            color: #fff;
            text-decoration: none;
        }
        .welcome-message {
            text-align: center;
            margin-bottom: 20px;
        }
        .chat-box {
            background-color: #6c757d; /* Dark grey */
            color: #fff;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
            margin-right: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
            }
            .content {
                margin-left: 0;
                padding-top: 20px; /* Add space above content */
            }
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
                margin-bottom: 20px; /* Space below sidebar */
                padding-bottom: 20px;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <span class="chat-box">Chat: <?php echo $unreadMessages; ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Profile: Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-danger" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="wrapper">
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="upload_photograph.php">Manage Photograph</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="upload_video.php">Manage Video</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="upload_gallery.php">Manage Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="upload_design.php">Manage Design</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="upload_service.php">Manage Service</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Manage About
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="view_about.php">View About</a></li>
                            <li><a class="dropdown-item" href="edit_about.php">Edit About</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="content">
            <div class="welcome-message">
                <h1>Welcome, Admin</h1>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Photograph</h5>
                            <p class="card-text">Total: <?php echo $totalPhotographs; ?></p>
                            <a href="view_photographs.php" class="card-link">View Photographs</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Video</h5>
                            <p class="card-text">Total: <?php echo $totalVideos; ?></p>
                            <a href="view_videos.php" class="card-link">View Videos</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Gallery</h5>
                            <p class="card-text">Total: <?php echo $totalGalleries; ?></p>
                            <a href="view_galleries.php" class="card-link">View Galleries</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Design</h5>
                            <p class="card-text">Total: <?php echo $totalDesigns; ?></p>
                            <a href="view_design.php" class="card-link">View Designs</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Service</h5>
                            <p class="card-text">Total: <?php echo $totalService; ?></p>
                            <a href="view_service.php" class="card-link">View Service</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Messages</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                                <th>User Name</th>
                                                <th>Email</th>
                                                <th>Message</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include 'fetch_messages.php'; // Fetch messages from the database
                                        foreach ($messages as $message) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($message['user_name']) . "</td>";
                                            echo "<td>" . htmlspecialchars($message['user_email']) . "</td>";
                                            echo "<td>" . htmlspecialchars($message['message']) . "</td>";
                                            echo "<td>" . htmlspecialchars($message['created_at']) . "</td>";
                                            echo '<td><button type="button" class="btn btn-primary reply-button" data-bs-toggle="modal" data-bs-target="#replyModal" data-id="' . $message['id'] . '" data-name="' . htmlspecialchars($message['user_name']) . '" data-email="' . htmlspecialchars($message['user_email']) . '" data-message="' . htmlspecialchars($message['message']) . '">Reply</button></td>';
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reply Modal -->
            <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="replyModalLabel">Reply to Message</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="reply_message.php">
                                <input type="hidden" name="message_id" id="message_id">
                                <div class="mb-3">
                                    <label for="user_name_modal" class="form-label">User Name</label>
                                    <input type="text" class="form-control" id="user_name_modal" name="user_name" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="user_email_modal" class="form-label">User Email</label>
                                    <input type="email" class="form-control" id="user_email_modal" name="user_email" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="user_message_modal" class="form-label">Message</label>
                                    <textarea class="form-control" id="user_message_modal" name="user_message" rows="3" readonly></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="reply_message" class="form-label">Your Reply</label>
                                    <textarea class="form-control" id="reply" name="reply" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Reply</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var replyButtons = document.querySelectorAll('.reply-button');
            replyButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var messageId = this.getAttribute('data-id');
                    var userName = this.getAttribute('data-name');
                    var userEmail = this.getAttribute('data-email');
                    var userMessage = this.getAttribute('data-message');
                    document.getElementById('message_id').value = messageId;
                    document.getElementById('user_name_modal').value = userName;
                    document.getElementById('user_email_modal').value = userEmail;
                    document.getElementById('user_message_modal').value = userMessage;
                });
            });
        });
    </script>
</body>
</html>
