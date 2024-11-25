<?php
require "header.php";
require "connection.php";

// Fetch room details based on the room ID
if (isset($_GET['id'])) {
    $room_id = $_GET['id'];
    
    $query = "SELECT * FROM hotel_rooms WHERE room_id = '$room_id'";
    $result = mysqli_query($conn, $query);
    $room = mysqli_fetch_assoc($result);
    
    if (!$room) {
        echo "Room not found!";
        exit;
    }
} else {
    echo "Invalid Room ID!";
    exit;
}

// Fetch room types and facilities for the dropdown and checkboxes
$room_types_query = "SELECT RoomTypeID, TypeName FROM room_types";
$room_types_result = mysqli_query($conn, $room_types_query);

$facilities_query = "SELECT * FROM hr_facilities";
$facilities_result = mysqli_query($conn, $facilities_query);

if (isset($_POST['submit'])) {
    $RoomTypeID = $_POST['RoomTypeID'];
    $description = $_POST['description'];
    $room_size = $_POST['room_size'];
    $guest_capacity = $_POST['guest_capacity'];
    $price = $_POST['price'];
    $policy = $_POST['policy'];
    $facilities = isset($_POST['Facilities']) ? $_POST['Facilities'] : [];

    // Handle image uploads
    $ImageUrl1 = handleImageUpload('ImageUrl1', $room['img1']);
    $ImageUrl2 = handleImageUpload('ImageUrl2', $room['img2']);
    $ImageUrl3 = handleImageUpload('ImageUrl3', $room['img3']);

    // Update room details
    $update_query = "UPDATE hotel_rooms 
                     SET room_type = '$RoomTypeID', description = '$description', room_size = '$room_size', guest_capacity = '$guest_capacity', price = '$price', policy = '$policy', 
                         img1 = '$ImageUrl1', img2 = '$ImageUrl2', img3 = '$ImageUrl3'
                     WHERE room_id = '$room_id'";
    $res = mysqli_query($conn, $update_query);

    if ($res) {
        // Remove existing facilities and insert updated ones
        $delete_facilities_query = "DELETE FROM hotel_room_facilities WHERE room_id = '$room_id'";
        mysqli_query($conn, $delete_facilities_query);

        foreach ($facilities as $facility_id) {
            $facility_insert_query = "INSERT INTO hotel_room_facilities (room_id, facility_id) VALUES ('$room_id', '$facility_id')";
            mysqli_query($conn, $facility_insert_query);
        }

        echo "<script>
            alert('Room Updated Successfully');
            window.location.href='tableshow.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function handleImageUpload($fieldName, $currentImagePath)
{
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] != UPLOAD_ERR_OK) {
        return $currentImagePath; // Return current image path if no new file is uploaded
    }

    $ImageUrl = $_FILES[$fieldName];
    $imagename = $ImageUrl['name'];
    $actualpath = $ImageUrl['tmp_name'];
    $mypath = "images/" . $imagename;

    // Check if the file extension is allowed
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $fileExtension = strtolower(pathinfo($imagename, PATHINFO_EXTENSION));

    if (in_array($fileExtension, $allowedExtensions)) {
        move_uploaded_file($actualpath, $mypath);
        return $mypath; // Return the uploaded file path
    } else {
        echo "<script>
            alert('Sorry, only JPG, JPEG, and PNG files are allowed for $fieldName');
            window.location.href='hotels.php';
        </script>";
        exit; // Stop further execution
    }
}
?>

<div class="container">
    <h1 class="mt-5 text-center">Update Room</h1>
    <form id="updateRoomForm" action="#" method="POST" class="mt-4 mx-5" enctype="multipart/form-data">
        <div class="form-group">
            <label for="RoomTypeID">Room Type:</label>
            <select class="form-control" id="RoomTypeID" name="RoomTypeID" required>
                <option value="" disabled>Select a room type</option>
                <?php while ($row = mysqli_fetch_assoc($room_types_result)) { ?>
                    <option value="<?php echo $row['RoomTypeID']; ?>" <?php if ($room['room_type'] == $row['RoomTypeID']) echo 'selected'; ?>>
                        <?php echo $row['TypeName']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($room['description']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="room_size">Room Size:</label>
            <input type="text" class="form-control" id="room_size" name="room_size" value="<?php echo htmlspecialchars($room['room_size']); ?>" required>
        </div>
        <div class="form-group">
            <label for="guest_capacity">Guest Capacity:</label>
            <input type="number" class="form-control" id="guest_capacity" name="guest_capacity" value="<?php echo htmlspecialchars($room['guest_capacity']); ?>" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($room['price']); ?>" required>
        </div>
        <div class="form-group">
            <label for="policy">Policy:</label>
            <textarea class="form-control" id="policy" name="policy" rows="4" required><?php echo htmlspecialchars($room['policy']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="ImageUrl1">Image 1:</label>
            <input type="file" class="form-control-file" id="ImageUrl1" name="ImageUrl1" accept=".jpg, .jpeg, .png">
        </div>
        <div class="form-group">
            <label for="ImageUrl2">Image 2:</label>
            <input type="file" class="form-control-file" id="ImageUrl2" name="ImageUrl2" accept=".jpg, .jpeg, .png">
        </div>
        <div class="form-group">
            <label for="ImageUrl3">Image 3:</label>
            <input type="file" class="form-control-file" id="ImageUrl3" name="ImageUrl3" accept=".jpg, .jpeg, .png">
        </div>
        <div class="form-group">
            <label for="Facilities">Facilities:</label><br>
            <?php
            while ($facility = mysqli_fetch_assoc($facilities_result)) { ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="facility_<?php echo $facility['facility_id']; ?>" name="Facilities[]" value="<?php echo $facility['facility_id']; ?>" 
                    <?php
                        // Check if facility is already assigned to the room
                        $check_facility_query = "SELECT * FROM hotel_room_facilities WHERE room_id = '$room_id' AND facility_id = '{$facility['facility_id']}'";
                        $check_facility_result = mysqli_query($conn, $check_facility_query);
                        if (mysqli_num_rows($check_facility_result) > 0) echo 'checked';
                    ?>>
                    <label class="form-check-label" for="facility_<?php echo $facility['facility_id']; ?>"><?php echo $facility['facility_name']; ?></label>
                </div>
            <?php } ?>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mx-4" name="submit">Update Room</button>
            <a href="tableshow.php" class="btn btn-secondary mx-4">Cancel</a>
        </div>
    </form>
</div>

<script>
document.getElementById('updateRoomForm').addEventListener('submit', function(event) {
    var checkboxes = document.querySelectorAll('input[name="Facilities[]"]:checked');
    if (checkboxes.length === 0) {
        alert('Please select at least one facility.');
        event.preventDefault();
    }
});
</script>

<?php require "footer.php"; ?>
