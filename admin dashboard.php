<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: admin login.php");
    exit;
}

require 'db_connection.php'; // Ensure you have a database connection file

// Fetch all booking records for display
$sql = "SELECT * FROM car_bookings";
$result = $conn->query($sql);

// Check for query error
if ($result === false) {
    echo "Error fetching records: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Esco Car Rental</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1500px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #000000;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .button {
            padding: 0.5rem 1rem;
            color: white;
            background-color: #000000;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin-right: 0.5rem;
        }
        .button:hover {
            background-color: #333;
        }
        .link-button {
            text-decoration: none;
            color: #FFD700;
        }
        .link-button:hover {
            color: #000000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <table>
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Service Type</th>
                    <th>Car Name</th>
                    <th>Pickup Location</th>
                    <th>Dropoff Location</th>
                    <th>Pickup Date</th>
                    <th>Dropoff Date</th>
                    <th>Requests</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['phone']) ?></td>
                            <td><?= htmlspecialchars($row['service_type']) ?></td>
                            <td><?= htmlspecialchars($row['car_name']) ?></td>
                            <td><?= htmlspecialchars($row['pickup_location']) ?></td>
                            <td><?= htmlspecialchars($row['dropoff_location']) ?></td>
                            <td><?= htmlspecialchars($row['pickup_date']) ?></td>
                            <td><?= htmlspecialchars($row['dropoff_date']) ?></td>
                            <td><?= htmlspecialchars($row['requests']) ?></td>
                            <td>
                                <!-- Edit link -->
                                <a href="edit.php?id=<?= urlencode($row['id']) ?>" class="link-button">Edit</a>

                                <!-- Delete link -->
                                <a href="delete.php?id=<?= urlencode($row['id']) ?>" 
                                   class="link-button" 
                                   onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Back to Admin Panel button -->
        <a href="logout.php" class="button">logout</a>
    </div>
</body>
</html>
