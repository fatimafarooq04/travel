<?php
require "connection.php";
require "header.php";

// Handle search query
$search_query = isset($_POST['search']) ? $_POST['search'] : '';

// Pagination settings
$cards_per_page = 9;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $cards_per_page;

// Fetch the total number of cards
$total_query = "SELECT COUNT(*) as total 
                FROM `destination` 
                JOIN `city` ON destination.CityID = city.CityID";
if (!empty($search_query)) {
    $search_query = strtolower($search_query);
    $total_query .= " WHERE LOWER(city.CityName) LIKE '%$search_query%' OR LOWER(destination.Name) LIKE '%$search_query%'";
}
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_cards = $total_row['total'];
$total_pages = ceil($total_cards / $cards_per_page);
?>

<!-- Header Start -->
<div class="container-fluid page-header">
    <div class="container">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <h3 class="display-4 text-white text-uppercase">Destination </h3>
            <div class="d-inline-flex text-white">
                <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Destination</p>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Destination Start -->
<div class="container-fluid py-5">
    <div class="container pt-5 pb-3">
        <div class="text-center mb-3 pb-3">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Destination</h6>
            <h1>Explore Top Destination</h1>
        </div>

        <!-- Animated Search Bar -->
        <div class="search-container">
            <form method="POST" action="" class="search-box" id="searchForm">
                <input type="text" class="form-control" name="search" id="searchInput" placeholder="Search..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
            </form>
        </div>

        <div class="row" id="destinationsContainer">
            <?php
            // Fetch destinations along with city names from the database
            $sql = "SELECT destination.*, city.CityName as CityName 
            FROM `destination` 
            JOIN `city` ON destination.CityID = city.CityID";

            // If there's a search query, modify the SQL to include a WHERE clause
            if (!empty($search_query)) {
                $sql .= " WHERE LOWER(city.CityName) LIKE '%$search_query%' OR LOWER(destination.Name) LIKE '%$search_query%'";
            }

            $sql .= " ORDER BY RAND() LIMIT $start, $cards_per_page"; // Adjust SQL query as needed
            $result = mysqli_query($conn, $sql);
            $found = false;

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $found = true;
                    $destination_id = $row['DestinationID']; // Assuming 'DestinationID' is the primary key of your destination table
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4 destination-item fade-in">
                        <div class="destination-item position-relative overflow-hidden mb-2"
                            id="destination-<?php echo $destination_id; ?>">
                            <img class="img-fluid" src="../admin/<?php echo $row['CardImage']; ?>"
                                alt="<?php echo $row['Name']; ?>" style="height: 300px; width:400px">
                            <a class="destination-overlay text-white text-decoration-none"
                                href="destinationdetail.php?id=<?php echo $row['DestinationID']; ?>">
                                <h5 class="text-white"><?php echo $row['Name']; ?></h5>
                                <span><?php echo $row['CityName']; ?></span>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            }

            if (!$found) {
                echo '<div class="col-12 text-center" id="noResultsMessage">
                        <h5>No destination found</h5>
                      </div>';
            }
            ?>
        </div>

        <!-- Pagination Controls -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>
<!-- Destination End -->

<?php
require "footer.php";
?>

<!-- Add the CSS for Animation and Responsiveness -->
<style>
/* Animation for fade-in effect */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.fade-in {
    opacity: 0; /* Start hidden */
    animation: fadeIn 1s ease-out forwards; /* Fade in over 1 second */
}

/* Base styles for the cards */
.destination-item {
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}

/* Responsive styling for cards */
@media (max-width: 1200px) {
    .destination-item {
        /* Adjust for medium screens (e.g., tablets) */
        margin-bottom: 20px;
    }
}

@media (max-width: 992px) {
    .col-lg-4 {
        /* For large tablets and smaller screens, use 6 columns */
        width: 50%;
    }
}

@media (max-width: 768px) {
    .col-md-6 {
        /* For tablets and mobile devices, use full width */
        width: 100%;
    }

    .destination-item img {
        /* Make images responsive */
        height: auto;
        width: 100%;
    }

    .destination-overlay {
        /* Adjust overlay text */
        padding: 10px;
    }
}

@media (max-width: 576px) {
    .destination-item {
        /* For very small screens (e.g., small phones) */
        margin-bottom: 15px;
    }

    .destination-overlay {
        font-size: 14px;
    }
}

/* Styles for search bar */
.search-container {
    position: relative;
}

.search-box {
    display: flex;
    align-items: center;
    transition: width 0.4s ease; /* Smooth transition */
}

.search-box input {
    width: 200px; /* Initial width */
    transition: width 0.4s ease; /* Smooth transition */
}

.search-box input.expanded {
    width: 300px; /* Expanded width */
}

.search-btn {
    position: absolute;
    right: 0;
    background-color: transparent;
    border: none;
    cursor: pointer;
}

.search-box input:focus {
    outline: none;
}
</style>

<!-- Add JavaScript for Animation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const destinationItems = document.querySelectorAll('.destination-item');
    destinationItems.forEach((item, index) => {
        // Add delay to each item for staggered animation
        setTimeout(() => {
            item.classList.add('fade-in');
        }, 100 * index); // Adjust delay as needed
    });

    // JavaScript to handle search bar expansion
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');

    searchInput.addEventListener('focus', function() {
        searchInput.classList.add('expanded');
    });

    searchInput.addEventListener('blur', function() {
        searchInput.classList.remove('expanded');
    });
});
</script>
