<?php
require "header.php";
require "connection.php";

// Get the room ID from the URL
$room_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch the details of the selected room
$query = "SELECT hr.*, rt.TypeName FROM `hotel_rooms` hr
          JOIN `room_types` rt ON hr.room_type = rt.RoomTypeID
          WHERE hr.room_id = $room_id";
$result = mysqli_query($conn, $query);
$room = mysqli_fetch_assoc($result);

if (!$room) {
    echo "<p>Room not found.</p>";
    require "footer.php";
    exit;
}
// Fetch facilities associated with the room
$facility_query = "SELECT f.facility_name FROM `hotel_room_facilities` hrf
                   JOIN `hr_facilities` f ON hrf.facility_id = f.facility_id
                   WHERE hrf.room_id = $room_id";
$facility_result = mysqli_query($conn, $facility_query);
$facilities = [];
while ($facility_row = mysqli_fetch_assoc($facility_result)) {
    $facilities[] = $facility_row['facility_name'];
}
?>

<div class="container mt-5">
    <!-- Room Details Heading with extra margin-top -->
    <h1 class="text-center mb-4" style="margin-top: 60px;">Room Details</h1>
    <div class="row">
        <div class="col-md-6">
            <h4>Room Type: <?php echo htmlspecialchars($room['TypeName']); ?></h4>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($room['description']); ?></p>
            <p><strong>Room Size:</strong> <?php echo htmlspecialchars($room['room_size']); ?></p>
            <p><strong>Guest Capacity:</strong> <?php echo htmlspecialchars($room['guest_capacity']); ?></p>
            <p><strong>Price:</strong> $<?php echo htmlspecialchars($room['price']); ?></p>
            <p><strong>Policy:</strong> <?php echo nl2br(htmlspecialchars($room['policy'])); ?></p>
            <p><strong>Facilities:</strong></p>
            <ul>
                <?php foreach ($facilities as $facility): ?>
                    <li><?php echo htmlspecialchars($facility); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-6">
            <!-- Display the room images if available -->
            <div class="d-flex flex-column align-items-start">
                <?php if (!empty($room['img1'])): ?>
                    <div class="mb-3">
                        <img src="<?php echo htmlspecialchars($room['img1']); ?>" alt="Room Image 1" class="img-fluid" style="max-width: 100%; height: auto; max-height: 200px;">
                    </div>
                <?php endif; ?>
                <?php if (!empty($room['img2'])): ?>
                    <div class="mb-3">
                        <img src="<?php echo htmlspecialchars($room['img2']); ?>" alt="Room Image 2" class="img-fluid" style="max-width: 100%; height: auto; max-height: 200px;">
                    </div>
                <?php endif; ?>
                <?php if (!empty($room['img3'])): ?>
                    <div class="mb-3">
                        <img src="<?php echo htmlspecialchars($room['img3']); ?>" alt="Room Image 3" class="img-fluid" style="max-width: 100%; height: auto; max-height: 200px;">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <!-- Back to List Button -->
        <a href="tableshow.php" class="btn btn-primary">Back to List</a>
        
        <!-- Update and Delete Buttons -->
        <a href="tableedit.php?id=<?php echo $room['room_id']; ?>" class="btn btn-warning mx-2">Update</a>
        <a href="tabledelete.php?id=<?php echo $room['room_id']; ?>" class="btn btn-danger mx-2" onclick="return confirm('Are you sure you want to delete this room?');">Delete</a>
    </div>
</div>

<?php
require "footer.php";
?>
