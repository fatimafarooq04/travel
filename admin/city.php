<?php
require "header.php";
require "connection.php";
?>
<div class="container">
    <h1 class="mt-5 text-center">Add City</h1>
    <form action="#" method="POST" class="mt-4 mx-5">
        <div class="form-group">
            <label for="CityName">City Name:</label>
            <input type="text" class="form-control" id="CityName" name="Name" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mx-4" name="sub">Add City</button>
            <button type="reset" class="btn btn-secondary ml-2 mx-4">Reset</button>
            <button type="button" class="btn btn-info mx-4" onclick="history.back()">Back</button>
        </div>
    </form>
</div>

<?php
if (isset($_POST['sub'])) {
    $Name = $_POST['Name'];

    // Insert query to add city
    $insertQuery = "INSERT INTO city (CityName) VALUES ('$Name')";

    if (mysqli_query($conn, $insertQuery)) {
        // City added successfully, redirect or show success message
        echo "<script>
                alert('City Added Successfully');
                window.location.href='cityshow.php';
            </script>";
    } else {
        // Error in adding city
        echo "Error: " . mysqli_error($conn);
    }
}
require "footer.php";
?>
