<?php
// Database connection settings
$servername = "localhost"; // Change to your database server if not localhost
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "carrentaldb"; // The name of your database

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
