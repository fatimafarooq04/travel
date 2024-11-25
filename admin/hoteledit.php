<?php
require "header.php";
require "connection.php";

// Fetch hotel data
$hotelID = $_GET['updid'];
$updqry = "SELECT * FROM `hotel` WHERE HotelID = $hotelID";
$result = mysqli_query($conn, $updqry);

if (!$result) {
    echo "No hotel found with ID: " . $hotelID;
    exit;
}

// Fetch all facilities from the database
$facilities_query = "SELECT * FROM facility";
$facilities_result = mysqli_query($conn, $facilities_query);

// Fetch already selected facilities for the hotel
$selected_facilities_query = "SELECT FacilityID FROM hotel_facility WHERE HotelID = $hotelID";
$selected_facilities_result = mysqli_query($conn, $selected_facilities_query);
$selected_facilities = [];
while ($facility = mysqli_fetch_assoc($selected_facilities_result)) {
    $selected_facilities[] = $facility['FacilityID'];
}
?>

<div class="container">
    <h1 class="mt-5">Edit Hotel</h1>
    <form action="" method="POST" class="mt-4 mx-5" enctype="multipart/form-data">
        <?php
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        ?>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="Name" value="<?php echo $row['Name']; ?>">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="Description" rows="4"><?php echo $row['Description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="Address" value="<?php echo $row['Address']; ?>">
            </div>
            <div class="form-group">
                <label for="contactInfo">Contact Info:</label>
                <input type="text" class="form-control" id="contactInfo" name="ContactInfo" value="<?php echo $row['ContactInfo']; ?>">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image1">Image 1:</label>
                        <input type="file" class="form-control" id="image1" name="image1" accept=".jpg,.jpeg,.png">
                        <label><input type="radio" name="card_image" value="image1" <?php echo ($row['CardImage'] === $row['Image1']) ? 'checked' : ''; ?>> Set as Card Image</label>
                        <?php if (!empty($row['Image1'])): ?>
                            <img src="<?php echo $row['Image1']; ?>" alt="Current Image" style="max-width: 200px; max-height: 200px; margin-left: 50px;">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image2">Image 2:</label>
                        <input type="file" class="form-control" id="image2" name="image2" accept=".jpg,.jpeg,.png">
                        <label><input type="radio" name="card_image" value="image2" <?php echo ($row['CardImage'] === $row['Image2']) ? 'checked' : ''; ?>> Set as Card Image</label>
                        <?php if (!empty($row['Image2'])): ?>
                            <img src="<?php echo $row['Image2']; ?>" alt="Current Image" style="max-width: 200px; max-height: 200px; margin-left: 50px;">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image3">Image 3:</label>
                        <input type="file" class="form-control" id="image3" name="image3" accept=".jpg,.jpeg,.png">
                        <label><input type="radio" name="card_image" value="image3" <?php echo ($row['CardImage'] === $row['Image3']) ? 'checked' : ''; ?>> Set as Card Image</label>
                        <?php if (!empty($row['Image3'])): ?>
                            <img src="<?php echo $row['Image3']; ?>" alt="Current Image" style="max-width: 200px; max-height: 200px; margin-left: 50px;">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="Facilities">Facilities:</label><br>
                <?php while ($facility = mysqli_fetch_assoc($facilities_result)) { ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="facility_<?php echo $facility['FacilityID']; ?>" name="Facilities[]" value="<?php echo $facility['FacilityID']; ?>" <?php echo in_array($facility['FacilityID'], $selected_facilities) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="facility_<?php echo $facility['FacilityID']; ?>"><?php echo $facility['FacilityName']; ?></label>
                    </div>
                <?php } ?>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary mx-4 my-5" name="upd">Update Hotel</button>
                <button type="reset" class="btn btn-secondary ml-2 mx-4">Reset</button>
            </div>
        <?php
        } else {
            echo "No hotel found with ID: " . $hotelID;
        }
        ?>
    </form>
</div>

<?php
if (isset($_POST['upd'])) {
    $Name = $_POST['Name'];
    $Description = $_POST['Description'];
    $Address = $_POST['Address'];
    $ContactInfo = $_POST['ContactInfo'];

    // Handle image uploads and setting card image
    $card_image = $_POST['card_image']; // Radio button value indicating which image to set as card image

    // Function to handle image upload and update
    function handleImageUpload($fieldName, $currentImagePath, $hotelID)
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
                        window.location.href ='hotelshow.php';
                    </script>";
                    exit; // Stop further execution
                }
            }
        }
        // If no new file is uploaded, retain the existing image path
        return $currentImagePath;
    }

    // Update image paths based on user selection
    $Image1 = handleImageUpload('image1', $row['Image1'], $hotelID);
    $Image2 = handleImageUpload('image2', $row['Image2'], $hotelID);
    $Image3 = handleImageUpload('image3', $row['Image3'], $hotelID);

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
    $upd_qry = "UPDATE `hotel` SET 
                `Name`='$Name', 
                `Description`='$Description', 
                `Address`='$Address', 
                `ContactInfo`='$ContactInfo', 
                `Image1`='$Image1', 
                `Image2`='$Image2', 
                `Image3`='$Image3', 
                `CardImage`='$CardImageUrl' 
                WHERE HotelID=$hotelID";

    $result = mysqli_query($conn, $upd_qry);

    // Update facilities
    // Delete existing facilities for the hotel
    $delete_facilities_qry = "DELETE FROM hotel_facility WHERE HotelID = $hotelID";
    mysqli_query($conn, $delete_facilities_qry);

    // Insert selected facilities into hotel_facility table
    if (!empty($_POST['Facilities'])) {
        foreach ($_POST['Facilities'] as $facilityID) {
            $insert_facility_qry = "INSERT INTO hotel_facility (HotelID, FacilityID) VALUES ($hotelID, $facilityID)";
            mysqli_query($conn, $insert_facility_qry);
        }
    }

    if ($result) {
        echo "<script>
            alert('Hotel Updated Successfully');
            window.location.href ='hotelshow.php';
        </script>";
    } else {
        echo "<script>
            alert('Hotel Not Updated');
            window.location.href ='hotelshow.php';
        </script>";
    }
}
?>
