<?php
require "header.php";
require "connection.php";

if (isset($_GET['updid'])) {
    $FacilityID = $_GET['updid'];
    $selectQuery = "SELECT * FROM `facility` WHERE FacilityID = $FacilityID";
    $result = mysqli_query($conn, $selectQuery);
} else {
    echo "No facility ID provided.";
    exit;
}
?>

<div class="container">
    <h1 class="mt-5 text-center">Edit Facility</h1>
    <form action="" method="POST" class="mt-4 mx-5">
        <?php
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            ?>
            <div class="form-group">
                <label for="facilityName">Facility Name:</label>
                <input type="text" class="form-control" id="facilityName" name="FacilityName" value="<?php echo $row['FacilityName']; ?>">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary mx-4" name="upd">Update Facility</button>
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
    $FacilityName = $_POST['FacilityName'];

    $upd_qry = "UPDATE `facility` SET `FacilityName`='$FacilityName' WHERE FacilityID=$FacilityID";

    $result = mysqli_query($conn, $upd_qry);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "<script>
        alert('Update Successful');
        window.location.href ='facilityshow.php';
        </script>";
    }
}
?>

<?php
require "footer.php";
?>
