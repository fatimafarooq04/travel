<?php
require "connection.php";
require "header.php";

// Get the current page number from the URL, default is 1
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$entries_per_page = isset($_GET['entries']) ? (int) $_GET['entries'] : 5;

// Calculate the starting entry for the current page
$start = ($page - 1) * $entries_per_page;

// Get the total number of entries in the blog_form table excluding replies
$total_entries_query = "SELECT COUNT(*) AS total FROM `blog_form` WHERE `parent_comment_id` IS NULL";
$total_entries_result = mysqli_query($conn, $total_entries_query);
$total_entries_row = mysqli_fetch_assoc($total_entries_result);
$total_entries = $total_entries_row['total'];

// Calculate the total number of pages
$total_pages = ceil($total_entries / $entries_per_page);

// Fetch all blog entries for the current page excluding replies
$query = "SELECT bf.`id`, bf.`blog_id`, b.`blog_text` AS `blog_title`, u.`Name` AS `user_name`, bf.`comment`, bf.`created_at`
          FROM `blog_form` bf
          JOIN `user` u ON bf.`user_id` = u.`UserID`
          JOIN `blog` b ON bf.`blog_id` = b.`blog_id`
          WHERE bf.`parent_comment_id` IS NULL
          LIMIT $start, $entries_per_page";
$result = mysqli_query($conn, $query);

// Initialize a counter for serial number
$serial_num = ($page - 1) * $entries_per_page + 1;
?>

<div class="container">
    <h1 class="mt-5 text-center">Blog Form List</h1>

    <!-- Live Search Bar -->
    <div class="row g-3 align-items-center my-3 mx-4">
        <!-- Search Input -->
        <div class="col-auto">
            <label for="inputPassword6" class="col-form-label">Search</label>
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

    <!-- Blogs Table -->
    <table class="table" id="blogsTable">
        <thead>
            <tr>
                <th scope="col">Serial Number</th>
                <th scope="col">Blog Title</th>
                <th scope="col">Comment</th>
                <th scope="col">User Name</th>
                <th scope="col">Created At</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $serial_num ?></td>
                    <td><?php echo htmlspecialchars($row['blog_title']) ?></td>
                    <td><?php echo htmlspecialchars($row['comment']) ?></td>
                    <td><?php echo htmlspecialchars($row['user_name']) ?></td>
                    <td><?php echo date('F j, Y, g:i a', strtotime($row['created_at'])); ?></td>
                    <td>
                        <a href="blogformdetails.php?id=<?php echo $row['id'] ?>" title="View Details">
                            <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> View Details</button>
                        </a>
                    </td>
                </tr>
                <?php $serial_num++; ?>
            <?php } ?>
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
        var rows = document.querySelectorAll('#blogsTable tbody tr');

        rows.forEach(function (row) {
            var blogTitle = row.cells[1].textContent.toLowerCase().trim();
            var comment = row.cells[2].textContent.toLowerCase().trim();
            var user_name = row.cells[3].textContent.toLowerCase().trim(); // Search by User Name

            if (blogTitle.includes(query) || comment.includes(query) || user_name.includes(query)) {
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