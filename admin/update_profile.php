<?php
session_start();

// Check if user is logged in and role is admin
if (isset($_SESSION['Role']) && $_SESSION['Role'] == "Admin") {
    // Include your database connection file
    include('connection.php');

    // Get form data
    $adminID = $_POST['AdminID'];
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $phone = $_POST['Phone'];

    // Update admin details in the database
    $query = "UPDATE `admin_user` SET `Name` = ?, `Email` = ?, `Phone` = ? WHERE `AdminID` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $name, $email, $phone, $adminID);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Profile updated successfully.";
    } else {
        $_SESSION['message'] = "Failed to update profile.";
    }

    // Redirect to profile page
    header("Location: profile.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
