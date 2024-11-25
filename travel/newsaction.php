<?php
require "connection.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;  // Include this line for SMTP class

// Include PHPMailer files
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

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
            // Success, send email
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
                $mail->isSMTP(); // Send using SMTP
                $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
                $mail->SMTPAuth   = true; // Enable SMTP authentication
                $mail->Username   = 'fatimafarooq183@gmail.com'; // SMTP username
                $mail->Password   = 'yqhccaqkgnqnzeas'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
                $mail->Port       = 465; // TCP port to connect to

                //Recipients
                $mail->setFrom('fatimafarooq183@gmail.com', 'Traveler');
                $mail->addAddress($new_mail); // Send to the email provided by the user

                // Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = 'Subscription Confirmation';
                $mail->Body    = 'Thank you for subscribing to TravelExplorer! Stay tuned for our latest updates and travel tips.';

                $mail->send();
                echo "<script>
                alert('Subscription Successful. A confirmation email has been sent.');
                window.location.href='index.php';
                </script>";
            } catch (Exception $e) {
                echo "<script>
                alert('Subscription Successful, but the email could not be sent. Mailer Error: " . $mail->ErrorInfo . "');
                window.location.href='index.php';
                </script>";
            }
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
