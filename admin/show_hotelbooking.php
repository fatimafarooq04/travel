<?php
require "connection.php";
require "header.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../travel/phpmailer/Exception.php';
require '../travel/phpmailer/PHPMailer.php';
require '../travel/phpmailer/SMTP.php';

// Function to send cancellation email
function sendCancellationEmail($email, $booking_id) {
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
        $mail->Subject = 'Booking Cancellation Confirmation';
        $mail->Body = "Dear user,<br>Your booking with ID <strong>$booking_id</strong> has been successfully canceled.<br>Thank you.";

        $mail->send();
        echo "<script>alert('Cancellation email sent successfully');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Email could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
    }
}

// Handle booking cancellation
if (isset($_POST['cancel_booking_id'])) {
    $booking_id = mysqli_real_escape_string($conn, $_POST['cancel_booking_id']);
    $update_query = "UPDATE `hotelbookings` SET `status` = 'Canceled' WHERE `booking_id` = '$booking_id'";
    if (mysqli_query($conn, $update_query)) {
        // Fetch the user's email based on the booking_id
        $user_query = "SELECT u.Email FROM user u JOIN hotelbookings hb ON u.UserID = hb.user_id WHERE hb.booking_id = '$booking_id'";
        $user_result = mysqli_query($conn, $user_query);
        $user_row = mysqli_fetch_assoc($user_result);
        $user_email = $user_row['Email'];

        if ($user_email) {
            sendCancellationEmail($user_email, $booking_id);
        }

        // Redirect to the show_hotelbooking.php page after a successful cancellation
        echo "<script>window.location.href = 'show_hotelbooking.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error canceling booking');</script>";
    }
}

// Get the current page number from the URL, default is 1
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$entries_per_page = isset($_GET['entries']) ? (int) $_GET['entries'] : 5;
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Calculate the starting entry for the current page
$start = ($page - 1) * $entries_per_page;

// Get the total number of entries in the hotelbookings table based on search criteria
$total_entries_query = "SELECT COUNT(*) AS total FROM `hotelbookings` WHERE `booking_id` LIKE '%$search_query%' AND `status` <> 'Canceled'";
$total_entries_result = mysqli_query($conn, $total_entries_query);
$total_entries_row = mysqli_fetch_assoc($total_entries_result);
$total_entries = $total_entries_row['total'];

// Calculate the total number of pages
$total_pages = ceil($total_entries / $entries_per_page);

// Fetch bookings for the current page based on search criteria and exclude canceled bookings
$query = "
    SELECT 
        hb.booking_id, 
        u.Name AS user_name, 
        h.Name AS hotel_name, 
        hr.room_id, 
        hr.room_type AS room_type_name, 
        hr.description AS room_description, 
        hr.room_size AS room_size, 
        hr.guest_capacity AS guest_capacity, 
        hr.price, 
        hr.policy, 
        hr.img1, 
        hr.img2, 
        hr.img3, 
        hb.check_in_date, 
        hb.check_out_date, 
        hb.payment_method_id, 
        hb.status, 
        hb.created_at, 
        hb.updated_at
    FROM 
        hotelbookings hb
    JOIN 
        user u ON hb.user_id = u.UserID
    JOIN 
        hotel h ON hb.hotel_id = h.HotelID
    JOIN 
        hotel_rooms hr ON hb.new_room_id = hr.room_id
    WHERE 
        hb.booking_id LIKE '%$search_query%'
        AND hb.status <> 'Canceled'  /* Exclude canceled bookings */
    LIMIT 
        $start, $entries_per_page
";

$result = mysqli_query($conn, $query);

// Initialize a counter for serial number
$serial_num = ($page - 1) * $entries_per_page + 1;
?>

<div class="container">
    <h1 class="mt-5 text-center">Hotel Bookings List</h1>

    <!-- Live Search Bar -->
    <div class="row g-3 align-items-center my-3 mx-4">
        <!-- Search Input -->
        <div class="col-auto">
            <label for="searchInput" class="col-form-label">Search by Booking ID</label>
        </div>
        <div class="col-auto">
            <input type="text" class="form-control" id="searchInput" placeholder="Search by Booking ID" value="<?php echo htmlspecialchars($search_query); ?>">
        </div>

        <!-- Entries Per Page Dropdown -->
        <div class="col-auto ms-auto">
            <label for="entriesSelect" class="col-form-label">Entries per page</label>
        </div>
        <div class="col-auto">
            <select class="form-select" id="entriesSelect" onchange="updateEntries()">
                <option value="5" <?php if ($entries_per_page == 5) echo 'selected'; ?>>5</option>
                <option value="10" <?php if ($entries_per_page == 10) echo 'selected'; ?>>10</option>
                <option value="25" <?php if ($entries_per_page == 25) echo 'selected'; ?>>25</option>
                <option value="50" <?php if ($entries_per_page == 50) echo 'selected'; ?>>50</option>
            </select>
        </div>
    </div>

    <!-- Bookings Table -->
    <table class="table" id="bookingsTable">
        <thead>
            <tr>
                <th scope="col">Booking ID</th>
                <th scope="col">User Name</th>
                <th scope="col">Hotel Name</th>
                <th scope="col">Room Type</th>
                <th scope="col">Price</th>
                <th scope="col">Check-in Date</th>
                <th scope="col">Check-out Date</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['booking_id']) ?></td>
                <td><?php echo htmlspecialchars($row['user_name']) ?></td>
                <td><?php echo htmlspecialchars($row['hotel_name']) ?></td>
                <td><?php echo htmlspecialchars($row['room_type_name']) ?></td>
                <td><?php echo htmlspecialchars($row['price']) ?></td>
                <td><?php echo htmlspecialchars($row['check_in_date']) ?></td>
                <td><?php echo htmlspecialchars($row['check_out_date']) ?></td>
                <td><?php echo htmlspecialchars($row['status']) ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="cancel_booking_id" value="<?php echo htmlspecialchars($row['booking_id']) ?>">
                        <input type="hidden" name="current_page" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                        <button type="submit" class="btn btn-danger">Cancel</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li class="page-item <?php if ($page == 1) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>&entries=<?php echo $entries_per_page; ?>&search=<?php echo htmlspecialchars($search_query); ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&entries=<?php echo $entries_per_page; ?>&search=<?php echo htmlspecialchars($search_query); ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>
            <li class="page-item <?php if ($page == $total_pages) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>&entries=<?php echo $entries_per_page; ?>&search=<?php echo htmlspecialchars($search_query); ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<!-- JavaScript for live search and entries per page -->
<script>
document.getElementById('searchInput').addEventListener('input', function() {
    const searchQuery = this.value;
    window.location.href = `?page=1&entries=${document.getElementById('entriesSelect').value}&search=${encodeURIComponent(searchQuery)}`;
});

function updateEntries() {
    const entriesPerPage = document.getElementById('entriesSelect').value;
    window.location.href = `?page=1&entries=${entriesPerPage}&search=${encodeURIComponent(document.getElementById('searchInput').value)}`;
}
</script>

<?php require "footer.php"; ?>
