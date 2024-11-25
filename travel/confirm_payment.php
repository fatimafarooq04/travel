<?php
session_start(); // Ensure the session is started
require "connection.php"; // Adjust based on your file structure

// Check if bookingID is provided
if (isset($_POST['bookingID'])) {
    $bookingID = $_POST['bookingID'];

    // Update booking status to 'confirmed'
    $updateQuery = "UPDATE package_booking SET status = 'confirmed' WHERE booking_id = ?";
    $stmt = $conn->prepare($updateQuery);
    if ($stmt) {
        $stmt->bind_param("i", $bookingID);
        if ($stmt->execute()) {
            // Update booking status in the session
            $_SESSION['booking']['status'] = 'confirmed';
            // Redirect to booking status page
            header("Location: booking_status.php");
            exit();
        } else {
            echo "<div class='container py-5'><div class='alert alert-danger'>Error updating booking status.</div></div>";
        }
        $stmt->close();
    } else {
        echo "<div class='container py-5'><div class='alert alert-danger'>Error preparing update query.</div></div>";
    }
} else {
    echo "<div class='container py-5'><div class='alert alert-danger'>No booking ID provided.</div></div>";
}

$conn->close();
?>
