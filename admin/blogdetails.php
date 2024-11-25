<?php
require "connection.php";
require "header.php";

// Check if the ID parameter exists in the URL
if (isset($_GET['id'])) {
    $blog_id = (int) $_GET['id'];

    // Query to fetch details of the destination including city name
         $qry = "SELECT `blog_date`, `blog_month`, `blog_head`, `blog_text`, `blog_desc`, `img1`, `img2`, `img3`, `blog_img` FROM `blog` WHERE `blog_id` = $blog_id";

    $result = mysqli_query($conn, $qry);

    if ( mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $blog_date = $row['blog_date'];
        $blog_month = $row['blog_month'];
        $blog_head = $row['blog_head'];
        $blog_text = $row['blog_text'];
        $blog_desc = $row['blog_desc']; 
        $img1 = $row['img1'];
        $img2 = $row['img2'];
        $img3 = $row['img3'];
        $blog_img = $row['blog_img'];
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
    <h1 class="mt-5 mb-4 text-center"><?php echo $blog_head; ?> Details</h1>

    <div class="row mx-4">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo $img1; ?>" class="img-fluid mb-3" alt="<?php echo $blog_head; ?> Image 1" style="max-width: 100%; height: auto;">
                    <h6 class="text-center"><?php echo ($blog_img === $img1) ? "Blog Image" : "Image 1"; ?></h6>
                </div>
                <div class="col-md-6">
                    <img src="<?php echo $img2; ?>" class="img-fluid mb-3" alt="<?php echo $blog_head; ?> Image 2" style="max-width: 100%; height: auto;">
                    <h6 class="text-center"><?php echo ($blog_img === $img2) ? "Blog Image" : "Image 2"; ?></h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo $img3; ?>" class="img-fluid mb-3" alt="<?php echo $blog_head; ?> Image 3" style="max-width: 100%; height: auto;">
                    <h6 class="text-center"><?php echo ($blog_img === $img3) ? "Card Image" : "Image 3"; ?></h6>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h3>Blog Date</h3>
            <p><strong>Date:</strong> <?php echo $blog_date; ?></p>
            <p><strong>Month:</strong> <?php echo $blog_month; ?></p>
            <h3>Heading:</h3>
            <p><?php echo $blog_head; ?></p>
            <h3>Blog Text</h3>
            <p><?php echo $blog_text; ?></p>
            <h3>Blog Description</h3>
            <p><?php echo $blog_desc; ?></p>

        </div>
    </div>

    <div class="row mt-4 mx-4">
        <div class="col text-center">
            <a href="blogedit.php?updid=<?php echo $blog_id; ?>" class="btn btn-sm btn-info mx-2" title="Edit"><i class="fas fa-pencil-alt"></i> Edit</a>
            <a href="blogdelete.php?dltid=<?php echo $blog_id; ?>" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash-alt"></i> Delete</a>
        </div>
    </div>
</div>

<?php
require "footer.php";
?>
