<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Admin Dashboard</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Profile: <?php echo htmlspecialchars($_SESSION['username']); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-danger" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
