<?php
require "header.php";

// Include PHPMailer files and use namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

// Check if user is logged in and user_id is set
if (!isset($_SESSION['UserID']) || !isset($_SESSION['valid'])) {
    die('User is not logged in.');
}
$userID = $_SESSION['UserID'];
$userEmail = $_SESSION['valid']; // Fetch the user's email from the session

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get POST data
    $hotelID = $_POST['hotelID'] ?? null;
    $newRoomID = $_POST['roomID'] ?? null;
    $checkInDate = $_POST['checkinDate'] ?? '';
    $checkOutDate = $_POST['checkoutDate'] ?? '';
    $paymentMethod = $_POST['paymentMethod'] ?? '';

    // Validate payment method
    $validPaymentMethods = ['Easypaisa', 'JaazCash', 'Sadapay', 'Meezan Bank'];
    if (!in_array($paymentMethod, $validPaymentMethods)) {
        die('Invalid payment method selected.');
    }

    // Map payment method to ID
    $paymentMethods = [
        'Easypaisa' => 1,
        'JaazCash' => 2,
        'Sadapay' => 3,
        'Meezan Bank' => 4
    ];
    
    $paymentMethodID = $paymentMethods[$paymentMethod] ?? null;

    if (!$paymentMethodID) {
        die('Payment method ID not found.');
    }

    // Insert booking with the correct payment method ID
    $stmt = $conn->prepare("
        INSERT INTO hotelbookings (user_id, hotel_id, new_room_id, check_in_date, check_out_date, payment_method_id, status, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, 'Confirmed', NOW(), NOW())
    ");
    $stmt->bind_param("iissii", $userID, $hotelID, $newRoomID, $checkInDate, $checkOutDate, $paymentMethodID);

    if ($stmt->execute()) {
        $confirmationStatus = 'confirmed';
    } else {
        $confirmationStatus = 'error';
        echo "Insert Error: " . $stmt->error;
    }

    // Calculate total price
    $totalPrice = 0;
    if ($newRoomID) {
        $stmt = $conn->prepare("
            SELECT price
            FROM hotel_rooms
            WHERE room_id = ?
        ");
        $stmt->bind_param("i", $newRoomID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $pricePerNight = $row['price'];
            $checkIn = strtotime($checkInDate);
            $checkOut = strtotime($checkOutDate);
            if ($checkIn && $checkOut && $checkIn < $checkOut) {
                $diff = ($checkOut - $checkIn) / (60 * 60 * 24);
                $totalPrice = $pricePerNight * $diff;
            }
        } else {
            echo 'Error: Room not found.';
        }
    } else {
        echo 'Error: Room ID is missing.';
    }

    // Fetch hotel name
    $stmt = $conn->prepare("
        SELECT Name
        FROM hotel
        WHERE HotelID = ?
    ");
    $stmt->bind_param("i", $hotelID);
    $stmt->execute();
    $result = $stmt->get_result();
    $hotelData = $result->fetch_assoc();
    $hotelName = $hotelData ? $hotelData['Name'] : 'Unknown Hotel';

    // Fetch room type
    $stmt = $conn->prepare("
        SELECT rt.TypeName
        FROM hotel_rooms r
        JOIN room_types rt ON r.room_type = rt.RoomTypeID
        WHERE r.room_id = ?
    ");
    $stmt->bind_param("i", $newRoomID);
    $stmt->execute();
    $result = $stmt->get_result();
    $roomData = $result->fetch_assoc();
    $roomType = $roomData ? $roomData['TypeName'] : 'Unknown Room Type';

    // Display Booking Summary
    echo '<div class="container mt-5">';
    echo '<div class="booking-summary">';
    echo '<h3>Booking Summary</h3>';
    echo '<p><strong>Hotel Name:</strong> ' . htmlspecialchars($hotelName) . '</p>';
    echo '<p><strong>Room Type:</strong> ' . htmlspecialchars($roomType) . '</p>';
    echo '<p><strong>Check-In Date:</strong> ' . htmlspecialchars($checkInDate) . '</p>';
    echo '<p><strong>Check-Out Date:</strong> ' . htmlspecialchars($checkOutDate) . '</p>';
    echo '<p><strong>Total Price:</strong> $' . htmlspecialchars(number_format($totalPrice, 2)) . '</p>';
    echo '<p><strong>Payment Method:</strong> ' . htmlspecialchars($paymentMethod) . '</p>';

    if ($confirmationStatus === 'confirmed') {
        echo '<div class="confirmation-message">';
        echo '<p>Booking confirmed. Thank you!</p>';
        echo '</div>';

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
                              <p><strong>Hotel:</strong> ' . htmlspecialchars($hotelName) . '</p>
                              <p><strong>Room Type:</strong> ' . htmlspecialchars($roomType) . '</p>
                              <p><strong>Check-In Date:</strong> ' . htmlspecialchars($checkInDate) . '</p>
                              <p><strong>Check-Out Date:</strong> ' . htmlspecialchars($checkOutDate) . '</p>
                              <p><strong>Total Price:</strong> ' . htmlspecialchars(number_format($totalPrice, 2)) . '</p>
                              <p><strong>Payment Method:</strong> ' . htmlspecialchars($paymentMethod) . '</p>';

            // $mail->SMTPDebug = 2; // Enable detailed debug output
            $mail->send();
            echo '<p>An email confirmation has been sent to ' . htmlspecialchars($userEmail) . '</p>';
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo '<p>Booking failed. Please try again.</p>';
    }

    echo '</div>';
    echo '</div>';
}
?>

<?php
require "footer.php";
?>

<style>
    /* Basic container styling */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Booking summary section */
.booking-summary {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Header styling */
.booking-summary h3 {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

/* Paragraph styling */
.booking-summary p {
    font-size: 16px;
    color: #555;
    margin: 10px 0;
}

/* Strong tag styling */
.booking-summary p strong {
    color: #333;
}

/* Confirmation message styling */
.confirmation-message {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
    padding: 10px;
    border-radius: 5px;
    margin-top: 20px;
}

/* Error message styling */
.booking-summary p.error {
    color: #dc3545;
    font-weight: bold;
}

/* Responsive design */
@media (max-width: 768px) {
    .booking-summary {
        padding: 15px;
    }

    .booking-summary h3 {
        font-size: 20px;
    }

    .booking-summary p {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .booking-summary {
        padding: 10px;
    }

    .booking-summary h3 {
        font-size: 18px;
    }

    .booking-summary p {
        font-size: 12px;
    }
}
</style>