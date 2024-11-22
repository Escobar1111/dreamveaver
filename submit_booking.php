<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carrentaldb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect and sanitize data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $service_type = isset($_POST['service_type']) ? $conn->real_escape_string($_POST['service_type']) : null;
    $car_name = isset($_POST['car_name']) ? $conn->real_escape_string($_POST['car_name']) : null;
    $pickup_location = isset($_POST['pickup_location']) ? $conn->real_escape_string($_POST['pickup_location']) : null;
    $dropoff_location = isset($_POST['dropoff_location']) ? $conn->real_escape_string($_POST['dropoff_location']) : null;
    $pickup_date = isset($_POST['pickup_date']) ? $conn->real_escape_string($_POST['pickup_date']) : null;
    $dropoff_date = isset($_POST['dropoff_date']) ? $conn->real_escape_string($_POST['dropoff_date']) : null;
    $requests = isset($_POST['requests']) ? $conn->real_escape_string($_POST['requests']) : '';

    // SQL query
    $sql = "INSERT INTO car_bookings (name, email, phone, service_type, car_name, pickup_location, dropoff_location, pickup_date, dropoff_date, requests)
            VALUES ('$name', '$email', '$phone', '$service_type', '$car_name', '$pickup_location', '$dropoff_location', '$pickup_date', '$dropoff_date', '$requests')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        // Save booking data in the session
        $_SESSION['booking_info'] = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'service_type' => $service_type,
            'car_name' => $car_name,
            'pickup_location' => $pickup_location,
            'dropoff_location' => $dropoff_location,
            'pickup_date' => $pickup_date,
            'dropoff_date' => $dropoff_date,
            'requests' => $requests,
        ];

        // Redirect to confirm booking page
        header("Location: confirm_booking.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
