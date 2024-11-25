<?php
require 'connection.php'; // Include your database connection file

// Check if 'pack_id' is passed in the request
if (isset($_GET['pack_id'])) {
    $pack_id = mysqli_real_escape_string($conn, $_GET['pack_id']);
    
    // Query to get the number of days for the selected package
    $sql = "SELECT d.days 
            FROM tour_card t
            JOIN t_days d ON t.day_id = d.day_id
            WHERE t.pack_id = '$pack_id'";
    
    $result = mysqli_query($conn, $sql);
    
    // Check if the query returns a result
    if ($result && $row = mysqli_fetch_assoc($result)) {
        // Send the number of days as JSON
        echo json_encode(['day_count' => $row['days']]);
    } else {
        // Send an error message if no data is found
        echo json_encode(['day_count' => 0]);
    }
    
    mysqli_close($conn); // Close the database connection
} else {
    // Handle the case where 'pack_id' is not provided
    echo json_encode(['day_count' => 0]);
}
?>
