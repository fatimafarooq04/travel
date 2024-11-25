<?php
require 'connection.php';

if (isset($_GET['id'])) {
    $UserID = (int) $_GET['id']; // Ensure that the ID is an integer

    // Check if UserID is valid
    if ($UserID > 0) {
        $dltquery = "DELETE FROM `user` WHERE UserID=$UserID";
        $result = mysqli_query($conn, $dltquery);

        if ($result) {
            echo "<script>
                alert('Deleted successfully');
                window.location.href='usershow.php';
            </script>";
        } else {
            echo "<script>
                alert('Error deleting record: " . mysqli_error($conn) . "');
                window.location.href='usershow.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Invalid ID specified');
            window.location.href='usershow.php';
        </script>";
    }
} else {
    echo "<script>
        alert('No ID specified');
        window.location.href='usershow.php';
    </script>";
}
?>
