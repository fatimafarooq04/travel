<?php
require "header.php";
require "connection.php";

if (isset($_GET['id'])) {
    $room_id = $_GET['id'];
    
    // Delete room facilities first
    $delete_facilities_query = "DELETE FROM hotel_room_facilities WHERE room_id = '$room_id'";
    mysqli_query($conn, $delete_facilities_query);

    // Delete the room
    $delete_room_query = "DELETE FROM hotel_rooms WHERE room_id = '$room_id'";
    $res = mysqli_query($conn, $delete_room_query);

    if ($res) {
        echo "<script>
            alert('Room Deleted Successfully');
            window.location.href='tableshow.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid Room ID!";
}

require "footer.php";
?>
