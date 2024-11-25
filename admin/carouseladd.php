<?php
require "connection.php";
require "header.php";
?>
<div class="container">
    <h1 class="mt-5">Add Carousel Info</h1>
    <form action="#" method="POST" class="mt-4" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="name">Heading:</label>
            <input type="text" class="form-control" id="name" name="carousel_head" required>
            <small class="text-danger" id="nameErr"></small>
        </div>

        <div class="form-group">
            <label for="country">Sub Heading:</label>
            <input type="text" class="form-control" id="country" name="carousel_subhead" required>
            <small class="text-danger" id="countryErr"></small>
        </div>
       
        
        <div class="form-group">
            <label for="imageUrl">Image URL:</label>
            <input type="file" class="form-control" id="imageUrl" name="carousel_img" accept=".jpg,.jpeg,.png">
        </div>
        <button type="submit" class="btn btn-primary">Add Carousel Info</button>
        <button type="reset" class="btn btn-secondary ml-2">Reset</button>
    </form>
</div>

<script>
function validateForm() {
    var name = document.getElementById('name').value;
    var country = document.getElementById('country').value;
   

    var isValid = true;

    if (!/^[A-Za-z\s]+$/.test(name)) {
        document.getElementById('nameErr').innerText = 'Only letters and spaces are allowed.';
        isValid = false;
    } else {
        document.getElementById('nameErr').innerText = '';
    }
    if (!/^[A-Za-z\s]+$/.test(country)) {
        document.getElementById('countryErr').innerText = 'Only letters and spaces are allowed.';
        isValid = false;
    } else {
        document.getElementById('countryErr').innerText = '';
    }


    return isValid;
}
</script>



<?php
require "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables to store form data
    $carousel_head = $_POST['carousel_head'];
    $carousel_subhead = $_POST['carousel_subhead'];
    $carousel_img = $_FILES['carousel_img']['name'];

    // File upload path
    $targetDir = "carouselimage/";
    $targetFilePath = $targetDir . basename($carousel_img);
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if file is a valid image file
    $isValid = true;
    if (!in_array($fileType, ['jpg', 'jpeg', 'png'])) {
        echo "Only JPG, JPEG, and PNG files are allowed.";
        $isValid = false;
    }

    // If all validations are passed, proceed with database insertion
    if ($isValid) {
        // Move uploaded image to destination directory
        if (move_uploaded_file($_FILES["carousel_img"]["tmp_name"], $targetFilePath)) {
            // Insert data into database
            $sql = "INSERT INTO carousel (carousel_head, carousel_subhead, carousel_img)
                    VALUES ('$carousel_head', '$carousel_subhead', '$targetFilePath')";

            if ($conn->query($sql) === TRUE) {
                // Close the database connection
                $conn->close();

                // Display success message
                echo "<script>
          alert('Carousel info added Successfully');
          window.location.href='carouselshow.php';
                </script>";
             
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    }
} else {
    echo "Invalid request method.";
}
?>
<?php
require "footer.php";
?>