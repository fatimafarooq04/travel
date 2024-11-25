<?php
require "header.php";
require "connection.php";

// Check if destination ID is provided via GET
if (isset($_GET['updid'])) {
    $about_id = $_GET['updid'];
    $updqry = "SELECT * FROM `about_us` WHERE about_id = $about_id";
    $result = mysqli_query($conn, $updqry);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo "No About Us found with ID: " . $about_id;
        exit;
    }

    $row = mysqli_fetch_assoc($result);
} else {
    echo "No About Us ID provided.";
    exit;
}
?>

<div class="container">
    <h1 class="mt-5">Edit About Us</h1>
    <form action="" method="POST" class="mt-4 mx-5" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Heading:</label>
            <input type="text" class="form-control" id="name" name="about_head" value="<?php echo $row['about_head']; ?>">
        </div>

        <div class="form-group">
            <label for="name">Sub Heading:</label>
            <input type="text" class="form-control" id="name" name="about_subhead" value="<?php echo $row['about_subhead']; ?>">
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="about_text" rows="4"><?php echo $row['about_text']; ?></textarea>
        </div>
      
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image1">Image 1:</label>
                    <input type="file" class="form-control" id="image1" name="about_img" accept=".jpg,.jpeg,.png">
                    <?php if (!empty($row['about_img'])): ?>
                        <img src="<?php echo $row['about_img']; ?>" alt="Current Image" style="max-width: 200px; max-height: 200px; margin-left: 50px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image2">Image 2:</label>
                    <input type="file" class="form-control" id="image2" name="about_img2" accept=".jpg,.jpeg,.png">
                    <?php if (!empty($row['about_img2'])): ?>
                        <img src="<?php echo $row['about_img2']; ?>" alt="Current Image" style="max-width: 200px; max-height: 200px; margin-left: 50px;">
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image3">Image 3:</label>
                    <input type="file" class="form-control" id="image3" name="about_img3" accept=".jpg,.jpeg,.png">
                    <?php if (!empty($row['about_img3'])): ?>
                        <img src="<?php echo $row['about_img3']; ?>" alt="Current Image" style="max-width: 200px; max-height: 200px; margin-left: 50px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mx-4 my-5" name="upd">Update About Us</button>
            <button type="reset" class="btn btn-secondary ml-2 mx-4">Reset</button>
        </div>
    </form>
</div>

<?php
if (isset($_POST['upd'])) {
    $about_head = $_POST['about_head'];
    $about_subhead = $_POST['about_subhead'];
    $about_text = $_POST['about_text'];

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
                        window.location.href ='aboutshow.php';
                    </script>";
                    exit; // Stop further execution
                }
            }
        }
        // If no new file is uploaded, retain the existing image path
        return $currentImagePath;
    }

    // Update image paths based on user selection
    $img1 = handleImageUpload('about_img', $row['about_img']);
    $img2 = handleImageUpload('about_img2', $row['about_img2']);
    $img3 = handleImageUpload('about_img3', $row['about_img3']);

    // Update query
    $upd_qry = "UPDATE `about_us` SET 
                `about_head`='$about_head', 
                `about_subhead`='$about_subhead', 
                `about_text`='$about_text', 
                `about_img`='$img1', 
                `about_img2`='$img2', 
                `about_img3`='$img3' 
                WHERE about_id=$about_id";

    $result = mysqli_query($conn, $upd_qry);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "<script>
            alert('Update Successful');
            window.location.href ='aboutshow.php';
            </script>";
    }
}
require "footer.php";
?>
