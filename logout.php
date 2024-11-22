<?php
session_start();
session_destroy(); // Destroy the session
header("Location: admin login.php"); // Redirect to the login page
exit;
?>