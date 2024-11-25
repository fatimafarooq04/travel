<?php
require "connection.php";
require "header.php";

// Check if the ID parameter exists in the URL
if (isset($_GET['id'])) {
    $destinationID = (int) $_GET['id'];

    // Query to fetch details of the destination including city name
    $qry = "SELECT d.*, c.CityName AS CityName FROM `destination` d
            LEFT JOIN `city` c ON d.CityID = c.CityID
            WHERE d.`DestinationID` = $destinationID";
    $result = mysqli_query($conn, $qry);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['CityName'];
        $description = $row['Description'];
        $country = $row['Country'];
        $state = $row['State'];
        $city = $row['CityName']; // Use CityName from the joined query
        $bestTimeToVisit = $row['BestTimeToVisit'];
        $image1 = $row['Image1'];
        $image2 = $row['Image2'];
        $image3 = $row['Image3'];
        $cardImage = $row['CardImage'];
    } else {
        // Redirect to an error page or handle error appropriately
        header("Location: error.php");
        exit();
    }
} else {
    // Redirect to an error page or handle error appropriately
    header("Location: error.php");
    exit();
}
?>

<div class="container">
    <h1 class="mt-5 mb-4 text-center"><?php echo $name; ?> Details</h1>

    <div class="row mx-4">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo $image1; ?>" class="img-fluid mb-3" alt="<?php echo $name; ?> Image 1" style="max-width: 100%; height: auto;">
                    <h6 class="text-center"><?php echo ($cardImage === $image1) ? "Card Image" : "Image 1"; ?></h6>
                </div>
                <div class="col-md-6">
                    <img src="<?php echo $image2; ?>" class="img-fluid mb-3" alt="<?php echo $name; ?> Image 2" style="max-width: 100%; height: auto;">
                    <h6 class="text-center"><?php echo ($cardImage === $image2) ? "Card Image" : "Image 2"; ?></h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo $image3; ?>" class="img-fluid mb-3" alt="<?php echo $name; ?> Image 3" style="max-width: 100%; height: auto;">
                    <h6 class="text-center"><?php echo ($cardImage === $image3) ? "Card Image" : "Image 3"; ?></h6>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h3>Location</h3>
            <p><strong>Country:</strong> <?php echo $country; ?></p>
            <p><strong>State:</strong> <?php echo $state; ?></p>
            <p><strong>City:</strong> <?php echo $city; ?></p>
            <h3>Description:</h3>
            <p><?php echo $description; ?></p>
            <h3>Best Time To Visit:</h3>
            <p><?php echo $bestTimeToVisit; ?></p>
        </div>
    </div>

    <div class="row mt-4 mx-4">
        <div class="col text-center">
            <a href="destinationedit.php?updid=<?php echo $destinationID; ?>" class="btn btn-sm btn-info mx-2" title="Edit"><i class="fas fa-pencil-alt"></i> Edit</a>
            <a href="destinationdelete.php?dltid=<?php echo $destinationID; ?>" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash-alt"></i> Delete</a>
        </div>
    </div>
</div>

<?php
require "footer.php";
?>
