<?php
$message = uploadDesign($_FILES['file'], $conn);
$error = strpos($message, "Error") !== false;
?>
