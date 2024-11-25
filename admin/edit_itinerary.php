<?php
require "header.php";
require "connection.php";

// Get the ItineraryID from the URL
$itinerary_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($itinerary_id <= 0) {
    die("Invalid itinerary ID.");
}

// Fetch the existing details of the itinerary
$query = "
    SELECT pi.ItineraryID, pi.PackID, tc.pack_desc, d.day_id, d.days, pi.Description
    FROM package_itinerary pi
    JOIN tour_card tc ON pi.PackID = tc.pack_id
    JOIN t_days d ON pi.DayID = d.day_id
    WHERE pi.ItineraryID = $itinerary_id
";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

$itinerary = mysqli_fetch_assoc($result);

if (!$itinerary) {
    die("Itinerary not found.");
}

// Fetch all packages and days for dropdown options
$packages_query = "SELECT pack_id, pack_name FROM tour_card";
$packages_result = mysqli_query($conn, $packages_query);

$days_query = "SELECT day_id, days FROM t_days";
$days_result = mysqli_query($conn, $days_query);

?>

<div class="container">
    <h1 class="mt-5 text-center">Edit Itinerary</h1>

    <form action="" method="post" class="mt-4 mx-5">
        <input type="hidden" name="ItineraryID" value="<?php echo htmlspecialchars($itinerary['ItineraryID']); ?>">

        <div class="mb-3">
            <label for="PackID" class="form-label">Package</label>
            <select id="PackID" name="PackID" class="form-select" required>
                <?php while ($package = mysqli_fetch_assoc($packages_result)): ?>
                    <option value="<?php echo $package['pack_id']; ?>" <?php if ($package['pack_id'] == $itinerary['PackID']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($package['pack_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="DayID" class="form-label">Day</label>
            <select id="DayID" name="DayID" class="form-select" required>
                <?php while ($day = mysqli_fetch_assoc($days_result)): ?>
                    <option value="<?php echo $day['day_id']; ?>" <?php if ($day['day_id'] == $itinerary['day_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($day['days']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="Description" class="form-label">Description</label>
            <textarea id="Description" name="Description" class="form-control" rows="4" required><?php echo htmlspecialchars($itinerary['Description']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Itinerary</button>
    </form>
</div>

<?php
require "footer.php";
?>
<?php
require "connection.php";

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form inputs
    $itinerary_id = isset($_POST['ItineraryID']) ? (int) $_POST['ItineraryID'] : 0;
    $pack_id = isset($_POST['PackID']) ? (int) $_POST['PackID'] : 0;
    $day_id = isset($_POST['DayID']) ? (int) $_POST['DayID'] : 0;
    $description = isset($_POST['Description']) ? mysqli_real_escape_string($conn, $_POST['Description']) : '';

    // Validate inputs
    if ($itinerary_id <= 0 || $pack_id <= 0 || $day_id <= 0 || empty($description)) {
        die("Invalid input.");
    }

    // Prepare the SQL query
    $query = "
        UPDATE package_itinerary
        SET PackID = $pack_id,
            DayID = $day_id,
            Description = '$description'
        WHERE ItineraryID = $itinerary_id
    ";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        echo "<script>
            alert('Itinerary updated successfully');
            window.location.href ='itineraryshow.php';
        </script>";
    } else {
        echo "<script>
            alert('Error updating itinerary: " . mysqli_error($conn) . "');
            window.location.href ='itineraryshow.php';
        </script>";
    }

    // Close the connection
    mysqli_close($conn);
} else {
    // Redirect to the itinerary list page if the form was not submitted properly
    header("Location: itineraryshow.php?message=Invalid request.");
}
?>
