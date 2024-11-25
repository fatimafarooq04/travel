<?php
require "connection.php";

if (isset($_GET['id'])) {
    $RoomTypeID = (int) $_GET['id'];

    $deleteQuery = "DELETE FROM `room_types` WHERE `RoomTypeID`=$RoomTypeID";

    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>
                alert('Room Type Deleted Successfully');
                window.location.href='roomstypesshow.php';
            </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "<script>
            alert('No ID provided');
            window.location.href='roomstypesshow.php';
        </script>";
}
?>
