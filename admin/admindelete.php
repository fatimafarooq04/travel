<?php
require 'connection.php';

if (isset($_GET['id'])) {
    $AdminID = (int) $_GET['id']; // Ensure that the ID is an integer

    // Check if UserID is valid
    if ($AdminID > 0) {
        $dltquery = "DELETE FROM `admin_user` WHERE AdminID=$AdminID";
        $result = mysqli_query($conn, $dltquery);

        if ($result) {
            echo "<script>
                alert('Deleted successfully');
                window.location.href='adminshow.php';
            </script>";
        } else {
            echo "<script>
                alert('Error deleting record: " . mysqli_error($conn) . "');
                window.location.href='adminshow.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Invalid ID specified');
            window.location.href='adminshow.php';
        </script>";
    }
} else {
    echo "<script>
        alert('No ID specified');
        window.location.href='adminshow.php';
    </script>";
}
?>
