<?php
require "header.php";
require "connection.php";
?>
<div class="container">
    <h1 class="mt-5 text-center">Add Services</h1>
    <form action="#" method="POST" class="mt-4 mx-5">
        <div class="form-group">
            <label for="ServiceName">Service Name:</label>
            <input type="text" class="form-control" id="ServiceName" name="service_name" required>
        </div>

        <div class="form-group">
            <label for="ServiceDesc">Service Description:</label>
            <input type="text" class="form-control" id="ServiceDesc" name="service_desc" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mx-4" name="sub">Add Service</button>
            <button type="reset" class="btn btn-secondary ml-2 mx-4">Reset</button>
        </div>
    </form>
</div>

<?php
if (isset($_POST['sub'])) {
    $service_name = $_POST['service_name'];
    $service_desc = $_POST['service_desc'];

    // Properly escape variables to prevent SQL injection
    $service_name = mysqli_real_escape_string($conn, $service_name);
    $service_desc = mysqli_real_escape_string($conn, $service_desc);

    // Corrected Insert Query
    $insertQuery = "INSERT INTO services (service_name, service_desc) VALUES ('$service_name', '$service_desc')";

    if (mysqli_query($conn, $insertQuery)) {
        // Facility added successfully, redirect or show success message
        echo "<script>
                alert('Service Added Successfully');
                window.location.href='serviceshow.php';
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