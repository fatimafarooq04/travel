<?php
include "connection.php";

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $email = $_POST['mail'];
    $subject = $_POST['sub'];
    $message = $_POST['msg'];

    $insert_qry = "INSERT INTO `contact`(`con_name`, `con_mail`, `con_sub`, `con_msg`) VALUES ('$name','$email','$subject','$message')";
    $result = mysqli_query($conn, $insert_qry);

    if ($result) {
        echo "<script>
            alert('Your Message Has Been Delivered Successfully');
            window.location.href='contact.php';
            </script>";
    } else {
        echo "<script>
            alert('Error: Could not send message. Please try again later.');
            window.location.href='contact.php';
            </script>";
    }
}

?>