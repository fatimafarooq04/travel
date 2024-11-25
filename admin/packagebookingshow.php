<?php
require "connection.php"; // Database connection
require "header.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../travel/phpmailer/Exception.php';
require '../travel/phpmailer/PHPMailer.php';
require '../travel/phpmailer/SMTP.php';

// Function to send booking status email
function sendStatusEmail($email, $booking_id, $new_status) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0; // Suppress debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'fatimafarooq183@gmail.com'; // Set your email
        $mail->Password = 'yqhccaqkgnqnzeas'; // Set your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('fatimafarooq183@gmail.com', 'Traveler');
        $mail->addAddress($email); // Add the user's email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Booking Cancelation Status Update';
        $mail->Body = "Dear user,<br>Your booking with ID <strong>$booking_id</strong> has been Cancel to status: <strong>$new_status</strong>.<br>Thank you.";

        $mail->send();
    } catch (Exception $e) {
        echo "<script>alert('Email could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
    }
}

// Handle status update for confirm and cancel
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $new_status = $_POST['status'];
    
    if ($new_status === 'Confirmed' || $new_status === 'Canceled') {
        $update_query = "UPDATE package_booking SET status = ? WHERE booking_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param('si', $new_status, $booking_id);
        
        if ($stmt->execute()) {
            // Fetch the user's email based on the booking_id
            $user_query = "SELECT u.Email FROM user u JOIN package_booking pb ON u.UserID = pb.userid WHERE pb.booking_id = ?";
            $user_stmt = $conn->prepare($user_query);
            $user_stmt->bind_param('i', $booking_id);
            $user_stmt->execute();
            $user_result = $user_stmt->get_result();
            $user_row = $user_result->fetch_assoc();
            $user_email = $user_row['Email'];

            if ($user_email) {
                sendStatusEmail($user_email, $booking_id, $new_status);
            }

            echo "<script>alert('Booking status updated to " . ucfirst($new_status) . "');</script>";
        } else {
            echo "<script>alert('Error updating booking status');</script>";
        }
    }
}

// Fetch all package bookings
$booking_query = "
    SELECT pb.booking_id, pb.userid, u.Name, tc.pack_name, tp.start_date, tp.end_date, pb.booking_date, pb.status, pb.message
    FROM package_booking pb
    JOIN tour_card tc ON pb.package_id = tc.pack_id
    JOIN tour_package_dates tp ON pb.date_range_id = tp.id
    JOIN user u ON pb.userid = u.UserID
    WHERE pb.status != 'Canceled'
";

$booking_result = $conn->query($booking_query);
?>

<div class="container mt-4">
    <h1 class="text-center">All Package Bookings</h1>
    
    <?php if ($booking_result->num_rows > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Username</th>
                    <th>Package Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Booking Date</th>
                    <th>Status</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $booking_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['booking_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['Name']); ?></td>
                        <td><?php echo htmlspecialchars($row['pack_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                        <td>
                            <?php if ($row['status'] === 'Pending' || $row['status'] === 'Confirmed'): ?>
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($row['booking_id']); ?>">
                                    <input type="hidden" name="status" value="Confirmed">
                                    <button type="submit" class="btn btn-success btn-sm">Confirm</button>
                                </form>
                            <?php endif; ?>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($row['booking_id']); ?>">
                                <input type="hidden" name="status" value="Canceled">
                                <button type="submit" class="btn btn-danger btn-sm" <?php echo ($row['status'] === 'Canceled' ? 'disabled' : ''); ?>>Cancel</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No package bookings found.</div>
    <?php endif; ?>
</div>

<?php
$conn->close();
require "footer.php";
?>
