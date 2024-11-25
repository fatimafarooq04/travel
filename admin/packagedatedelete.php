<?php
require "header.php";
require "connection.php";

// Check if the 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Delete dependent records first
    $delete_booking_query = "DELETE FROM package_booking WHERE date_range_id = '$id'";
    mysqli_query($conn, $delete_booking_query);

    // Perform the deletion from the database
    $delete_query = "DELETE FROM tour_package_dates WHERE id = '$id'";
    $result = mysqli_query($conn, $delete_query);

    if ($result) {
        echo "<script>
            alert('Package date deleted successfully');
            window.location.href='packagedateshow.php'; // Redirect to a page that shows package dates
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "No package date ID provided.";
}

// Close the database connection
$conn->close();
require "footer.php";
?>
