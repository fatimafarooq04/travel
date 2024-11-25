<?php
require "connection.php";

if (isset($_GET['id'])) {
    $team_id = (int) $_GET['id'];

    $deleteQuery = "DELETE FROM `team_info` WHERE `team_id`=$team_id";

    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>
                alert('Deleted Successfully');
                window.location.href='teamshow.php';
            </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "<script>
            alert('No ID provided');
            window.location.href='teamshow.php';
        </script>";
}
?>
