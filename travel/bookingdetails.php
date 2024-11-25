<?php
require "header.php";
require "connection.php"; // Database connection

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['UserID'];

// Handle package booking confirmation and cancellation requests
if (isset($_POST['confirm_package_booking_id'])) {
    $booking_id = $_POST['confirm_package_booking_id'];
    $update_query = "UPDATE package_booking SET status = 'Confirmed' WHERE booking_id = ? AND userid = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('ii', $booking_id, $user_id);
    if ($update_stmt->execute()) {
        $message = "Your package booking has been confirmed.";
    } else {
        $message = "Failed to update booking status.";
    }
}

if (isset($_POST['cancel_package_booking_id'])) {
    $booking_id = $_POST['cancel_package_booking_id'];

    // Check if the booking exists and the date is still valid for cancellation
    $check_query = "
        SELECT pb.booking_id, tp.start_date, pb.status
        FROM package_booking pb
        JOIN tour_package_dates tp ON pb.date_range_id = tp.id
        WHERE pb.booking_id = ? AND pb.userid = ?
    ";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param('ii', $booking_id, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $row = $check_result->fetch_assoc();
        $start_date = new DateTime($row['start_date']);
        $today = new DateTime();
        $current_status = $row['status'];

        // Check if the package start date is after today and the current status is "Pending" or "Confirm"
        if ($start_date > $today && in_array($current_status, ['Pending', 'Confirm'])) {
            $update_query = "UPDATE package_booking SET status = 'Canceled' WHERE booking_id = ? AND userid = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param('ii', $booking_id, $user_id);
            if ($update_stmt->execute()) {
                $message = "Your package booking has been successfully cancelled.";
            } else {
                $message = "Failed to update booking status.";
            }
        } else {
            $message = "You cannot cancel a booking that has already started or is not in a cancellable state.";
        }
    } else {
        $message = "Booking not found or you don't have permission to cancel it.";
    }
}

// Handle hotel booking confirmation and cancellation requests
if (isset($_POST['confirm_hotel_booking_id'])) {
    $booking_id = $_POST['confirm_hotel_booking_id'];
    $update_query = "UPDATE hotelbookings SET status = 'Confirmed' WHERE booking_id = ? AND user_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('ii', $booking_id, $user_id);
    if ($update_stmt->execute()) {
        $message = "Your hotel booking has been confirmed.";
    } else {
        $message = "Failed to update booking status.";
    }
}

if (isset($_POST['cancel_hotel_booking_id'])) {
    $booking_id = $_POST['cancel_hotel_booking_id'];

    // Check if the booking exists and the date is still valid for cancellation
    $check_query = "
        SELECT hb.booking_id, hb.check_in_date, hb.status
        FROM hotelbookings hb
        WHERE hb.booking_id = ? AND hb.user_id = ?
    ";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param('ii', $booking_id, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $row = $check_result->fetch_assoc();
        $check_in_date = new DateTime($row['check_in_date']);
        $today = new DateTime();
        $current_status = $row['status'];

        // Check if the hotel booking date is after today and the current status is "Pending" or "Confirm"
        if ($check_in_date > $today && in_array($current_status, ['Pending', 'Confirm'])) {
            $update_query = "UPDATE hotelbookings SET status = 'Canceled' WHERE booking_id = ? AND user_id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param('ii', $booking_id, $user_id);
            if ($update_stmt->execute()) {
                $message = "Your hotel booking has been successfully cancelled.";
            } else {
                $message = "Failed to update booking status.";
            }
        } else {
            $message = "You cannot cancel a booking that has already started or is not in a cancellable state.";
        }
    } else {
        $message = "Booking not found or you don't have permission to cancel it.";
    }
}

// Fetch package bookings for the logged-in user
$package_booking_query = "
    SELECT pb.booking_id, pb.message, pb.booking_date, pb.status, tc.pack_name, tc.pack_price, tp.start_date, tp.end_date, h.Name AS hotel_name, h.Address AS hotel_address, h.ContactInfo AS hotel_contact
    FROM package_booking pb
    JOIN tour_card tc ON pb.package_id = tc.pack_id
    JOIN tour_package_dates tp ON pb.date_range_id = tp.id
    JOIN hotel h ON tc.HotelID = h.HotelID
    WHERE pb.userid = ?
";
$package_booking_stmt = $conn->prepare($package_booking_query);
$package_booking_stmt->bind_param('i', $user_id);
$package_booking_stmt->execute();
$package_booking_result = $package_booking_stmt->get_result();

// Fetch hotel bookings for the logged-in user with room type name
$hotel_booking_query = "
    SELECT hb.booking_id, h.Name AS hotel_name, rt.TypeName AS room_type, hb.check_in_date, hb.check_out_date, hr.price AS room_price, hb.status
    FROM hotelbookings hb
    JOIN hotel h ON hb.hotel_id = h.HotelID
    JOIN hotel_rooms hr ON hb.new_room_id = hr.room_id
    JOIN room_types rt ON hr.room_type = rt.RoomTypeID
    WHERE hb.user_id = ?
";
$hotel_booking_stmt = $conn->prepare($hotel_booking_query);
$hotel_booking_stmt->bind_param('i', $user_id);
$hotel_booking_stmt->execute();
$hotel_booking_result = $hotel_booking_stmt->get_result();
?>

<div class="container mt-4">
    <h1 class="text-center">My Bookings</h1>

    <?php if (isset($message)): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="package-tab" data-toggle="tab" href="#package" role="tab"
                aria-controls="package" aria-selected="true">Package Bookings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="hotel-tab" data-toggle="tab" href="#hotel" role="tab" aria-controls="hotel"
                aria-selected="false">Hotel Bookings</a>
        </li>
    </ul>
    <div class="tab-content mt-3" id="myTabContent">
        <!-- Package Bookings Tab -->
        <div class="tab-pane fade show active" id="package" role="tabpanel" aria-labelledby="package-tab">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Package Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Hotel</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $package_booking_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['booking_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['pack_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['hotel_name']); ?>, <?php echo htmlspecialchars($row['hotel_address']); ?></td>
                            <td><?php echo htmlspecialchars($row['pack_price']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Hotel Bookings Tab -->
        <div class="tab-pane fade" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Hotel Name</th>
                        <th>Room Type</th>
                        <th>Check-in Date</th>
                        <th>Check-out Date</th>
                        <th>Room Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $hotel_booking_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['booking_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['hotel_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['room_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['check_in_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['check_out_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['room_price']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require "footer.php";
?>
