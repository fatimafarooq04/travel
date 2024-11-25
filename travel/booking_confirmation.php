<?php
require "header.php";
require "connection.php"; // Adjust based on your file structure

if (!isset($_SESSION['UserID'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Retrieve userID from session
$userID = $_SESSION['UserID'];

// Fetch the latest booking details for the logged-in user
$booking = [];
$user = [];
$package = [];
$dateRange = [];

// Fetch the latest booking details for the user
$bookingQuery = "
    SELECT pb.*, tp.pack_name, tp.pack_price, tpd.start_date, tpd.end_date
    FROM package_booking pb
    JOIN tour_card tp ON pb.package_id = tp.pack_id
    JOIN tour_package_dates tpd ON pb.date_range_id = tpd.id
    WHERE pb.user_id = ?
    ORDER BY pb.booking_date DESC
    LIMIT 1";

$stmt = $conn->prepare($bookingQuery);
if ($stmt) {
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $bookingResult = $stmt->get_result();
    if ($bookingResult->num_rows > 0) {
        $booking = $bookingResult->fetch_assoc();
    }
    $stmt->close();
}

// Fetch user details
$userQuery = "SELECT Name, email, phone FROM user WHERE UserID = ?";
$stmt = $conn->prepare($userQuery);
if ($stmt) {
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $userResult = $stmt->get_result();
    if ($userResult->num_rows > 0) {
        $user = $userResult->fetch_assoc();
    }
    $stmt->close();
}

$conn->close();
?>

<!-- Booking Confirmation Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mb-3 pb-3">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Booking Confirmation</h6>
            <h2 class="text-center text-success mb-4">Thank you for your booking!</h2>

        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="bg-white shadow rounded p-4">
                    <?php if (!empty($booking)): ?>
                        <p class="text-center mb-4">Here are your booking details:</p>
                        <div class="booking-details p-4 border rounded">
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['Name'] ?? ''); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone'] ?? ''); ?></p>
                            <p><strong>Package Name:</strong> <?php echo htmlspecialchars($booking['pack_name'] ?? ''); ?></p>
                            <p><strong>Price:</strong> $<?php echo htmlspecialchars($booking['pack_price'] ?? ''); ?></p>
                            <p><strong>Date Range:</strong> <?php echo htmlspecialchars($booking['start_date'] ?? ''); ?> to <?php echo htmlspecialchars($booking['end_date'] ?? ''); ?></p>
                            <p><strong>Booking Date:</strong> <?php echo htmlspecialchars($booking['booking_date'] ?? ''); ?></p>
                            <p><strong>Status:</strong> <?php echo htmlspecialchars($booking['status'] ?? 'Pending'); ?></p>
                            <p><strong>Additional Notes:</strong> <?php echo htmlspecialchars($booking['message'] ?? 'None'); ?></p>
                        </div>
                    <?php else: ?>
                        <h2 class="text-center text-danger mb-4">No booking details found.</h2>
                        <p class="text-center mb-4">Please try again or contact support.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Booking Confirmation End -->

<?php
require "footer.php";
?>

<style>
    .booking-details {
        background-color: #f8f9fa;
    }
    .booking-details p {
        font-size: 1.1rem;
        line-height: 1.5;
    }
</style>
