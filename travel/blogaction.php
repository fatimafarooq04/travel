<?php
include "connection.php";

if (isset($_POST['sub'])) {
    $form_name = $_POST['form_name'];
    $form_email = $_POST['form_email'];
    $form_password = $_POST['form_password'];
    $form_message = $_POST['form_message'];
    $form_img = $_FILES['form_img'];

    $imagename = $form_img['name'];
    $actualpath = $form_img['tmp_name'];

    // Construct the path to the blogimage directory
    $mypath =  "../admin/aboutimage/" . $imagename;

    // Check if the file extension is allowed
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $fileExtension = strtolower(pathinfo($imagename, PATHINFO_EXTENSION));

    if (in_array($fileExtension, $allowedExtensions)) {
        if (move_uploaded_file($actualpath, $mypath)) {
            // Prepare an SQL statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO `blog_form`(`form_name`, `form_email`, `form_password`, `form_message`, `form_img`) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $form_name, $form_email, $form_password, $form_message, $mypath);

            if ($stmt->execute()) {
                echo "<script>
                    alert('Added Successfully');
                    window.location.href='blog.php';
                </script>";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "<script>
                alert('Failed to upload image.');
                window.location.href='blog.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Sorry, only JPG, JPEG, and PNG files are allowed.');
            window.location.href='blog.php';
        </script>";
    }
}
?>
