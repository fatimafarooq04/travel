<?php
require 'connection.php';

if (isset($_GET['dltid'])) {
    $DestinationID = (int) $_GET['dltid']; // Ensure that the ID is an integer

    $dltquery = "DELETE FROM `contact` WHERE id=$DestinationID";
    $result = mysqli_query($conn, $dltquery);

    if ($result) {
        echo "<script>
            alert('Deleted successfully');
            window.location.href='contactshow.php';
        </script>";
    } else {
        echo "<script>
            alert('Error deleting record: " . mysqli_error($conn) . "');
            window.location.href='contactshow.php';
        </script>";
    }
} else {
    echo "<script>
        alert('No ID specified');
        window.location.href='contactshow.php';
    </script>";
}
?>
