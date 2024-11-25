<?php
require "header.php";
require "connection.php";

// Fetch room types from the database
$room_types_query = "SELECT RoomTypeID, TypeName FROM room_types";
$room_types_result = mysqli_query($conn, $room_types_query);
?>

<div class="container">
    <h1 class="mt-5 text-center">Add Room Table</h1>
    <form action="#" method="POST" class="mt-4 mx-5" enctype="multipart/form-data">
        <div class="form-group">
            <label for="RoomTypeID">Room Type:</label>
            <select class="form-control" id="RoomTypeID" name="RoomTypeID" required>
                <option value="" disabled selected>Select a room type</option>
                <?php while ($row = mysqli_fetch_assoc($room_types_result)) { ?>
                    <option value="<?php echo $row['RoomTypeID']; ?>"><?php echo $row['TypeName']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="room_size">Room Size:</label>
            <input type="text" class="form-control" id="room_size" name="room_size" required>
        </div>
        <div class="form-group">
            <label for="guest_capacity">Guest Capacity:</label>
            <input type="number" class="form-control" id="guest_capacity" name="guest_capacity" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="policy">Policy:</label>
            <textarea class="form-control" id="policy" name="policy" rows="4" required></textarea>
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
            // Fetch facilities from the database
            $facilities_query = "SELECT * FROM hr_facilities";
            $facilities_result = mysqli_query($conn, $facilities_query);

            while ($facility = mysqli_fetch_assoc($facilities_result)) { ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="facility_<?php echo $facility['facility_id']; ?>" name="Facilities[]" value="<?php echo $facility['facility_id']; ?>">
                    <label class="form-check-label" for="facility_<?php echo $facility['facility_id']; ?>"><?php echo $facility['facility_name']; ?></label>
                </div>
            <?php } ?>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mx-4" name="submit">Add Room</button>
            <button type="reset" class="btn btn-secondary mx-4">Reset</button>
        </div>
    </form>
</div>

<?php
if (isset($_POST['submit'])) {
    $RoomTypeID = $_POST['RoomTypeID'];
    $description = $_POST['description'];
    $room_size = $_POST['room_size'];
    $guest_capacity = $_POST['guest_capacity'];
    $price = $_POST['price'];
    $policy = $_POST['policy'];
    $facilities = isset($_POST['Facilities']) ? $_POST['Facilities'] : [];

    // Handle image uploads
    $ImageUrl1 = handleImageUpload('ImageUrl1');
    $ImageUrl2 = handleImageUpload('ImageUrl2');
    $ImageUrl3 = handleImageUpload('ImageUrl3');

    // Insert room details into hotel_rooms table
    $insert_query = "INSERT INTO hotel_rooms (room_type, description, room_size, guest_capacity, price, policy, img1, img2, img3) 
                     VALUES ('$RoomTypeID','$description', '$room_size', '$guest_capacity', '$price', '$policy', '$ImageUrl1', '$ImageUrl2', '$ImageUrl3')";
    $res = mysqli_query($conn, $insert_query);

    if ($res) {
        $room_id = mysqli_insert_id($conn); // Get the ID of the newly inserted room

        // Insert facilities into hotel_room_facilities table
        foreach ($facilities as $facility_id) {
            $facility_insert_query = "INSERT INTO hotel_room_facilities (room_id, facility_id) VALUES ('$room_id', '$facility_id')";
            mysqli_query($conn, $facility_insert_query);
        }

        // Redirect or display success message
        echo "<script>
            alert('Room Added Successfully');
            window.location.href='tableshow.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function handleImageUpload($fieldName)
{
    global $conn;

    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] != UPLOAD_ERR_OK) {
        return ''; // No file uploaded or error occurred
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

require "footer.php";
?>
