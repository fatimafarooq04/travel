<?php
require "header.php";
require "connection.php";
?>
<div class="container">
    <h1 class="mt-5 text-center">Add Day</h1>
    <form action="#" method="POST" class="mt-4 mx-5">
        <div class="form-group">
            <label for="days">Days:</label>
            <input type="number" class="form-control" id="days" name="days" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mx-4" name="sub">Add Day</button>
            <button type="reset" class="btn btn-secondary ml-2 mx-4">Reset</button>
            <button type="button" class="btn btn-info mx-4" onclick="history.back()">Back</button>
        </div>
    </form>
</div>

<?php
if (isset($_POST['sub'])) {
    $days = $_POST['days'];

    // Insert query to add day
    $insertQuery = "INSERT INTO t_days (days) VALUES ('$days')";

    if (mysqli_query($conn, $insertQuery)) {
        // Day added successfully, redirect or show success message
        echo "<script>
                alert('Day Added Successfully');
                window.location.href='showday.php';
            </script>";
    } else {
        // Error in adding day
        echo "Error: " . mysqli_error($conn);
    }
}
require "footer.php";
?>
