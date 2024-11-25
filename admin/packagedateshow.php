<!DOCTYPE html>
<html>

<head>
    <title>Show Package Dates</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Delete button confirmation
            $('.delete-btn').click(function () {
                var dateId = $(this).data('id');
                if (confirm('Are you sure you want to delete this date?')) {
                    window.location.href = 'delete_package_date.php?id=' + dateId;
                }
            });

            // Search functionality
            $('#searchInput').on('input', function () {
                var query = this.value.toLowerCase().trim();
                $('#datesTable tbody tr').each(function () {
                    var row = $(this);
                    var packageName = row.find('td').eq(1).text().toLowerCase().trim();
                    var startDate = row.find('td').eq(2).text().toLowerCase().trim();
                    var endDate = row.find('td').eq(3).text().toLowerCase().trim();
                    var maxPeople = row.find('td').eq(4).text().toLowerCase().trim();

                    if (packageName.includes(query) || startDate.includes(query) || endDate.includes(query) || maxPeople.includes(query)) {
                        row.show();
                    } else {
                        row.hide();
                    }
                });
            });

            // Entries per page update
            $('#entriesSelect').change(function () {
                var entries = $(this).val();
                window.location.href = "?page=1&entries=" + entries;
            });
        });
    </script>
</head>

<body>
    <?php
    require "header.php";
    require "connection.php";

    // Get the current page number from the URL, default is 1
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $entries_per_page = isset($_GET['entries']) ? (int)$_GET['entries'] : 5;

    // Calculate the starting entry for the current page
    $start = ($page - 1) * $entries_per_page;

    // Get the total number of entries in the package dates table
    $total_entries_query = "SELECT COUNT(*) AS total FROM tour_package_dates";
    $total_entries_result = mysqli_query($conn, $total_entries_query);
    $total_entries_row = mysqli_fetch_assoc($total_entries_result);
    $total_entries = $total_entries_row['total'];

    // Calculate the total number of pages
    $total_pages = ceil($total_entries / $entries_per_page);

    // Fetch the entries for the current page including max_people
    $qry = "SELECT d.id, t.pack_name, d.start_date, d.end_date, d.max_people 
            FROM tour_package_dates d
            JOIN tour_card t ON d.pack_id = t.pack_id
            LIMIT $start, $entries_per_page";
    $result = mysqli_query($conn, $qry);

    // Initialize a counter for serial number
    $serial_num = ($page - 1) * $entries_per_page + 1;
    ?>

    <div class="container">
        <h1 class="mt-5 text-center">Package Dates</h1>

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
                <select class="form-select" id="entriesSelect">
                    <option value="5" <?php if ($entries_per_page == 5) echo 'selected'; ?>>5</option>
                    <option value="10" <?php if ($entries_per_page == 10) echo 'selected'; ?>>10</option>
                    <option value="25" <?php if ($entries_per_page == 25) echo 'selected'; ?>>25</option>
                    <option value="50" <?php if ($entries_per_page == 50) echo 'selected'; ?>>50</option>
                </select>
            </div>
        </div>

        <!-- Dates Table -->
        <table class="table" id="datesTable">
            <thead>
                <tr>
                    <th scope="col">Serial Number</th>
                    <th scope="col">Package Name</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Max People</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $serial_num ?></td>
                        <td><?php echo htmlspecialchars($row['pack_name']) ?></td>
                        <td><?php echo htmlspecialchars($row['start_date']) ?></td>
                        <td><?php echo htmlspecialchars($row['end_date']) ?></td>
                        <td><?php echo htmlspecialchars($row['max_people']) ?></td>
                        <td>
                            <a href="packagedateedit.php?id=<?php echo $row['id'] ?>" class="btn btn-sm btn-info mx-2" title="Edit"><i class='fas fa-pencil-alt'></i> Edit</a>
                            <!-- <a href="packagedatedelete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" title="Delete"><i class='fas fa-trash-alt'></i> Delete</a> -->
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

    <?php
    $conn->close();
    require "footer.php";
    ?>
</body>

</html>
