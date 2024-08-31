<?php
$message = uploadPhotograph($_FILES['file'], $conn);
$error = strpos($message, "Error") !== false;
?>