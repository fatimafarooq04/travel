<?php
require "header.php";
require "connection.php";

// Fetch cities from the database
$cities_query = "SELECT CityID, CityName FROM city";
$cities_result = mysqli_query($conn, $cities_query);
if (!$cities_result) {
    die("Error fetching cities: " . mysqli_error($conn));
}

// Fetch facilities from the database
$facilities_query = "SELECT * FROM facility";
$facilities_result = mysqli_query($conn, $facilities_query);
if (!$facilities_result) {
    die("Error fetching facilities: " . mysqli_error($conn));
}

function handleImageUpload($fieldName)
{
    global $conn;

    $ImageUrl = $_FILES[$fieldName];
    if ($ImageUrl['error'] != UPLOAD_ERR_OK) {
        echo "<script>
            alert('Error uploading $fieldName');
            window.location.href='hotels.php';
        </script>";
        exit; // Stop further execution
    }

    $imagename = $ImageUrl['name'];
    $actualpath = $ImageUrl['tmp_name'];
    $mypath = "images/" . $imagename;

    // Check if the file extension is allowed
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $fileExtension = strtolower(pathinfo($imagename, PATHINFO_EXTENSION));

    if (in_array($fileExtension, $allowedExtensions)) {
        if (move_uploaded_file($actualpath, $mypath)) {
            return $mypath; // Return the uploaded file path
        } else {
            echo "<script>
                alert('Error moving $fieldName to target directory');
                window.location.href='hotels.php';
            </script>";
            exit; // Stop further execution
        }
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
    <h1 class="mt-5 text-center">Add Hotels</h1>
    <form action="#" method="POST" class="mt-4 mx-5" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="Name" required>
        </div>
        <div class="form-group">
            <label for="Address">Address:</label>
            <textarea class="form-control" id="address" name="Address" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="ContactInfo">Contact Info:</label>
            <input type="text" class="form-control" id="contactInfo" name="ContactInfo" required>
        </div>
        <div class="form-group">
            <label for="CityID">City:</label>
            <select class="form-control" id="cityID" name="CityID" required>
                <option value="" disabled selected>Select a city</option>
                <?php while ($row = mysqli_fetch_assoc($cities_result)) { ?>
                    <option value="<?php echo $row['CityID']; ?>"><?php echo $row['CityName']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Description">Description:</label>
            <textarea class="form-control" id="description" name="Description" rows="4" required></textarea>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="ImageUrl1">Image 1:</label>
                    <input type="file" class="form-control" id="ImageUrl1" name="ImageUrl1" accept=".jpg,.jpeg,.png" required>
                    <label><input type="radio" name="card_image" value="ImageUrl1" checked> Set as Card Image</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="ImageUrl2">Image 2:</label>
                    <input type="file" class="form-control" id="ImageUrl2" name="ImageUrl2" accept=".jpg,.jpeg,.png" required>
                    <label><input type="radio" name="card_image" value="ImageUrl2"> Set as Card Image</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="ImageUrl3">Image 3:</label>
            <input type="file" class="form-control" id="ImageUrl3" name="ImageUrl3" accept=".jpg,.jpeg,.png" required>
            <label><input type="radio" name="card_image" value="ImageUrl3"> Set as Card Image</label>
        </div>
        <div class="form-group">
            <label for="Facilities">Facilities:</label><br>
            <?php while ($facility = mysqli_fetch_assoc($facilities_result)) { ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="facility_<?php echo $facility['FacilityID']; ?>" name="Facilities[]" value="<?php echo $facility['FacilityID']; ?>">
                    <label class="form-check-label" for="facility_<?php echo $facility['FacilityID']; ?>"><?php echo $facility['FacilityName']; ?></label>
                </div>
            <?php } ?>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mx-4" name="sub">Add Hotel</button>
            <button type="reset" class="btn btn-secondary mx-4">Reset</button>
        </div>
    </form>
</div>

<?php
if (isset($_POST['sub'])) {
    $Name = mysqli_real_escape_string($conn, $_POST['Name']);
    $Address = mysqli_real_escape_string($conn, $_POST['Address']);
    $ContactInfo = mysqli_real_escape_string($conn, $_POST['ContactInfo']);
    $CityID = mysqli_real_escape_string($conn, $_POST['CityID']);
    $Description = mysqli_real_escape_string($conn, $_POST['Description']);

    // Handle image uploads
    $ImageUrl1 = handleImageUpload('ImageUrl1');
    $ImageUrl2 = handleImageUpload('ImageUrl2');
    $ImageUrl3 = handleImageUpload('ImageUrl3');

    // Determine which image to set as the card image
    $CardImage = "";
    switch ($_POST['card_image']) {
        case 'ImageUrl1':
            $CardImage = $ImageUrl1;
            break;
        case 'ImageUrl2':
            $CardImage = $ImageUrl2;
            break;
        case 'ImageUrl3':
            $CardImage = $ImageUrl3;
            break;
        default:
            break;
    }

    // Insert hotel details into hotel table
    $Insert_qry = "INSERT INTO hotel (Name, Description, Address, ContactInfo, CityID, Image1, Image2, Image3, CardImage) 
                   VALUES ('$Name', '$Description', '$Address', '$ContactInfo', '$CityID', '$ImageUrl1', '$ImageUrl2', '$ImageUrl3', '$CardImage')";
    $res = mysqli_query($conn, $Insert_qry);

    if ($res) {
        $hotelID = mysqli_insert_id($conn); // Get the last inserted hotel ID

        // Insert selected facilities into hotel_facility table
        if (!empty($_POST['Facilities'])) {
            foreach ($_POST['Facilities'] as $facilityID) {
                $Insert_hotel_facility_qry = "INSERT INTO hotel_facility (HotelID, FacilityID) VALUES ('$hotelID', '$facilityID')";
                if (mysqli_query($conn, $Insert_hotel_facility_qry)) {
                    echo "Facility $facilityID inserted successfully.<br>";
                } else {
                    echo "Error inserting facility $facilityID: " . mysqli_error($conn) . "<br>";
                }
            }
        } else {
            echo "<script>
                alert('No facilities selected.');
                window.location.href='hotels.php';
            </script>";
        }

        // Redirect or display success message
        echo "<script>
            alert('Hotel Added Successfully');
            window.location.href='hotelshow.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

require "footer.php";
?>
