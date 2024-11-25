<?php
require "header.php";
require "connection.php";

if (isset($_GET['updid'])) {
    $CityID = $_GET['updid'];
    $selectQuery = "SELECT * FROM `city` WHERE CityID = $CityID";
    $result = mysqli_query($conn, $selectQuery);
} else {
    echo "No city ID provided.";
    exit;
}
?>

<div class="container">
    <h1 class="mt-5">Edit City</h1>
    <form action="" method="POST" class="mt-4 mx-5">
        <?php
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            ?>
            <div class="form-group">
                <label for="CityName">City Name:</label>
                <input type="text" class="form-control" id="Name" name="CityName" value="<?php echo $row['CityName']; ?>">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary mx-4" name="upd">Update City</button>
                <button type="reset" class="btn btn-secondary ml-2 mx-4">Reset</button>
            </div>
            <?php
        } else {
            echo "No city found with ID: " . $FacilityID;
        }
        ?>
    </form>
</div>

<?php
if (isset($_POST['upd'])) {
    $Name = $_POST['CityName'];

    $upd_qry = "UPDATE `city` SET `CityName`='$Name' WHERE CityID=$CityID";

    $result = mysqli_query($conn, $upd_qry);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "<script>
        alert('Update Successful');
        window.location.href ='cityshow.php';
        </script>";
    }
}
?>

<?php
require "footer.php";
?>
