<?php
session_start();

require 'db_connect.php'; // Ensure this file connects to your database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug POST data
    // Uncomment for debugging if needed
    // var_dump($_POST);
    // exit;

    // Ensure all required fields are provided
    if (
        isset($_POST['id'], $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['service_type'], 
              $_POST['car_name'], $_POST['pickup_location'], $_POST['dropoff_location'], 
              $_POST['pickup_date'], $_POST['dropoff_date'], $_POST['requests'])
    ) {
        // Sanitize input
        $id = intval($_POST['id']);
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $phone = htmlspecialchars(trim($_POST['phone']));
        $service_type = htmlspecialchars(trim($_POST['service_type'])); // Fixed variable
        $car_name = htmlspecialchars(trim($_POST['car_name']));
        $pickup_location = htmlspecialchars(trim($_POST['pickup_location']));
        $dropoff_location = htmlspecialchars(trim($_POST['dropoff_location']));
        $pickup_date = htmlspecialchars(trim($_POST['pickup_date']));
        $dropoff_date = htmlspecialchars(trim($_POST['dropoff_date']));
        $requests = htmlspecialchars(trim($_POST['requests']));

        // Update query
        $sql = "
            UPDATE bookings 
            SET 
                name = ?, 
                email = ?, 
                phone = ?, 
                service_type = ?, 
                car_name = ?, 
                pickup_location = ?, 
                dropoff_location = ?, 
                pickup_date = ?, 
                dropoff_date = ?, 
                requests = ? 
            WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param(
                "ssssssssssi",
                $name,
                $email,
                $phone,
                $service_type,
                $car_name,
                $pickup_location,
                $dropoff_location,
                $pickup_date,
                $dropoff_date,
                $requests,
                $id
            );

            if ($stmt->execute()) {
                // Redirect back to the admin dashboard with success message
                $_SESSION['success_message'] = "Booking updated successfully!";
                header("Location: admin_dashboard.php");
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "Required fields are missing.";
    }
} else {
    echo "Invalid request.";
}
?>
