<?php
require 'connection.php';

if (isset($_GET['dltid'])) {
    $day_id = $_GET['dltid'];

    // Delete query
    $dltquery = "DELETE FROM `t_days` WHERE day_id = $day_id";
    $result = mysqli_query($conn, $dltquery);

    if ($result) {
        echo "<script>
                alert('Deleted successfully');
                window.location.href = 'showday.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "No day ID provided.";
}
?>
