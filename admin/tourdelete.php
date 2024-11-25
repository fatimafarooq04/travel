<?php
require 'connection.php';

if (isset($_GET['pack_id'])) {
    $pack_id = $_GET['pack_id'];

    // Delete query
    $dltquery = "DELETE FROM `tour_card` WHERE pack_id = ?";
    $stmt = $conn->prepare($dltquery);
    $stmt->bind_param('i', $pack_id);
    $result = $stmt->execute();

    if ($result) {
        echo "<script>
                alert('Deleted successfully');
                window.location.href = 'tourshow.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "No tour card ID provided.";
}
?>
