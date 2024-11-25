<?php
require "header.php";
require "connection.php";

// Get the current page number from the URL, default is 1
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$entries_per_page = isset($_GET['entries']) ? (int) $_GET['entries'] : 5;

// Calculate the starting entry for the current page
$start = ($page - 1) * $entries_per_page;

// Get the total number of entries in the package_itinerary table
$total_entries_query = "SELECT COUNT(*) AS total FROM package_itinerary";
$total_entries_result = mysqli_query($conn, $total_entries_query);

if (!$total_entries_result) {
    die("Error executing total_entries_query: " . mysqli_error($conn));
}

$total_entries_row = mysqli_fetch_assoc($total_entries_result);
$total_entries = $total_entries_row['total'];

// Calculate the total number of pages
$total_pages = ceil($total_entries / $entries_per_page);

// Fetch the entries for the current page with package descriptions and day names
$query = "
    SELECT pi.ItineraryID, pi.PackID, tc.pack_name, d.days, pi.Description
    FROM package_itinerary pi
    JOIN tour_card tc ON pi.PackID = tc.pack_id
    JOIN t_days d ON pi.DayID = d.day_id
    ORDER BY pi.PackID, d.day_id
    LIMIT $start, $entries_per_page
";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

// Initialize a counter for serial number
$serial_num = ($page - 1) * $entries_per_page + 1;
?>

<div class="container">
    <h1 class="mt-5 text-center">Itinerary List</h1>

    <!-- Live Search Bar -->
    <div class="row g-3 align-items-center my-3 mx-4">
        <!-- Search Input -->
        <div class="col-auto">
            <label for="searchInput" class="col-form-label">Search</label>
        </div>
        <div class="col-auto">
            <input type="text" class="form-control" id="searchInput" placeholder="Search...">
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

    <!-- Itineraries Table -->
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Serial Number</th>
                <th scope="col">Package</th>
                <th scope="col">Day</th>
                <th scope="col">Itinerary</th>
                <th scope="col">Actions</th> <!-- Added Actions Column -->
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $serial_num; ?></td>
                        <td><?php echo htmlspecialchars($row['pack_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['days']); ?></td>
                        <td><?php echo htmlspecialchars($row['Description']); ?></td>
                        <td>
                           
                            <a href="edit_itinerary.php?id=<?php echo $row['ItineraryID']; ?>" class="btn btn-sm btn-info mx-2" title="Edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="itinerarydelete.php?id=<?php echo $row['ItineraryID']; ?>" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this itinerary?');">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php
                    $serial_num++;
                endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No itineraries found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination Controls -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>&entries=<?= $entries_per_page ?>">Previous</a></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?= $i ?>&entries=<?= $entries_per_page ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>&entries=<?= $entries_per_page ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<script>
    function updateEntries() {
        const entries = document.getElementById('entriesSelect').value;
        window.location.href = "?page=1&entries=" + entries;
    }

    document.getElementById('searchInput').addEventListener('input', function () {
        var query = this.value.toLowerCase().trim();
        var rows = document.querySelectorAll('table tbody tr');

        rows.forEach(function (row) {
            var package = row.cells[1].textContent.toLowerCase().trim();
            var day = row.cells[2].textContent.toLowerCase().trim();
            var description = row.cells[3].textContent.toLowerCase().trim();

            if (package.includes(query) || day.includes(query) || description.includes(query)) {
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
