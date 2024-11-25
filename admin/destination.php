<?php
require "header.php"; // Include necessary files
require "connection.php";

if (isset($_POST['sub'])) {
    // Retrieve and escape input data
    $Name = mysqli_real_escape_string($conn, $_POST['Name']);
    $Description = mysqli_real_escape_string($conn, $_POST['Description']);
    $State = mysqli_real_escape_string($conn, $_POST['State']);
    $City = mysqli_real_escape_string($conn, $_POST['City']);
    $BestTimeToVisit = mysqli_real_escape_string($conn, $_POST['BestTimeToVisit']);

    // Handle Image 1
    $ImageUrl1 = $_FILES['image1'];
    $imagename1 = mysqli_real_escape_string($conn, $ImageUrl1['name']);
    $actualpath1 = $ImageUrl1['tmp_name'];
    $mypath1 = "images/" . $imagename1;

    // Handle Image 2
    $ImageUrl2 = $_FILES['image2'];
    $imagename2 = mysqli_real_escape_string($conn, $ImageUrl2['name']);
    $actualpath2 = $ImageUrl2['tmp_name'];
    $mypath2 = "images/" . $imagename2;

    // Handle Image 3
    $ImageUrl3 = $_FILES['image3'];
    $imagename3 = mysqli_real_escape_string($conn, $ImageUrl3['name']);
    $actualpath3 = $ImageUrl3['tmp_name'];
    $mypath3 = "images/" . $imagename3;

    // Check if the file extensions are allowed
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $fileExtension1 = strtolower(pathinfo($imagename1, PATHINFO_EXTENSION));
    $fileExtension2 = strtolower(pathinfo($imagename2, PATHINFO_EXTENSION));
    $fileExtension3 = strtolower(pathinfo($imagename3, PATHINFO_EXTENSION));

    if (in_array($fileExtension1, $allowedExtensions) && in_array($fileExtension2, $allowedExtensions) && in_array($fileExtension3, $allowedExtensions)) {
        move_uploaded_file($actualpath1, $mypath1);
        move_uploaded_file($actualpath2, $mypath2);
        move_uploaded_file($actualpath3, $mypath3);

        // Determine which image to set as the card image
        $card_image = $_POST['card_image'];
        $cardImagePath = "";

        if ($card_image === "image1") {
            $cardImagePath = $mypath1;
        } elseif ($card_image === "image2") {
            $cardImagePath = $mypath2;
        } elseif ($card_image === "image3") {
            $cardImagePath = $mypath3;
        }

        // Prepare the SQL query
        $Insert_qry = "INSERT INTO `destination` (`Name`, `Description`, `State`, `CityID`, `BestTimeToVisit`, `Image1`, `Image2`, `Image3`, `CardImage`) 
                       VALUES ('$Name', '$Description', '$State', '$City', '$BestTimeToVisit', '$mypath1', '$mypath2', '$mypath3', '$cardImagePath')";

        // Execute the SQL query
        $res = mysqli_query($conn, $Insert_qry);

        if ($res) {
            echo "<script>
                alert('Destination Added Successfully');
                window.location.href='destinationshow.php';
            </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>
            alert('Sorry, only JPG, JPEG, and PNG files are allowed.');
            window.location.href='destination.php';
        </script>";
    }
}

// Fetch cities from the city table
$sql = "SELECT CityID, CityName FROM city";
$result = $conn->query($sql);

$cities = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $cities[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<div class="container">
    <h1 class="mt-5 text-center">Add Destination</h1>
    <form action="#" method="POST" class="mt-4 mx-5" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="Name" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="Description" rows="4" required></textarea>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="state">State:</label>
                    <input type="text" class="form-control" id="state" name="State" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="city">City:</label>
                    <select class="form-control" id="city" name="City" required>
                        <option value="">Select a city</option>
                        <?php foreach($cities as $city): ?>
                            <option value="<?php echo $city['CityID']; ?>"><?php echo $city['CityName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="bestTimeToVisit">Best Time to Visit:</label>
                    <input type="text" class="form-control" id="bestTimeToVisit" name="BestTimeToVisit" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image1">Image 1:</label>
                    <input type="file" class="form-control" id="image1" name="image1" accept=".jpg,.jpeg,.png" required>
                    <label><input type="radio" name="card_image" value="image1" checked> Set as Card Image</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image2">Image 2:</label>
                    <input type="file" class="form-control" id="image2" name="image2" accept=".jpg,.jpeg,.png" required>
                    <label><input type="radio" name="card_image" value="image2"> Set as Card Image</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image3">Image 3:</label>
                    <input type="file" class="form-control" id="image3" name="image3" accept=".jpg,.jpeg,.png" required>
                    <label><input type="radio" name="card_image" value="image3"> Set as Card Image</label>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mx-4" name="sub">Add Destination</button>
            <button type="reset" class="btn btn-secondary ml-2 mx-4">Reset</button>
        </div>
    </form>
</div>

<?php
require "footer.php";
?>
