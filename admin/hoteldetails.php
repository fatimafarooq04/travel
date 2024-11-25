<?php
require "connection.php";
require "header.php";

// Check if the ID parameter exists in the URL
if (isset($_GET['id'])) {
    $hotelID = (int) $_GET['id'];

    // Query to fetch details of the hotel with its destination name and images
    $hotelQuery = "SELECT h.HotelID, h.Name AS HotelName, h.Description, h.Address, h.ContactInfo, d.Name AS DestinationName, h.Image1, h.Image2, h.Image3, h.CardImage
                   FROM hotel h
                   LEFT JOIN destination d ON h.DestinationID = d.DestinationID
                   WHERE h.HotelID = $hotelID";
    
    $hotelResult = mysqli_query($conn, $hotelQuery);

    // Query to fetch facilities associated with the hotel
    $facilityQuery = "SELECT f.FacilityName
                      FROM facility f
                      INNER JOIN hotel_facility hf ON f.FacilityID = hf.FacilityID
                      WHERE hf.HotelID = $hotelID";

    $facilityResult = mysqli_query($conn, $facilityQuery);

    if ($hotelResult && mysqli_num_rows($hotelResult) > 0) {
        $hotelData = mysqli_fetch_assoc($hotelResult);
        $hotelName = $hotelData['HotelName'];
        $description = $hotelData['Description'];
        $address = $hotelData['Address'];
        $contactInfo = $hotelData['ContactInfo'];
        $destinationName = $hotelData['DestinationName'];
        $image1 = $hotelData['Image1'];
        $image2 = $hotelData['Image2'];
        $image3 = $hotelData['Image3'];
        $cardImage = $hotelData['CardImage'];

        // Fetch facilities into an array
        $facilities = [];
        while ($facilityRow = mysqli_fetch_assoc($facilityResult)) {
            $facilities[] = $facilityRow['FacilityName'];
        }
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
    <h1 class="mt-5 mb-4 text-center"><?php echo htmlspecialchars($hotelName); ?> Details</h1>

    <div class="row mx-4">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo htmlspecialchars($image1); ?>" class="img-fluid mb-3" alt="<?php echo htmlspecialchars($hotelName); ?> Image 1" style="max-width: 100%; height: auto;">
                    <h6 class="text-center"><?php echo ($cardImage === $image1) ? "Card Image" : "Image 1"; ?></h6>
                </div>
                <div class="col-md-6">
                    <img src="<?php echo htmlspecialchars($image2); ?>" class="img-fluid mb-3" alt="<?php echo htmlspecialchars($hotelName); ?> Image 2" style="max-width: 100%; height: auto;">
                    <h6 class="text-center"><?php echo ($cardImage === $image2) ? "Card Image" : "Image 2"; ?></h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo htmlspecialchars($image3); ?>" class="img-fluid mb-3" alt="<?php echo htmlspecialchars($hotelName); ?> Image 3" style="max-width: 100%; height: auto;">
                    <h6 class="text-center"><?php echo ($cardImage === $image3) ? "Card Image" : "Image 3"; ?></h6>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h3>Hotel Details</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($hotelName); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($description); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
            <p><strong>Contact Info:</strong> <?php echo htmlspecialchars($contactInfo); ?></p>
            <p><strong>Destination:</strong> <?php echo htmlspecialchars($destinationName); ?></p>

            <h3>Facilities</h3>
            <?php if (!empty($facilities)): ?>
                <ul>
                    <?php foreach ($facilities as $facility): ?>
                        <li><?php echo htmlspecialchars($facility); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No facilities found for this hotel.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mt-4 mx-4">
        <div class="col text-center">
            <a href="hoteledit.php?updid=<?php echo $hotelID; ?>" class="btn btn-sm btn-info mx-2" title="Edit"><i class="fas fa-pencil-alt"></i> Edit</a>
            <a href="hoteldelete.php?dltid=<?php echo $hotelID; ?>" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash-alt"></i> Delete</a>
        </div>
    </div>
</div>

<?php
require "footer.php";
?>
