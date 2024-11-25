<?php
require "header.php";
require "connection.php";

if (isset($_GET['updid'])) {
    $RoomTypeID = $_GET['updid'];
    $selectQuery = "SELECT * FROM `room_types` WHERE RoomTypeID = $RoomTypeID";
    $result = mysqli_query($conn, $selectQuery);
} else {
    echo "No room_types ID provided.";
    exit;
}
?>

<div class="container">
    <h1 class="mt-5 text-center">Edit Room_Types</h1>
    <form action="" method="POST" class="mt-4 mx-5">
        <?php
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            ?>
            <div class="form-group">
                <label for="Room_Types">Room_Types Name:</label>
                <input type="text" class="form-control" id="Room_Types" name="TypeName" value="<?php echo $row['TypeName']; ?>">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary mx-4" name="upd">Update Room_Types</button>
                <button type="reset" class="btn btn-secondary ml-2 mx-4">Reset</button>
            </div>
            <?php
        } else {
            echo "No facility found with ID: " . $FacilityID;
        }
        ?>
    </form>
</div>

<?php
if (isset($_POST['upd'])) {
    $TypeName = $_POST['TypeName'];

    $upd_qry = "UPDATE `room_types` SET `TypeName`='$TypeName' WHERE RoomTypeID=$RoomTypeID";

    $result = mysqli_query($conn, $upd_qry);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "<script>
        alert('Update Successful');
        window.location.href ='roomstypesshow.php';
        </script>";
    }
}
?>

<?php
require "footer.php";
?>
