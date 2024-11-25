<?php
ob_start(); // Start output buffering
require "header.php";
require "connection.php"; // Adjust based on your file structure

// Include PHPMailer files and use namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

// Check if user is logged in and user_id is set
if (!isset($_SESSION['UserID'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Retrieve userID from session
$userID = isset($_SESSION['UserID']) ? intval($_SESSION['UserID']) : 0;
$userEmail = isset($_SESSION['valid']) ? $_SESSION['valid'] : ''; // Fetch the user's email from the session

// Get form data
$packageID = isset($_POST['packageID']) ? intval($_POST['packageID']) : 0;
$dateRange = isset($_POST['dateRange']) ? intval($_POST['dateRange']) : 0;
$message = isset($_POST['message']) ? trim($_POST['message']) : '';
$paymentMethod = isset($_POST['paymentMethod']) ? trim($_POST['paymentMethod']) : '';
$peopleCount = isset($_POST['numPeople']) ? intval($_POST['numPeople']) : 0; // Get the number of people

// Process booking
if ($packageID > 0 && $dateRange > 0 && !empty($paymentMethod)) {
    // Map payment method to ID (example mapping, adjust as needed)
    $paymentMethodMap = [
        'easypaisa' => 1,
        'jaazcash' => 2,
        'sadapay' => 3,
        'mezaan' => 4
    ];
    $paymentMethodID = isset($paymentMethodMap[$paymentMethod]) ? $paymentMethodMap[$paymentMethod] : 0;
    $status = 'confirmed'; // Set status to confirmed directly

    // Fetch package price
    $priceQuery = "SELECT pack_price FROM tour_card WHERE pack_id = ?";
    $stmt = $conn->prepare($priceQuery);
    if ($stmt) {
        $stmt->bind_param("i", $packageID);
        $stmt->execute();
        $priceResult = $stmt->get_result();
        $packagePrice = 0;

        if ($priceResult->num_rows > 0) {
            $priceData = $priceResult->fetch_assoc();
            $packagePrice = $priceData['pack_price'];
        }
        $stmt->close();

        // Calculate total price
        $totalPrice = $packagePrice * $peopleCount;

        // Insert booking into the database
        $bookingQuery = "INSERT INTO package_booking (userid, package_id, date_range_id, message, status, payment_method_id, people_count, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($bookingQuery);
        if ($stmt) {
            $stmt->bind_param("iiissiii", $userID, $packageID, $dateRange, $message, $status, $paymentMethodID, $peopleCount, $totalPrice);
            $stmt->execute();
            $bookingID = $stmt->insert_id;
            $stmt->close();

            // Fetch package name and date range details for email
            $detailsQuery = "
                SELECT tp.pack_name, tpd.start_date, tpd.end_date
                FROM package_booking pb
                JOIN tour_card tp ON pb.package_id = tp.pack_id
                JOIN tour_package_dates tpd ON pb.date_range_id = tpd.id
                WHERE pb.booking_id = ?";

            $stmt = $conn->prepare($detailsQuery);
            if ($stmt) {
                $stmt->bind_param("i", $bookingID);
                $stmt->execute();
                $detailsResult = $stmt->get_result();
                $details = $detailsResult->fetch_assoc();
                $stmt->close();
            }

            // Store booking details in session
            $_SESSION['booking'] = [
                'bookingID' => $bookingID,
                'userID' => $userID,
                'packageID' => $packageID,
                'dateRange' => $dateRange,
                'message' => $message,
                'status' => $status,
                'paymentMethodID' => $paymentMethodID,
                'peopleCount' => $peopleCount, // Store people count in session
                'totalPrice' => $totalPrice, // Store total price in session
                'packageName' => $details['pack_name'] ?? 'N/A',
                'startDate' => $details['start_date'] ?? 'N/A',
                'endDate' => $details['end_date'] ?? 'N/A'
            ];

            // Send email confirmation using PHPMailer
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'fatimafarooq183@gmail.com'; // Replace with your Gmail address
                $mail->Password   = 'yqhccaqkgnqnzeas'; // Replace with your Gmail password or app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use ENCRYPTION_SMTPS for port 465
                $mail->Port       = 465;

                $mail->setFrom('fatimafarooq183@gmail.com', 'Traveler'); // Replace with your Gmail address
                $mail->addAddress($userEmail); // Use the email address from the session
                $mail->isHTML(true);
                $mail->Subject = 'Booking Confirmation';
                $mail->Body    = '<p>Thank you for booking with us!</p>
                                  <p><strong>Booking ID:</strong> ' . htmlspecialchars($bookingID) . '</p>
                                  <p><strong>Package Name:</strong> ' . htmlspecialchars($details['pack_name']) . '</p>
                                  <p><strong>Date Range:</strong> ' . htmlspecialchars($details['start_date']) . ' to ' . htmlspecialchars($details['end_date']) . '</p>
                                  <p><strong>Message:</strong> ' . htmlspecialchars($message) . '</p>
                                  <p><strong>Status:</strong> ' . htmlspecialchars($status) . '</p>
                                  <p><strong>Payment Method:</strong> ' . htmlspecialchars($paymentMethod) . '</p>
                                  <p><strong>Number of People:</strong> ' . htmlspecialchars($peopleCount) . '</p>
                                  <p><strong>Total Price:</strong> ' . htmlspecialchars(number_format($totalPrice)) . '</p>'; // Add total price to email

                $mail->send();
                
                // Store success message in session
                $_SESSION['email_sent'] = 'An email confirmation has been sent to ' . htmlspecialchars($userEmail) . '.';

            } catch (Exception $e) {
                $_SESSION['email_sent'] = "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            // Redirect to booking status page
            header("Location: booking_status.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error fetching package price.";
    }
} else {
    echo "Invalid booking details.";
}

$conn->close();
ob_end_flush(); // Flush the output buffer
?>
