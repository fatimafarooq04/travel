<?php
require "header.php";
require "connection.php";

// Fetch hotel data
$service_id = $_GET['updid'];
$updqry = "SELECT * FROM `services` WHERE service_id = $service_id";
$result = mysqli_query($conn, $updqry);

if (!$result) {
    echo "No service found with ID: " . $id;
    exit;
}
?>

<div class="container">
    <h1 class="mt-5">Edit Servics </h1>
    <form action="" method="POST" class="mt-4 mx-5" enctype="multipart/form-data">
        <?php
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        ?>
            <div class="form-group">
                <label for="name">Question:</label>
                <input type="text" class="form-control" id="name" name="service_name" value="<?php echo $row['service_name']; ?>">
            </div>
            <div class="form-group">
                <label for="name">Answer</label>
                <input type="text" class="form-control" id="name" name="service_desc" value="<?php echo $row['service_desc']; ?>">
            </div>
        
           
          
           
            <div class="text-center">
                <button type="submit" class="btn btn-primary mx-4 my-5" name="upd">Update Service</button>
                <button type="reset" class="btn btn-secondary ml-2 mx-4">Reset</button>
            </div>
        <?php
        } else {
            echo "No service found with ID: " . $id;
        }
        ?>
    </form>
</div>

<?php
if (isset($_POST['upd'])) {
    $service_name = $_POST['service_name'];
    $service_desc = $_POST['service_desc'];


    // Handle image uploads and setting card image
    

 

 

    // Update query
    $upd_qry = "UPDATE `services` SET 
                `service_name`='$service_name', 
                `service_desc`='$service_desc' 
                                WHERE service_id=$service_id";

    $result = mysqli_query($conn, $upd_qry);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "<script>
            alert('Update Successful');
            window.location.href ='serviceshow.php';
            </script>";
    }
}
require "footer.php";
?>
