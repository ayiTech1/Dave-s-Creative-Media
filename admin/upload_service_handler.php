<?php
$message = uploadService($_FILES['file'], $conn);
$error = strpos($message, "Error") !== false;
?>