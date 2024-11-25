<?php
require "header.php";
require "connection.php";
?>
<div class="container">
    <h1 class="mt-5 text-center">Add Facility</h1>
    <form action="#" method="POST" class="mt-4 mx-5">
        <div class="form-group">
            <label for="facilityName">Facility Name:</label>
            <input type="text" class="form-control" id="facilityName" name="facilityName" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mx-4" name="sub">Add Facility</button>
            <button type="reset" class="btn btn-secondary ml-2 mx-4">Reset</button>
        </div>
    </form>
</div>

<?php
if (isset($_POST['sub'])) {
    $facilityName = $_POST['facilityName'];

    // Insert query to add facility
    $insertQuery = "INSERT INTO facility (FacilityName) VALUES ('$facilityName')";

    if (mysqli_query($conn, $insertQuery)) {
        // Facility added successfully, redirect or show success message
        echo "<script>
                alert('Facility Added Successfully');
                window.location.href='facilityshow.php';
            </script>";
    } else {
        // Error in adding facility
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<?php
require "footer.php";
?>