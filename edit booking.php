<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit;
}

require 'db_connection.php'; // Ensure this file connects to your database

// Check if the ID is passed in the URL
if (!isset($_GET['id'])) {
    echo "Invalid booking ID.";
    exit;
}

// Fetch the record to edit
$id = intval($_GET['id']);
$sql = "SELECT * FROM car_bookings WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    echo "Booking not found.";
    exit;
}

// Handle the form submission to update the record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $service_type = $_POST['service_type'];
    $car_name = $_POST['car_name'];
    $pickup_location = $_POST['pickup_location'];
    $dropoff_location = $_POST['dropoff_location'];
    $pickup_date = $_POST['pickup_date'];
    $dropoff_date = $_POST['dropoff_date'];
    $requests = $_POST['requests'];

    $update_sql = "
        UPDATE car_bookings 
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
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param(
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

    if ($update_stmt->execute()) {
        echo "<script>alert('Booking updated successfully!'); window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        form .form-group {
            margin-bottom: 1.5rem;
        }
        form .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }
        form .form-group input, 
        form .form-group select, 
        form .form-group textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        form .form-group textarea {
            resize: none;
            height: 80px;
        }
        .button {
            padding: 0.7rem 1.5rem;
            background-color: #000000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #FFD700;
        }
        .back-link {
            display: block;
            margin-top: 1rem;
            text-align: center;
            color: #000000;
            text-decoration: none;
        }
    </style>
	<!-- Modal HTML -->
<div id="successModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="document.getElementById('successModal').style.display='none'">&times;</span>
        <h2>Booking Updated Successfully!</h2>
        <p>Your booking details have been successfully updated.</p>
        <button onclick="window.location.href='admin dashboard.php';">Close</button>
    </div>
</div>

<!-- Modal Styles -->
<style>
    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed;
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0,0,0,0.4); /* Black w/opacity */
        padding-top: 60px;
    }

    /* Modal Content */
    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        text-align: center;
    }

    /* Close Button */
    .close-btn {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        top: 10px;
        right: 25px;
        font-family: Arial, sans-serif;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Button Styling */
    button {
        background-color: #ff0000;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    button:hover {
        background-color: #000000;
    }
</style>
</head>
<body>
    <div class="container">
        <h1>Edit Booking</h1>
        <form method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($booking['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($booking['email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($booking['phone']) ?>" required>
            </div>
            <div class="form-group">
                <label for="service_type">Service Type</label>
                <select id="service_type" name="service_type" required>
                    <option value="Chauffeur" <?= $booking['service_type'] === 'Chauffeur' ? 'selected' : '' ?>>Chauffeur</option>
                    <option value="Luxury SUV" <?= $booking['service_type'] === 'Luxury SUV' ? 'selected' : '' ?>>Luxury SUV</option>
                    <option value="Sports Car" <?= $booking['service_type'] === 'Sports Car' ? 'selected' : '' ?>>Sports Car</option>
                    <option value="Convertible" <?= $booking['service_type'] === 'Convertible' ? 'selected' : '' ?>>Convertible</option>
                </select>
            </div>
            <div class="form-group">
                <label for="car_name">Car Name</label>
                <input type="text" id="car_name" name="car_name" value="<?= htmlspecialchars($booking['car_name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="pickup_location">Pickup Location</label>
                <input type="text" id="pickup_location" name="pickup_location" value="<?= htmlspecialchars($booking['pickup_location']) ?>">
            </div>
            <div class="form-group">
                <label for="dropoff_location">Dropoff Location</label>
                <input type="text" id="dropoff_location" name="dropoff_location" value="<?= htmlspecialchars($booking['dropoff_location']) ?>">
            </div>
            <div class="form-group">
                <label for="pickup_date">Pickup Date</label>
                <input type="date" id="pickup_date" name="pickup_date" value="<?= htmlspecialchars($booking['pickup_date']) ?>" required>
            </div>
            <div class="form-group">
                <label for="dropoff_date">Dropoff Date</label>
                <input type="date" id="dropoff_date" name="dropoff_date" value="<?= htmlspecialchars($booking['dropoff_date']) ?>" required>
            </div>
            <div class="form-group">
                <label for="requests">Additional Requests</label>
                <textarea id="requests" name="requests"><?= htmlspecialchars($booking['requests']) ?></textarea>
            </div>
            <button type="submit" class="button">Update Booking</button>
        </form>
        <a href="admin_dashboard.php" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html>
