<?php
require "connection.php";
require "header.php";

// Check if the ID parameter exists in the URL
if (isset($_GET['id'])) {
    $roomID = (int) $_GET['id'];

    // Query to fetch details of the room including hotel name and room type
    $qry = "SELECT r.*, h.Name AS HotelName, rt.TypeName AS RoomTypeName
            FROM `room` r
            LEFT JOIN `hotel` h ON r.HotelID = h.HotelID
            LEFT JOIN `room_types` rt ON r.RoomTypeID = rt.RoomTypeID
            WHERE r.`RoomID` = $roomID";
    $result = mysqli_query($conn, $qry);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hotelName = $row['HotelName'];
        $roomTypeName = $row['RoomTypeName'];
        $price = $row['Price'];
        $description = $row['Description'];
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
    <h1 class="mt-5 mb-4 text-center">Hotel Details</h1>

    <div class="row mx-4">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo $image1; ?>" class="img-fluid mb-3" alt="Room Image 1" style="max-width: 100%; height: auto;">
                    <h6 class="text-center"><?php echo ($cardImage === $image1) ? "Card Image" : "Image 1"; ?></h6>
                </div>
                <div class="col-md-6">
                    <img src="<?php echo $image2; ?>" class="img-fluid mb-3" alt="Room Image 2" style="max-width: 100%; height: auto;">
                    <h6 class="text-center"><?php echo ($cardImage === $image2) ? "Card Image" : "Image 2"; ?></h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo $image3; ?>" class="img-fluid mb-3" alt="Room Image 3" style="max-width: 100%; height: auto;">
                    <h6 class="text-center"><?php echo ($cardImage === $image3) ? "Card Image" : "Image 3"; ?></h6>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h3>Hotel Information</h3>
            <p><strong>Hotel Name:</strong> <?php echo $hotelName; ?></p>
            <p><strong>Room Type:</strong> <?php echo $roomTypeName; ?></p>
            <p><strong>Price:</strong> <?php echo $price; ?></p>
            <h3>Description:</h3>
            <p><?php echo $description; ?></p>
        </div>
    </div>

    <div class="row mt-4 mx-4">
        <div class="col text-center">
            <a href="roomedit.php?updid=<?php echo $roomID; ?>" class="btn btn-sm btn-info mx-2" title="Edit"><i class="fas fa-pencil-alt"></i> Edit</a>
            <a href="roomdelete.php?dltid=<?php echo $roomID; ?>" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash-alt"></i> Delete</a>
        </div>
    </div>
</div>

<?php
require "footer.php";
?>
