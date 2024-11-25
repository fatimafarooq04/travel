<?php
require "header.php";
require "connection.php";

// Fetch cities from the database

?>

<div class="container">
    <h1 class="mt-5 text-center">Add Blog</h1>
    <form action="#" method="POST" class="mt-4 mx-5" enctype="multipart/form-data">
      
    <div class="form-group">
            <label for="blog_date">Date:</label>
            <input type="text" class="form-control" id="blog_date" name="blog_date" required>
        </div>

        <div class="form-group">
            <label for="blog_month">Month:</label>
            <input type="text" class="form-control" id="blog_month" name="blog_month" required>
        </div>

        <div class="form-group">
            <label for="blog_head">Heading:</label>
            <input type="text" class="form-control" id="blog_head" name="blog_head" required>
        </div>

        <div class="form-group">
            <label for="blog_desc">Description:</label>
            <textarea class="form-control" id="blog_desc" name="blog_desc" rows="4" required></textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="blog_text">Text:</label>
                    <input type="text" class="form-control" id="blog_text" name="blog_text" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="img1">Image 1:</label>
                    <input type="file" class="form-control" id="img1" name="img1" accept=".jpg,.jpeg,.png" required>
                    <label><input type="radio" name="blog_img" value="img1" checked> Set as Card Image</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="img2">Image 2:</label>
                    <input type="file" class="form-control" id="img2" name="img2" accept=".jpg,.jpeg,.png" required>
                    <label><input type="radio" name="blog_img" value="img2"> Set as Card Image</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="img3">Image 3:</label>
                    <input type="file" class="form-control" id="img3" name="img3" accept=".jpg,.jpeg,.png" required>
                    <label><input type="radio" name="blog_img" value="img3"> Set as Card Image</label>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary mx-4" name="sub">Add Blog</button>
            <button type="reset" class="btn btn-secondary mx-4">Reset</button>
        </div>
    </form>
</div>

<?php
if (isset($_POST['sub'])) {

    $blog_date = $_POST['blog_date'];
    $blog_month = $_POST['blog_month'];
    $blog_head = $_POST['blog_head'];
    $blog_text = $_POST['blog_text'];
    $blog_desc = $_POST['blog_desc'];

    // Handle image uploads
    $img1 = handleImageUpload('img1');
    $img2 = handleImageUpload('img2');
    $img3 = handleImageUpload('img3');

    // Determine which image to set as the card image
    $blog_img = "";
    switch ($_POST['blog_img']) {
        case 'img1':
            $blog_img = $img1;
            break;
        case 'img2':
            $blog_img = $img2;
            break;
        case 'img3':
            $blog_img = $img3;
            break;
        default:
            // Handle default case if needed
            break;
    }

    // Insert blog details into blog table
    $Insert_qry = "INSERT INTO blog (blog_date, blog_month, blog_head, blog_text, blog_desc, img1, img2, img3, blog_img) 
                   VALUES ('$blog_date', '$blog_month', '$blog_head', '$blog_text', '$blog_desc', '$img1', '$img2', '$img3', '$blog_img')";
    $res = mysqli_query($conn, $Insert_qry);

    if ($res) {
        $blog_id = mysqli_insert_id($conn); // Get the last inserted blog ID

        // Redirect or display success message
        echo "<script>
            alert('Blog Added Successfully');
            window.location.href='blogshow.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function handleImageUpload($fieldName)
{
    global $conn;

    $blog_img = $_FILES[$fieldName];
    $imagename = $blog_img['name'];
    $actualpath = $blog_img['tmp_name'];
    $mypath = "aboutimage/" . $imagename;

    // Check if the file extension is allowed
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $fileExtension = strtolower(pathinfo($imagename, PATHINFO_EXTENSION));

    if (in_array($fileExtension, $allowedExtensions)) {
        move_uploaded_file($actualpath, $mypath);
        return $mypath; // Return the uploaded file path
    } else {
        echo "<script>
            alert('Sorry, only JPG, JPEG, and PNG files are allowed for $fieldName');
            window.location.href='blogshow.php';
        </script>";
        exit; // Stop further execution
    }
}

require "footer.php";
?>
