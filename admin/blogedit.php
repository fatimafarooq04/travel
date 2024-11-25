<?php
require "header.php";
require "connection.php";

// Fetch hotel data
$blog_id = $_GET['updid'];
$updqry = "SELECT * FROM `blog` WHERE blog_id = $blog_id";
$result = mysqli_query($conn, $updqry);

if (!$result) {
    echo "No Package found with ID: " . $blog_id;
    exit;
}
?>

<div class="container">
    <h1 class="mt-5">Edit Blog</h1>
    <form action="" method="POST" class="mt-4 mx-5" enctype="multipart/form-data">
        <?php
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        ?>
            <div class="form-group">
                <label for="person">Date:</label>
                <input type="text" class="form-control" id="person" name="blog_date" value="<?php echo $row['blog_date']; ?>">
            </div>
            <div class="form-group">
                <label for="text">Month:</label>
                <input type="text" class="form-control" id="text" name="blog_month" value="<?php echo $row['blog_month']; ?>">
            </div>

            <div class="form-group">
                <label for="price">Heading:</label>
                <input type="text" class="form-control" id="price" name="blog_head" value="<?php echo $row['blog_head']; ?>">
            </div>
            <div class="form-group">
                <label for="duration">Text:</label>
                <input type="text" class="form-control" id="duration" name="blog_text" value="<?php echo $row['blog_text']; ?>">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="blog_desc" rows="4"><?php echo $row['blog_desc']; ?></textarea>
            </div>
           
          
        
        <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image1">Image 1:</label>
                        <input type="file" class="form-control" id="image1" name="img1" accept=".jpg,.jpeg,.png">
                        <label><input type="radio" name="blog_img" value="img1" <?php echo ($row['blog_img'] === $row['img1']) ? 'checked' : ''; ?>> Set as Card Image</label>
                        <?php if (!empty($row['img1'])): ?>
                            <img src="<?php echo $row['img1']; ?>" alt="Current Image" style="max-width: 200px; max-height: 200px; margin-left: 50px;">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image2">Image 2:</label>
                        <input type="file" class="form-control" id="image2" name="img2" accept=".jpg,.jpeg,.png">
                        <label><input type="radio" name="blog_img" value="img2" <?php echo ($row['blog_img'] === $row['img2']) ? 'checked' : ''; ?>> Set as Card Image</label>
                        <?php if (!empty($row['img2'])): ?>
                            <img src="<?php echo $row['img2']; ?>" alt="Current Image" style="max-width: 200px; max-height: 200px; margin-left: 50px;">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image3">Image 3:</label>
                        <input type="file" class="form-control" id="image3" name="img3" accept=".jpg,.jpeg,.png">
                        <label><input type="radio" name="blog_img" value="img3" <?php echo ($row['blog_img'] === $row['img3']) ? 'checked' : ''; ?>> Set as Card Image</label>
                        <?php if (!empty($row['img3'])): ?>
                            <img src="<?php echo $row['img3']; ?>" alt="Current Image" style="max-width: 200px; max-height: 200px; margin-left: 50px;">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary mx-4 my-5" name="upd">Update Blog</button>
                <button type="reset" class="btn btn-secondary ml-2 mx-4">Reset</button>
            </div>
        <?php
        } else {
            echo "No Package found with ID: " . $blog_id;
        }
        ?>
    </form>
</div>

<?php
if (isset($_POST['upd'])) {
    $blog_date = $_POST['blog_date'];
    $blog_month = $_POST['blog_month'];
    $blog_head = $_POST['blog_head'];
    $blog_text = $_POST['blog_text'];
    $blog_desc = $_POST['blog_desc'];
    
    // Handle image uploads and setting card image
    $blog_img = $_POST['blog_img']; // Radio button value indicating which image to set as card image

    // Function to handle image upload and update
    function handleImageUpload($fieldName, $currentImagePath, $blog_id)
    {
        global $conn;

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
                    move_uploaded_file($actualPath, $uploadPath);
                    return $uploadPath; // Return the new image path
                } else {
                    echo "<script>
                        alert('Sorry, only JPG, JPEG, and PNG files are allowed.');
                        window.location.href ='blogshow.php';
                    </script>";
                    exit; // Stop further execution
                }
            }
        }
        // If no new file is uploaded, retain the existing image path
        return $currentImagePath;
    }

    // Update image paths based on user selection
    $img1 = handleImageUpload('img1', $row['img1'], $blog_id);
    $img2 = handleImageUpload('img2', $row['img2'], $blog_id);
    $img3 = handleImageUpload('img3', $row['img3'], $blog_id);

    // Determine which image to set as the card image
    $CardImageUrl = '';
    switch ($blog_img) {
        case 'img1':
            $CardImageUrl = $img1;
            break;
        case 'img2':
            $CardImageUrl = $img2;
            break;
        case 'img3':
            $CardImageUrl = $img3;
            break;
        default:
            // Set a default behavior if no selection is made
            break;
    }

    // Update query
    $upd_qry = "UPDATE `blog` SET 
                `blog_date`='$blog_date', 
                `blog_month`='$blog_month',
                `blog_head`='$blog_head', 
                `blog_text`='$blog_text', 
                `blog_desc`='$blog_desc',
                `img1`='$img1', 
                `img2`='$img2', 
                `img3`='$img3', 
                `blog_img`='$CardImageUrl' 
                WHERE blog_id=$blog_id";

    $result = mysqli_query($conn, $upd_qry);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "<script>
            alert('Update Successful');
            window.location.href ='blogshow.php';
            </script>";
    }
}
?>
<?php
require "footer.php";
?>
