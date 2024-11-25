<?php
require "connection.php";
require "header.php";
?>

<div class="container">
    <h1 class="mt-5 text-center">Carousel Info List</h1>

    <!-- Live Search Bar -->
    <div class="row g-3 align-items-center my-3 ms-auto">
        <div class="col-auto">
            <label for="inputPassword6" class="col-form-label">Search</label>
        </div>
        <div class="col-auto">
            <input type="text" class="form-control" id="searchInput" placeholder="Search...">
        </div>
    </div>

    <!-- Destinations Table -->
    <table class="table" id="destinationsTable">
        <thead>
            <tr>
                <th scope="col">Heading</th>
                <th scope="col">Sub Heading</th>
                <th scope="col">Image</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Initial SQL query to fetch all destinations
            $initialSql = "SELECT * FROM carousel";
            $initialResult = $conn->query($initialSql);

            if ($initialResult->num_rows > 0) {
                while ($row = $initialResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['carousel_head']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['carousel_subhead']) . "</td>";
                    echo "<td><img src='" . htmlspecialchars($row['carousel_img']) . "' alt='Team Image' style='max-width: 50px;'></td>";
                    echo "<td>
                            <button class='btn btn-warning btn-sm' onclick='editcarousel(" . $row['carousel_id'] . ")'>Edit</button>
                            <button class='btn btn-danger btn-sm' onclick='deletecarousel(" . $row['carousel_id'] . ")'>Delete</button>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No Carousel found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>


<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        var query = this.value.toLowerCase().trim();
        var rows = document.querySelectorAll('#destinationsTable tbody tr');

        var noResultsRow = document.getElementById('noResultsRow');
        var hasResults = false;

        rows.forEach(function (row) {
            var name = row.cells[0].textContent.toLowerCase().trim();
            var description = row.cells[1].textContent.toLowerCase().trim();
            var country = row.cells[2].textContent.toLowerCase().trim();
            var state = row.cells[3].textContent.toLowerCase().trim();
            var city = row.cells[4].textContent.toLowerCase().trim();
            var bestTimeToVisit = row.cells[5].textContent.toLowerCase().trim();

            if (name.includes(query) ||
                description.includes(query) ||
                country.includes(query) ||
                state.includes(query) ||
                city.includes(query) ||
                bestTimeToVisit.includes(query)) {
                row.style.display = '';
                hasResults = true;
            } else {
                row.style.display = 'none';
            }
        });

        // Show/hide "No destinations found" message based on search results
        if (hasResults) {
            noResultsRow.style.display = 'none';
        } else {
            noResultsRow.style.display = '';
        }
    });

    function editcarousel(id) {
        // Redirect to the edit page with the destination ID
        window.location.href = 'carouseledit?id=' + id;
    }

    function deletecarousel(id) {
        // Ask for confirmation before deleting
        if (confirm('Are you sure you want to delete this Carousel?')) {
            window.location.href = 'carouseldelete.php?id=' + id;
        }
    }
</script>

<?php
require "footer.php";
?>
