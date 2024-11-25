<?php
require "header.php";
require "connection.php";

// Check if destination ID is provided via GET
if (isset($_GET['updid'])) {
    $team_id = $_GET['updid'];
    $updqry = "SELECT * FROM `team_info` WHERE team_id = $team_id";
    $result = mysqli_query($conn, $updqry);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo "No Team Info found with ID: " . $team_id;
        exit;
    }

    $row = mysqli_fetch_assoc($result);
} else {
    echo "No Team Info ID provided.";
    exit;
}
?>

<div class="container">
    <h1 class="mt-5">Edit Team Info</h1>
    <form action="" method="POST" class="mt-4 mx-5" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="team_name" value="<?php echo htmlspecialchars($row['team_name']); ?>">
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="team_desc" rows="4"><?php echo htmlspecialchars($row['team_desc']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="image1">Image Url:</label>
            <input type="file" class="form-control" id="image1" name="team_img" accept=".jpg,.jpeg,.png">
            <?php if (!empty($row['team_img'])): ?>
                <img src="<?php echo htmlspecialchars($row['team_img']); ?>" alt="Current Image" style="max-width: 200px; max-height: 200px; margin-left: 50px;">
            <?php endif; ?>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary mx-4 my-5" name="upd">Update Team Info</button>
            <button type="reset" class="btn btn-secondary ml-2 mx-4">Reset</button>
        </div>
    </form>
</div>

<?php
if (isset($_POST['upd'])) {
    $team_name = $_POST['team_name'];
    $team_desc = $_POST['team_desc'];

    // Function to handle image upload and update
    function handleImageUpload($fieldName, $currentImagePath)
    {
        if ($_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES[$fieldName];
            $imageName = $image['name'];
            $actualPath = $image['tmp_name'];
            $uploadPath = "aboutimage/" . $imageName;

            // Check if a new image file is uploaded
            if (!empty($imageName)) {
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
                $fileExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

                if (in_array($fileExtension, $allowedExtensions)) {
                    if (move_uploaded_file($actualPath, $uploadPath)) {
                        return $uploadPath; // Return the new image path
                    }
                } else {
                    echo "<script>
                        alert('Sorry, only JPG, JPEG, and PNG files are allowed.');
                        window.location.href ='teamshow.php';
                    </script>";
                    exit; // Stop further execution
                }
            }
        }
        // If no new file is uploaded, retain the existing image path
        return $currentImagePath;
    }

    // Handle image upload and update the image path
    $team_img = handleImageUpload('team_img', $row['team_img']);

    // Update query
    $upd_qry = "UPDATE `team_info` SET 
                `team_name`='$team_name', 
                `team_desc`='$team_desc',  
                `team_img`='$team_img' 
                WHERE team_id=$team_id";

    $result = mysqli_query($conn, $upd_qry);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "<script>
            alert('Update Successful');
            window.location.href ='teamshow.php';
            </script>";
    }
}
require "footer.php";
?>
