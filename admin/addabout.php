<?php
require "header.php"; // Include necessary files
require "connection.php";

if (isset($_POST['sub'])) {
    $about_head = $_POST['about_head'];
    $about_subhead = $_POST['about_subhead'];
    $about_text = $_POST['about_text'];

    // Handle Image 1
    $about_img = $_FILES['about_img'];
    $imagename1 = $about_img['name'];
    $actualpath1 = $about_img['tmp_name'];
    $mypath1 = "aboutimage/" . $imagename1;

    // Handle Image 2
    $about_img2 = $_FILES['about_img2'];
    $imagename2 = $about_img2['name'];
    $actualpath2 = $about_img2['tmp_name'];
    $mypath2 = "aboutimage/" . $imagename2;

    // Handle Image 3
    $about_img3 = $_FILES['about_img3'];
    $imagename3 = $about_img3['name'];
    $actualpath3 = $about_img3['tmp_name'];
    $mypath3 = "aboutimage/" . $imagename3;

    // Check if the file extensions are allowed
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $fileExtension1 = strtolower(pathinfo($imagename1, PATHINFO_EXTENSION));
    $fileExtension2 = strtolower(pathinfo($imagename2, PATHINFO_EXTENSION));
    $fileExtension3 = strtolower(pathinfo($imagename3, PATHINFO_EXTENSION));

    if (in_array($fileExtension1, $allowedExtensions) && in_array($fileExtension2, $allowedExtensions) && in_array($fileExtension3, $allowedExtensions)) {
        move_uploaded_file($actualpath1, $mypath1);
        move_uploaded_file($actualpath2, $mypath2);
        move_uploaded_file($actualpath3, $mypath3);

      

        // Execute the SQL query
        $Insert_qry = "INSERT INTO `about_us`(`about_head`, `about_subhead`, `about_text`, `about_img`, `about_img2`, `about_img3`) 
                       VALUES ('$about_head','$about_subhead','$about_text','$mypath1','$mypath2','$mypath3')";

        $res = mysqli_query($conn, $Insert_qry);

        if ($res) {
            echo "<script>
                alert('About Us Added Successfully');
                window.location.href='aboutshow.php';
            </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>
            alert('Sorry, only jpg, jpeg, and png files are allowed.');
            window.location.href='aboutshow.php';
        </script>";
    }
}


?>

<div class="container">
    <h1 class="mt-5 text-center">Add About Us</h1>
    <form action="#" method="POST" class="mt-4 mx-5" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Heading:</label>
            <input type="text" class="form-control" id="name" name="about_head" required>
        </div>

        <div class="form-group">
            <label for="name">Sub Heading:</label>
            <input type="text" class="form-control" id="name" name="about_subhead" required>
        </div>

        <div class="form-group">
            <label for="name">Description:</label>
            <textarea class="form-control" id="description" name="about_text" rows="4" required></textarea>
        </div>

       
    
     
      
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image1">Image 1:</label>
                    <input type="file" class="form-control" id="image1" name="about_img" accept=".jpg,.jpeg,.png" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image2">Image 2:</label>
                    <input type="file" class="form-control" id="image2" name="about_img2" accept=".jpg,.jpeg,.png" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image3">Image 3:</label>
                    <input type="file" class="form-control" id="image3" name="about_img3" accept=".jpg,.jpeg,.png" required>
                </div>
            </div>

           
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mx-4" name="sub">Add About Us</button>
            <button type="reset" class="btn btn-secondary ml-2 mx-4">Reset</button>
        </div>
    </form>
</div>

<?php
require "footer.php";
?>
