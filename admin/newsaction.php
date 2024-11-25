<?php
require "connection.php";

if (isset($_POST['sub'])) {
    // Get the POST data
    $new_mail = htmlspecialchars($_POST['new_mail'], ENT_QUOTES, 'UTF-8');

    // Get the current date and time
    $currentDateTime = date("Y-m-d H:i:s");

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO `news` (`new_mail`, `new_register`) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("ss", $new_mail, $currentDateTime);

        // Execute the statement
        if ($stmt->execute()) {
            // Success, redirect with alert
            echo "<script>
            alert('Subscription Successful');
            window.location.href='index.php';
            </script>";
        } else {
            // Error in execution
            echo "<script>
            alert('Error: " . $stmt->error . "');
            window.location.href='index.php';
            </script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error in preparing the statement
        echo "<script>
        alert('Error: " . $conn->error . "');
        window.location.href='index.php';
        </script>";
    }
}

// Close the connection
$conn->close();
?>
