<?php
require "header.php";
require "connection.php";

// Fetch hotel data
$hotels_query = "SELECT HotelID, Name FROM `hotel`";
$hotels_result = mysqli_query($conn, $hotels_query);
$hotels = mysqli_fetch_all($hotels_result, MYSQLI_ASSOC);

// Fetch room types data
$room_types_query = "SELECT RoomTypeID, TypeName FROM `room_types`";
$room_types_result = mysqli_query($conn, $room_types_query);
$room_types = mysqli_fetch_all($room_types_result, MYSQLI_ASSOC);

// Check if room ID is provided via GET
if (isset($_GET['updid'])) {
    $RoomID = $_GET['updid'];
    $updqry = "SELECT * FROM `room` WHERE RoomID = $RoomID";
    $result = mysqli_query($conn, $updqry);
} else {
    echo "No room ID provided.";
    exit;
}
?>

<div class="container">
    <h1 class="mt-5 text-center">Edit Hotel</h1>
    <form action="" method="POST" class="mt-4 mx-5" enctype="multipart/form-data">
        <?php
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            ?>
            <div class="form-group">
                <label for="hotel">Hotel:</label>
                <select class="form-control" id="hotel" name="HotelID">
                    <option value="">Select a hotel</option>
                    <?php foreach ($hotels as $hotel): ?>
                        <option value="<?php echo $hotel['HotelID']; ?>" <?php echo ($hotel['HotelID'] == $row['HotelID']) ? 'selected' : ''; ?>>
                            <?php echo $hotel['Name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="room_type">Room Type:</label>
                <select class="form-control" id="room_type" name="RoomTypeID">
                    <option value="">Select a room type</option>
                    <?php foreach ($room_types as $room_type): ?>
                        <option value="<?php echo $room_type['RoomTypeID']; ?>" <?php echo ($room_type['RoomTypeID'] == $row['RoomTypeID']) ? 'selected' : ''; ?>>
                            <?php echo $room_type['TypeName']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" class="form-control" id="price" name="Price" value="<?php echo htmlspecialchars($row['Price']); ?>">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="Description"
                    rows="4"><?php echo htmlspecialchars($row['Description']); ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image1">Image 1:</label>
                        <input type="file" class="form-control" id="image1" name="image1" accept=".jpg,.jpeg,.png">
                        <label><input type="radio" name="card_image" value="image1" <?php echo ($row['CardImage'] === $row['Image1']) ? 'checked' : ''; ?>> Set as Card Image</label>
                        <?php if (!empty($row['Image1'])): ?>
                            <img src="<?php echo htmlspecialchars($row['Image1']); ?>" alt="Current Image"
                                style="max-width: 200px; max-height: 200px; margin-left: 50px;">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image2">Image 2:</label>
                        <input type="file" class="form-control" id="image2" name="image2" accept=".jpg,.jpeg,.png">
                        <label><input type="radio" name="card_image" value="image2" <?php echo ($row['CardImage'] === $row['Image2']) ? 'checked' : ''; ?>> Set as Card Image</label>
                        <?php if (!empty($row['Image2'])): ?>
                            <img src="<?php echo htmlspecialchars($row['Image2']); ?>" alt="Current Image"
                                style="max-width: 200px; max-height: 200px; margin-left: 50px;">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image3">Image 3:</label>
                        <input type="file" class="form-control" id="image3" name="image3" accept=".jpg,.jpeg,.png">
                        <label><input type="radio" name="card_image" value="image3" <?php echo ($row['CardImage'] === $row['Image3']) ? 'checked' : ''; ?>> Set as Card Image</label>
                        <?php if (!empty($row['Image3'])): ?>
                            <img src="<?php echo htmlspecialchars($row['Image3']); ?>" alt="Current Image"
                                style="max-width: 200px; max-height: 200px; margin-left: 50px;">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary mx-4 my-5" name="upd">Update Room</button>
            </div>
        <?php } else {
            echo "No room found with ID: " . htmlspecialchars($RoomID);
        } ?>
    </form>
</div>

<?php
if (isset($_POST['upd'])) {
    $HotelID = $_POST['HotelID'];
    $RoomTypeID = $_POST['RoomTypeID'];
    $Price = $_POST['Price'];
    $Description = $_POST['Description'];

    // Escape special characters
    $HotelID = mysqli_real_escape_string($conn, $HotelID);
    $RoomTypeID = mysqli_real_escape_string($conn, $RoomTypeID);
    $Price = mysqli_real_escape_string($conn, $Price);
    $Description = mysqli_real_escape_string($conn, $Description);

    // Handle image uploads and setting card image
    $card_image = $_POST['card_image']; // Radio button value indicating which image to set as card image

    // Function to handle image upload and update
    function handleImageUpload($fieldName, $currentImagePath, $roomID)
    {
        global $conn;

        if ($_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES[$fieldName];
            $imageName = $image['name'];
            $actualPath = $image['tmp_name'];
            $uploadPath = "images/" . $imageName;

            // Check if a new image file is uploaded
            if (!empty($imageName)) {
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
                $fileExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

                if (in_array($fileExtension, $allowedExtensions)) {
                    move_uploaded_file($actualPath, $uploadPath);
                    return $uploadPath; // Return the new image path
                } else {
                    echo "<script>
                        alert('Sorry, only JPG, JPEG, and PNG files are allowed.');
                        window.location.href ='roomshow.php';
                    </script>";
                    exit; // Stop further execution
                }
            }
        }
        // If no new file is uploaded, retain the existing image path
        return $currentImagePath;
    }

    // Update image paths based on user selection
    $Image1 = handleImageUpload('image1', $row['Image1'], $RoomID);
    $Image2 = handleImageUpload('image2', $row['Image2'], $RoomID);
    $Image3 = handleImageUpload('image3', $row['Image3'], $RoomID);

    // Determine which image to set as the card image
    $CardImageUrl = '';
    switch ($card_image) {
        case 'image1':
            $CardImageUrl = $Image1;
            break;
        case 'image2':
            $CardImageUrl = $Image2;
            break;
        case 'image3':
            $CardImageUrl = $Image3;
            break;
        default:
            // Set a default behavior if no selection is made
            break;
    }

    // Update query
    $upd_qry = "UPDATE `room` SET 
        HotelID='$HotelID',
        RoomTypeID='$RoomTypeID',
        Price='$Price',
        Description='$Description',
        Image1='$Image1',
        Image2='$Image2',
        Image3='$Image3',
        CardImage='$CardImageUrl'
        WHERE RoomID=$RoomID";
    
    if (mysqli_query($conn, $upd_qry)) {
        echo "<script>
            alert('Record updated successfully');
            window.location.href = 'roomshow.php';
        </script>";
    } else {
        echo "<script>
            alert('Error updating record: " . mysqli_error($conn) . "');
            window.location.href = 'roomshow.php';
        </script>";
    }
}
?>
