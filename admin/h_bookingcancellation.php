<?php
require "connection.php";
require "header.php";

// Get the current page number from the URL, default is 1
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$entries_per_page = isset($_GET['entries']) ? (int) $_GET['entries'] : 5;
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Calculate the starting entry for the current page
$start = ($page - 1) * $entries_per_page;

// Get the total number of canceled bookings
$total_entries_query = "SELECT COUNT(*) AS total FROM `hotelbookings` WHERE `status` = 'Canceled' AND `booking_id` LIKE '%$search_query%'";
$total_entries_result = mysqli_query($conn, $total_entries_query);
$total_entries_row = mysqli_fetch_assoc($total_entries_result);
$total_entries = $total_entries_row['total'];

// Calculate the total number of pages
$total_pages = ceil($total_entries / $entries_per_page);

// Fetch canceled bookings for the current page based on search criteria
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
        hb.status = 'Canceled' AND hb.booking_id LIKE '%$search_query%'
    LIMIT 
        $start, $entries_per_page
";

$result = mysqli_query($conn, $query);

// Initialize a counter for serial number
$serial_num = ($page - 1) * $entries_per_page + 1;
?>

<div class="container">
    <h1 class="mt-5 text-center">Canceled Hotel Bookings</h1>

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

    <!-- Canceled Bookings Table -->
    <table class="table" id="canceledBookingsTable">
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
                    <!-- You can add additional actions here if needed -->
                </td>
            </tr>
        <?php
            $serial_num++;
        } ?>
        </tbody>
    </table>

    <!-- Pagination Controls -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>&entries=<?= $entries_per_page ?>&search=<?= urlencode($search_query) ?>">Previous</a></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?= $i ?>&entries=<?= $entries_per_page ?>&search=<?= urlencode($search_query) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>&entries=<?= $entries_per_page ?>&search=<?= urlencode($search_query) ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<script>
    function updateEntries() {
        const entries = document.getElementById('entriesSelect').value;
        const search = encodeURIComponent(document.getElementById('searchInput').value);
        window.location.href = "?page=1&entries=" + entries + "&search=" + search;
    }

    document.getElementById('searchInput').addEventListener('input', function () {
        var query = this.value.toLowerCase().trim();
        var rows = document.querySelectorAll('#canceledBookingsTable tbody tr');

        rows.forEach(function (row) {
            var bookingId = row.cells[0].textContent.toLowerCase().trim(); // Search by Booking ID

            if (bookingId.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<?php
require "footer.php";
?>
