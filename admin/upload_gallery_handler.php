<?php
$message = uploadGallery($_FILES['file'], $conn);
$error = strpos($message, "Error") !== false;
?>
