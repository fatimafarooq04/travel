<?php
require "header.php";
require "connection.php";

// Fetch hotels from the database
$hotels_query = "SELECT HotelID, Name FROM hotel";
$hotels_result = mysqli_query($conn, $hotels_query);

// Fetch room types from the database
$room_types_query = "SELECT RoomTypeID, TypeName FROM room_types";
$room_types_result = mysqli_query($conn, $room_types_query);
?>

<div class="container">
    <h1 class="mt-5 text-center">Add Room</h1>
    <form action="#" method="POST" class="mt-4 mx-5" enctype="multipart/form-data">
        <div class="form-group">
            <label for="HotelID">Hotel:</label>
            <select class="form-control" id="HotelID" name="HotelID" required>
                <option value="" disabled selected>Select a hotel</option>
                <?php while ($row = mysqli_fetch_assoc($hotels_result)) { ?>
                    <option value="<?php echo htmlspecialchars($row['HotelID']); ?>">
                        <?php echo htmlspecialchars($row['Name']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="RoomTypeID">Room Type:</label>
            <select class="form-control" id="RoomTypeID" name="RoomTypeID" required>
                <option value="" disabled selected>Select a room type</option>
                <?php while ($row = mysqli_fetch_assoc($room_types_result)) { ?>
                    <option value="<?php echo htmlspecialchars($row['RoomTypeID']); ?>">
                        <?php echo htmlspecialchars($row['TypeName']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Price">Price:</label>
            <input type="number" class="form-control" id="Price" name="Price" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="Description">Description:</label>
            <textarea class="form-control" id="Description" name="Description" rows="4" required></textarea>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Image1">Image 1:</label>
                    <input type="file" class="form-control" id="Image1" name="Image1" accept=".jpg,.jpeg,.png" required>
                    <label><input type="radio" name="card_image" value="Image1" checked> Set as Card Image</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Image2">Image 2:</label>
                    <input type="file" class="form-control" id="Image2" name="Image2" accept=".jpg,.jpeg,.png" required>
                    <label><input type="radio" name="card_image" value="Image2"> Set as Card Image</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Image3">Image 3:</label>
                    <input type="file" class="form-control" id="Image3" name="Image3" accept=".jpg,.jpeg,.png" required>
                    <label><input type="radio" name="card_image" value="Image3"> Set as Card Image</label>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mx-4" name="submit">Add Room</button>
            <button type="reset" class="btn btn-secondary mx-4">Reset</button>
        </div>
    </form>
</div>

<?php
if (isset($_POST['submit'])) {
    $HotelID = $_POST['HotelID'];
    $RoomTypeID = $_POST['RoomTypeID'];
    $Price = $_POST['Price'];
    $Description = $_POST['Description'];

    // Handle image uploads
    $Image1 = handleImageUpload('Image1');
    $Image2 = handleImageUpload('Image2');
    $Image3 = handleImageUpload('Image3');

    // Determine which image to set as the card image
    $CardImage = "";
    switch ($_POST['card_image']) {
        case 'Image1':
            $CardImage = $Image1;
            break;
        case 'Image2':
            $CardImage = $Image2;
            break;
        case 'Image3':
            $CardImage = $Image3;
            break;
        default:
            // Handle default case if needed
            break;
    }

    // Prepared statement to insert room details into room table
    $stmt = $conn->prepare("INSERT INTO room (HotelID, RoomTypeID, Price, Description, Image1, Image2, Image3, CardImage) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisssss", $HotelID, $RoomTypeID, $Price, $Description, $Image1, $Image2, $Image3, $CardImage);

    if ($stmt->execute()) {
        // Redirect or display success message
        echo "<script>
            alert('Room Added Successfully');
            window.location.href='roomshow.php';
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

function handleImageUpload($fieldName)
{
    global $conn;

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
            window.location.href='rooms.php';
        </script>";
        exit; // Stop further execution
    }
}

require "footer.php";
?>
