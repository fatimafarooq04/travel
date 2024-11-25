<?php
require "connection.php";
require "header.php";
?>
<div class="container">
    <h1 class="mt-5">Add Team Info</h1>
    <form action="#" method="POST" class="mt-4" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="team_name" required>
            <small class="text-danger" id="nameErr"></small>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="team_desc" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="imageUrl">Image URL:</label>
            <input type="file" class="form-control" id="imageUrl" name="team_img" accept=".jpg,.jpeg,.png">
        </div>
        <button type="submit" class="btn btn-primary">Add Team Info</button>
        <button type="reset" class="btn btn-secondary ml-2">Reset</button>
    </form>
</div>

<script>
function validateForm() {
    var name = document.getElementById('name').value;
    var description = document.getElementById('description').value;
   

    var isValid = true;

    if (!/^[A-Za-z\s]+$/.test(name)) {
        document.getElementById('nameErr').innerText = 'Only letters and spaces are allowed.';
        isValid = false;
    } else {
        document.getElementById('nameErr').innerText = '';
    }
    if (!/^[A-Za-z\s]+$/.test(description)) {
        document.getElementById('nameErr').innerText = 'Only letters and spaces are allowed.';
        isValid = false;
    } else {
        document.getElementById('nameErr').innerText = '';
    }


    return isValid;
}
</script>



<?php
require "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables to store form data
    $team_name = $_POST['team_name'];
    $team_desc = $_POST['team_desc'];
    $team_img = $_FILES['team_img']['name'];

    // File upload path
    $targetDir = "aboutimage/";
    $targetFilePath = $targetDir . basename($team_img);
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
        if (move_uploaded_file($_FILES["team_img"]["tmp_name"], $targetFilePath)) {
            // Insert data into database
            $sql = "INSERT INTO team_info (team_name, team_desc, team_img)
                    VALUES ('$team_name', '$team_desc', '$targetFilePath')";

            if ($conn->query($sql) === TRUE) {
                // Close the database connection
                $conn->close();

                // Display success message
                echo "<script>
          alert('Team info added Successfully');
          window.location.href='teamshow.php';
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