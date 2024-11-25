<?php
require "header.php";
require "connection.php";

if (isset($_GET['updid'])) {
    $day_id = $_GET['updid'];
    $selectQuery = "SELECT * FROM `t_days` WHERE day_id = $day_id";
    $result = mysqli_query($conn, $selectQuery);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
} else {
    echo "No day ID provided.";
    exit;
}
?>

<div class="container">
    <h1 class="mt-5">Edit Day</h1>
    <form action="" method="POST" class="mt-4 mx-5">
        <?php
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            ?>
            <div class="form-group">
                <label for="day">Day:</label>
                <input type="text" class="form-control" id="day" name="day" value="<?php echo htmlspecialchars($row['days']); ?>" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary mx-4" name="upd">Update Day</button>
                <button type="reset" class="btn btn-secondary ml-2 mx-4">Reset</button>
            </div>
            <?php
        } else {
            echo "No day found with ID: " . $day_id;
        }
        ?>
    </form>
</div>

<?php
if (isset($_POST['upd'])) {
    $day = $_POST['day'];

    $upd_qry = "UPDATE `t_days` SET `days`='$day' WHERE day_id=$day_id";

    $result = mysqli_query($conn, $upd_qry);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "<script>
        alert('Update Successful');
        window.location.href ='showday.php';
        </script>";
    }
}
?>

<?php
require "footer.php";
?>
