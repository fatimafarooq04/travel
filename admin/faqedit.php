<?php
require "header.php";
require "connection.php";

// Fetch hotel data
$id = $_GET['updid'];
$updqry = "SELECT * FROM `faqs` WHERE faq_id = $id";
$result = mysqli_query($conn, $updqry);

if (!$result) {
    echo "No About us found with ID: " . $id;
    exit;
}
?>

<div class="container">
    <h1 class="mt-5">Edit FAQs </h1>
    <form action="" method="POST" class="mt-4 mx-5" enctype="multipart/form-data">
        <?php
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        ?>
            <div class="form-group">
                <label for="name">Question:</label>
                <input type="text" class="form-control" id="name" name="faq_ques" value="<?php echo $row['faq_ques']; ?>">
            </div>
            <div class="form-group">
                <label for="name">Answer</label>
                <input type="text" class="form-control" id="name" name="faq_ans" value="<?php echo $row['faq_ans']; ?>">
            </div>
        
           
          
           
            <div class="text-center">
                <button type="submit" class="btn btn-primary mx-4 my-5" name="upd">Update FAQs</button>
                <button type="reset" class="btn btn-secondary ml-2 mx-4">Reset</button>
            </div>
        <?php
        } else {
            echo "No hotel found with ID: " . $id;
        }
        ?>
    </form>
</div>

<?php
if (isset($_POST['upd'])) {
    $faq_ques = $_POST['faq_ques'];
    $faq_ans = $_POST['faq_ans'];


    // Handle image uploads and setting card image
    

 

 

    // Update query
    $upd_qry = "UPDATE `faqs` SET 
                `faq_ques`='$faq_ques', 
                `faq_ans`='$faq_ans' 
                                WHERE faq_id=$id";

    $result = mysqli_query($conn, $upd_qry);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "<script>
            alert('Update Successful');
            window.location.href ='faqshow.php';
            </script>";
    }
}
require "footer.php";
?>
