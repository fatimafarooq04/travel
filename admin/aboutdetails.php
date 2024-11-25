<?php
require "connection.php";
require "header.php";

// Check if the ID parameter exists in the URL
if (isset($_GET['id'])) {
    $about_id = (int) $_GET['id'];

    // Query to fetch details of the destination including city name
         $qry = "SELECT `about_head`, `about_subhead`, `about_text`, `about_img`, `about_img2`, `about_img3` FROM `about_us` WHERE `about_id` = $about_id";

    $result = mysqli_query($conn, $qry);

    if ( mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $about_head = $row['about_head'];
        $about_subhead = $row['about_subhead'];
        $about_text = $row['about_text'];
        $about_img = $row['about_img'];
        $about_img2 = $row['about_img2'];
        $about_img3 = $row['about_img3'];
    } else {
        // Redirect to an error page or handle error appropriately
        header("Location: error.php");
        exit();
    }
} else {
    // Redirect to an error page or handle error appropriately
    header("Location: error.php");
    exit();
}
?>

<div class="container">
    <h1 class="mt-5 mb-4 text-center"><?php echo $about_head; ?> Details</h1>

    <div class="row mx-4">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo $about_img; ?>" class="img-fluid mb-3" alt="<?php echo $about_head; ?> Image 1" style="max-width: 100%; height: auto;">
                    <h6 class="text-center"><?php echo ($about_img === $about_img) ? "About Image" : "Image 1"; ?></h6>
                </div>
                <div class="col-md-6">
                    <img src="<?php echo $about_img2; ?>" class="img-fluid mb-3" alt="<?php echo $about_head; ?> Image 2" style="max-width: 100%; height: auto;">
                    <h6 class="text-center"><?php echo ($about_img2 === $about_img2) ? "About Image" : "Image 2"; ?></h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo $about_img3; ?>" class="img-fluid mb-3" alt="<?php echo $about_head; ?> Image 3" style="max-width: 100%; height: auto;">
                    <h6 class="text-center"><?php echo ($about_img3 === $about_img3) ? "Card Image" : "Image 3"; ?></h6>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h3>Heading</h3>
            <p><strong>Heading:</strong> <?php echo $about_head; ?></p>
            <p><strong>Sub Heading:</strong> <?php echo $about_subhead; ?></p>
            <h3>Description</h3>
            <p><?php echo $about_text; ?></p>

        </div>
    </div>

    <div class="row mt-4 mx-4">
        <div class="col text-center">
            <a href="aboutedit.php?updid=<?php echo $about_id; ?>" class="btn btn-sm btn-info mx-2" title="Edit"><i class="fas fa-pencil-alt"></i> Edit</a>
            <a href="aboutdelete.php?dltid=<?php echo $about_id; ?>" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash-alt"></i> Delete</a>
        </div>
    </div>
</div>

<?php
require "footer.php";
?>
