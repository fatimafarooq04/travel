<?php
require "connection.php";
require "header.php";

// Check if the ID parameter exists in the URL
if (isset($_GET['pack_id'])) {
    $pack_id = (int)$_GET['pack_id'];

    // Query to fetch details of the tour package, including city, hotel names, and days
    $qry = "SELECT t.*, c.CityName, h.Name AS HotelName, d.days AS DayCount
            FROM tour_card t
            LEFT JOIN city c ON t.CityID = c.CityID
            LEFT JOIN hotel h ON t.HotelID = h.HotelID
            LEFT JOIN t_days d ON t.day_id = d.day_id
            WHERE t.pack_id = $pack_id";
    $result = mysqli_query($conn, $qry);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['pack_name'];
        $description = $row['pack_desc'];
        $price = $row['pack_price'];
        $city = $row['CityName'];
        $hotel = $row['HotelName'];
        $dayCount = $row['DayCount'];
        $image = $row['pack_img'];
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
    <h1 class="mt-5 mb-4 text-center"><?php echo htmlspecialchars($name); ?> Details</h1>

    <div class="row mx-4">
        <div class="col-md-6">
            <!-- Display the tour package image if available -->
            <?php if (!empty($image) && file_exists($image)): ?>
                <img src="<?php echo htmlspecialchars($image); ?>" class="img-fluid mb-3" alt="<?php echo htmlspecialchars($name); ?> Image" style="max-width: 100%; height: auto;">
            <?php else: ?>
                <p>No image available.</p>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <h3>Details</h3>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($description); ?></p>
            <p><strong>Price:</strong> $<?php echo htmlspecialchars($price); ?></p>
            <p><strong>City:</strong> <?php echo htmlspecialchars($city); ?></p>
            <p><strong>Hotel:</strong> <?php echo htmlspecialchars($hotel); ?></p>
            <p><strong>Days:</strong> <?php echo htmlspecialchars($dayCount); ?></p>
        </div>
    </div>

    <div class="row mt-4 mx-4">
        <div class="col text-center">
            <a href="touredit.php?pack_id=<?php echo $pack_id; ?>" class="btn btn-sm btn-info mx-2" title="Edit"><i class="fas fa-pencil-alt"></i> Edit</a>
            
            <!-- <a href="tourdelete.php?pack_id=<?php echo $pack_id; ?>" class="btn btn-sm btn-info mx-2" title="Edit"><i class="fas fa-pencil-alt"></i> Delete</a> -->
            
        </div>
    </div>
</div>

<?php
require "footer.php";
?>
