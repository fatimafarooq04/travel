<?php
require "header.php";
require "connection.php";

// Fetch cities data
$cities_query = "SELECT CityID, CityName FROM `city`";
$cities_result = mysqli_query($conn, $cities_query);
$cities = mysqli_fetch_all($cities_result, MYSQLI_ASSOC);

// Check if destination ID is provided via GET
if (isset($_GET['updid'])) {
    $DestinationID = $_GET['updid'];
    $updqry = "SELECT * FROM `destination` WHERE DestinationID = $DestinationID";
    $result = mysqli_query($conn, $updqry);
} else {
    echo "No destination ID provided.";
    exit;
}
?>

<div class="container">
    <h1 class="mt-5 text-center">Edit Destination</h1>
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
                <textarea class="form-control" id="description" name="Description"
                    rows="4"><?php echo $row['Description']; ?></textarea>
            </div>
           
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="state">State:</label>
                        <input type="text" class="form-control" id="state" name="State"
                            value="<?php echo $row['State']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="city">City:</label>
                        <select class="form-control" id="city" name="City">
                            <option value="">Select a city</option>
                            <?php foreach ($cities as $city): ?>
                                <option value="<?php echo $city['CityID']; ?>" <?php echo ($city['CityID'] == $row['CityID']) ? 'selected' : ''; ?>>
                                    <?php echo $city['CityName']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bestTimeToVisit">Best Time to Visit:</label>
                        <input type="text" class="form-control" id="bestTimeToVisit" name="BestTimeToVisit"
                            value="<?php echo $row['BestTimeToVisit']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image1">Image 1:</label>
                        <input type="file" class="form-control" id="image1" name="image1" accept=".jpg,.jpeg,.png">
                        <label><input type="radio" name="card_image" value="image1" <?php echo ($row['CardImage'] === $row['Image1']) ? 'checked' : ''; ?> checked> Set as Card Image</label>
                        <?php if (!empty($row['Image1'])): ?>
                            <img src="<?php echo $row['Image1']; ?>" alt="Current Image"
                                style="max-width: 200px; max-height: 200px; margin-left: 50px;">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image2">Image 2:</label>
                        <input type="file" class="form-control" id="image2" name="image2" accept=".jpg,.jpeg,.png">
                        <label><input type="radio" name="card_image" value="image2" <?php echo ($row['CardImage'] === $row['Image2']) ? 'checked' : ''; ?>> Set as Card Image</label>
                        <?php if (!empty($row['Image2'])): ?>
                            <img src="<?php echo $row['Image2']; ?>" alt="Current Image"
                                style="max-width: 200px; max-height: 200px; margin-left: 50px;">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image3">Image 3:</label>
                        <input type="file" class="form-control" id="image3" name="image3" accept=".jpg,.jpeg,.png">
                        <label><input type="radio" name="card_image" value="image3" <?php echo ($row['CardImage'] === $row['Image3']) ? 'checked' : ''; ?>> Set as Card Image</label>
                        <?php if (!empty($row['Image3'])): ?>
                            <img src="<?php echo $row['Image3']; ?>" alt="Current Image"
                                style="max-width: 200px; max-height: 200px; margin-left: 50px;">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary mx-4 my-5" name="upd">Update Destination</button>
            </div>
        <?php } else {
            echo "No destination found with ID: " . $DestinationID;
        } ?>
    </form>
</div>

<?php
if (isset($_POST['upd'])) {
    $Name = $_POST['Name'];
    $Description = $_POST['Description'];
    $State = $_POST['State'];
    $City = $_POST['City'];
    $BestTimeToVisit = $_POST['BestTimeToVisit'];

    // Handle image uploads and setting card image
    $card_image = $_POST['card_image']; // Radio button value indicating which image to set as card image

    // Function to handle image upload and update
    function handleImageUpload($fieldName, $currentImagePath, $destinationID)
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
                        window.location.href ='destinationshow.php';
                    </script>";
                    exit; // Stop further execution
                }
            }
        }
        // If no new file is uploaded, retain the existing image path
        return $currentImagePath;
    }

    // Update image paths based on user selection
    $Image1 = handleImageUpload('image1', $row['Image1'], $DestinationID);
    $Image2 = handleImageUpload('image2', $row['Image2'], $DestinationID);
    $Image3 = handleImageUpload('image3', $row['Image3'], $DestinationID);

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
    $upd_qry = "UPDATE `destination` SET 
                `Name`='$Name', 
                `Description`='$Description', 
                `State`='$State', 
                `CityID`='$City', 
                `BestTimeToVisit`='$BestTimeToVisit', 
                `Image1`='$Image1', 
                `Image2`='$Image2', 
                `Image3`='$Image3', 
                `CardImage`='$CardImageUrl' 
                WHERE DestinationID=$DestinationID";

    $result = mysqli_query($conn, $upd_qry);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "<script>
            alert('Update Successful');
            window.location.href ='destinationshow.php';
            </script>";
    }
}
require "footer.php";
?>