<?php
require "header.php";
require "connection.php";

// Fetch packages from the database
$packages_query = "SELECT pack_id, pack_name FROM tour_card";
$packages_result = mysqli_query($conn, $packages_query);

// Fetch days from the database
$days_query = "SELECT day_id, days FROM t_days";
$days_result = mysqli_query($conn, $days_query);
?>

<div class="container">
    <h1 class="mt-5 text-center">Add Itinerary</h1>
    <form action="" method="POST" class="mt-4 mx-5">
        <div class="form-group">
            <label for="PackID">Package:</label>
            <select class="form-control" id="PackID" name="PackID" required>
                <option value="" disabled selected>Select a package</option>
                <?php while ($row = mysqli_fetch_assoc($packages_result)) { ?>
                    <option value="<?php echo $row['pack_id']; ?>"><?php echo $row['pack_name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="DayID">Day:</label>
            <select class="form-control" id="DayID" name="DayID" required>
                <option value="" disabled selected>Select a day</option>
                <?php while ($row = mysqli_fetch_assoc($days_result)) { ?>
                    <option value="<?php echo $row['day_id']; ?>"><?php echo $row['days']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Description">Description:</label>
            <textarea class="form-control" id="Description" name="Description" rows="4" required></textarea>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mx-4" name="submit">Add Itinerary</button>
            <button type="reset" class="btn btn-secondary mx-4">Reset</button>
        </div>
    </form>
</div>

<?php
require "footer.php";
?>
<?php
require "connection.php";

if (isset($_POST['submit'])) {
    // Collect form data
    $PackID = $_POST['PackID'];
    $DayID = $_POST['DayID'];
    $Description = $_POST['Description'];

    // Prepare the SQL query
    $insert_query = "INSERT INTO package_itinerary (PackID, DayID, Description) 
                     VALUES (?, ?, ?)";

    // Prepare statement
    if ($stmt = mysqli_prepare($conn, $insert_query)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "iis", $PackID, $DayID, $Description);

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                alert('Itinerary Added Successfully');
                window.location.href='itineraryshow.php'; // Redirect to the page showing itineraries
            </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing the query: " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
?>
