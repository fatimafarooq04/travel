<?php
require "connection.php";

// Get the ItineraryID from the URL
$itinerary_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($itinerary_id <= 0) {
    echo "<script>
        alert('Invalid itinerary ID.');
        window.location.href ='itineraryshow.php';
    </script>";
    exit;
}

// Prepare and execute the delete query
$delete_query = "DELETE FROM package_itinerary WHERE ItineraryID = $itinerary_id";

if (mysqli_query($conn, $delete_query)) {
    echo "<script>
        alert('Itinerary deleted successfully.');
        window.location.href ='itineraryshow.php';
    </script>";
} else {
    echo "<script>
        alert('Error deleting itinerary: " . mysqli_error($conn) . "');
        window.location.href ='itineraryshow.php';
    </script>";
}

// Close the connection
mysqli_close($conn);
?>
