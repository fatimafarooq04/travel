<?php
require "header.php";
require "connection.php"; // Ensure this file sets up $conn correctly

// Fetch the selected city and sort order from GET parameters
$selectedCityID = isset($_GET['city']) ? intval($_GET['city']) : 'all';
$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'default';

// Build the query based on the selected filters
$query = "SELECT p.pack_id, p.day_id, p.pack_name, p.pack_img, p.pack_price, p.CityID, c.CityName, d.days
FROM tour_card p
LEFT JOIN city c ON p.CityID = c.CityID
LEFT JOIN t_days d ON p.day_id = d.day_id";

$conditions = [];

if ($selectedCityID !== 'all') {
    $conditions[] = "p.CityID = " . mysqli_real_escape_string($conn, $selectedCityID);
}

if (count($conditions) > 0) {
    $query .= " WHERE " . implode(' AND ', $conditions);
}

if ($sortOrder === 'low-to-high') {
    $query .= " ORDER BY p.pack_price ASC";
} elseif ($sortOrder === 'high-to-low') {
    $query .= " ORDER BY p.pack_price DESC";
}

$result = mysqli_query($conn, $query);
?>

<!-- Header Start -->
<div class="container-fluid page-header">
    <div class="container">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <h3 class="display-4 text-white text-uppercase">Tours</h3>
            <div class="d-inline-flex text-white">
                <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Tours</p>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Shop Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-12">
            <!-- Sort By Start -->
            <div class="border-bottom mb-4 pb-4">
                <h5 class="font-weight-semi-bold mb-4">Sort By Price</h5>
                <select id="price-sort" class="custom-select px-4" style="height: 47px;">
                    <option value="default" <?php echo $sortOrder === 'default' ? 'selected' : ''; ?>>Sort By Price</option>
                    <option value="low-to-high" <?php echo $sortOrder === 'low-to-high' ? 'selected' : ''; ?>>Low to High</option>
                    <option value="high-to-low" <?php echo $sortOrder === 'high-to-low' ? 'selected' : ''; ?>>High to Low</option>
                </select>
            </div>
            <!-- Sort By End -->

            <!-- City Filter Start -->
            <div class="border-bottom mb-4 pb-4">
                <h5 class="font-weight-semi-bold mb-4">Filter by City</h5>
                <form id="city-filter-form">
                    <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" id="city-all" name="city" value="all" <?php echo $selectedCityID === 'all' ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="city-all">All Cities</label>
                    </div>
                    <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" id="city-karachi" name="city" value="1" <?php echo $selectedCityID == 1 ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="city-karachi">Karachi</label>
                    </div>
                    <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" id="city-islamabad" name="city" value="2" <?php echo $selectedCityID == 2 ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="city-islamabad">Faisalabad</label>
                    </div>
                    <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" id="city-lahore" name="city" value="3" <?php echo $selectedCityID == 3 ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="city-lahore">Lahore</label>
                    </div>
                    <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" id="city-rawalpindi" name="city" value="4" <?php echo $selectedCityID == 4 ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="city-rawalpindi">Islamabad</label>
                    </div>
                    <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" id="city-faisalabad" name="city" value="5" <?php echo $selectedCityID == 5 ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="city-faisalabad">Rawalpindi</label>
                    </div>
                </form>
            </div>
            <!-- City Filter End -->
        </div>
        <!-- Shop Sidebar End -->

        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-12">
            <div class="row" id="package-container">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $pack_id = $row['pack_id'];
                        $day_id = $row['day_id'];
                        $days = $row['days'];
                        $pack_desc = $row['pack_name'];
                        $pack_img = $row['pack_img'];
                        $pack_price = $row['pack_price'];
                        $CityID = $row['CityID'];
                        $CityName = $row['CityName'];
                        $truncatedDescription = strlen($pack_desc) > 100 ? substr($pack_desc, 0, 100) . '...' : $pack_desc;
                        
                        $imagePath = "../admin/" . $pack_img;
                ?>
                <div class="bg-white mb-2 d-flex flex-column package-item" data-city="<?php echo $CityName; ?>" data-price="<?php echo $pack_price; ?>">
                    <img class="img-fluid" src="<?php echo $imagePath; ?>" alt="">

                    <div class="p-4 flex-grow-1">
                        <div class="d-flex justify-content-between mb-3">
                            <small class="m-0"><i class="fa fa-map-marker-alt text-primary mr-2"></i><?php echo $CityName; ?></small>
                            <small class="m-0"><i class="fa fa-calendar-alt text-primary mr-2"></i><?php echo $days; ?> days</small>
                        </div>
                        <a class="h5 text-decoration-none" href="packagedetails.php?id=<?php echo $pack_id; ?>"><?php echo $truncatedDescription; ?></a>
                        <div class="border-top mt-4 pt-4">
                            <div class="d-flex justify-content-between">
                                <h5 class="m-0">PKR <?php echo $pack_price; ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 d-flex justify-content-between">
                        <a href="packagedetails.php?id=<?php echo $pack_id; ?>" class="btn btn-sm btn-primary">View Details</a>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "<p>No packages found.</p>";
                }
                ?>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->

<?php
require "footer.php";
?>

<script>
// Handle price sorting and city filtering
document.getElementById('price-sort').addEventListener('change', function() {
    let sortOrder = this.value;
    let url = new URL(window.location.href);
    url.searchParams.set('sort', sortOrder);
    window.location.href = url.toString();
});

document.getElementById('city-filter-form').addEventListener('change', function(event) {
    if (event.target.name === 'city') {
        let cityID = event.target.value;
        let url = new URL(window.location.href);
        url.searchParams.set('city', cityID);
        window.location.href = url.toString();
    }
});
</script>

<style>
/* Container for package cards */
#package-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px; /* Space between cards */
}

/* Ensure package items take up equal width */
.package-item {
    width: calc(33.333% - 20px); /* Assuming three cards per row */
}

@media (max-width: 992px) {
    /* For tablets and small screens, make each card take half the row */
    .package-item {
        width: calc(50% - 20px);
    }
}

@media (max-width: 576px) {
    /* For mobile screens, make each card take the full row */
    .package-item {
        width: 100%;
    }
}
</style>
