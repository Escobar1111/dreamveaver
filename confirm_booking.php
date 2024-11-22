<?php
session_start();

// Check if booking information exists in the session
if (!isset($_SESSION['booking_info'])) {
    die("No booking information found. Please go back and try again.");
}

// Retrieve booking information from the session
$bookingInfo = $_SESSION['booking_info'];

// Extract booking details
$name = $bookingInfo['name'];
$email = $bookingInfo['email'];
$phone = $bookingInfo['phone'];
$service_type = $bookingInfo['service_type'];
$car_name = $bookingInfo['car_name'];
$pickup_location = $bookingInfo['pickup_location'];
$dropoff_location = $bookingInfo['dropoff_location'];
$pickup_date = $bookingInfo['pickup_date'];
$dropoff_date = $bookingInfo['dropoff_date'];
$requests = $bookingInfo['requests'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .confirmation-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .confirmation-container h2 {
            text-align: center;
            color: #e67e22;
        }
        .confirmation-item {
            margin-bottom: 15px;
        }
        .confirmation-item span {
            font-weight: bold;
        }
        footer {
            background-color: #000;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        footer a {
            color: #e67e22;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="confirmation-container">
        <h2>Booking Confirmation</h2>
        <div class="confirmation-item">
            <span>Name:</span> <?php echo htmlspecialchars($name); ?>
        </div>
        <div class="confirmation-item">
            <span>Email:</span> <?php echo htmlspecialchars($email); ?>
        </div>
        <div class="confirmation-item">
            <span>Phone:</span> <?php echo htmlspecialchars($phone); ?>
        </div>
        <div class="confirmation-item">
            <span>Service Type:</span> <?php echo htmlspecialchars($service_type); ?>
        </div>
        <div class="confirmation-item">
            <span>Car Name:</span> <?php echo htmlspecialchars($car_name); ?>
        </div>
        <div class="confirmation-item">
            <span>Pickup Location:</span> <?php echo htmlspecialchars($pickup_location); ?>
        </div>
        <div class="confirmation-item">
            <span>Dropoff Location:</span> <?php echo htmlspecialchars($dropoff_location); ?>
        </div>
        <div class="confirmation-item">
            <span>Pickup Date:</span> <?php echo htmlspecialchars($pickup_date); ?>
        </div>
        <div class="confirmation-item">
            <span>Dropoff Date:</span> <?php echo htmlspecialchars($dropoff_date); ?>
        </div>
        <div class="confirmation-item">
            <span>Special Requests:</span> <?php echo htmlspecialchars($requests); ?>
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <a href="home.html" style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #e67e22; text-decoration: none; border-radius: 5px;">
                Back to Home
            </a>
        </div>
    </div>

</body>
</html>
