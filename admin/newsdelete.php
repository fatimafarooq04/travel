<?php
require "connection.php";

// Check if the 'dltid' parameter is set
if (isset($_GET['dltid'])) {
    $dltid = (int) $_GET['dltid'];

    // Prepare a statement to delete the record
    $stmt = $conn->prepare("DELETE FROM `news` WHERE `new_id` = ?");
    $stmt->bind_param("i", $dltid);

    // Execute the statement and check if the deletion was successful
    if ($stmt->execute()) {
        echo "<script>
            alert('News entry deleted successfully.');
            window.location.href = 'shownews.php?status=deleted';
        </script>";
    } else {
        echo "<script>
            alert('Error deleting news entry: " . $stmt->error . "');
            window.location.href = 'shownews.php?status=error';
        </script>";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "<script>
        alert('No ID provided to delete.');
        window.location.href = 'shownews.php';
    </script>";
}

// Close the database connection
$conn->close();
?>
