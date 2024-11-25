<?php
require "connection.php";
require "header.php";

// Fetch city data from the database
$sql = "SELECT CityID, CityName FROM city";
$result = mysqli_query($conn, $sql);

// Initialize an array to store city options
$cityOptions = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cityID = $row['CityID'];
        $cityName = $row['CityName'];
        $cityOptions[] = ['id' => $cityID, 'name' => $cityName];
    }
}
?>

<!-- Header Start -->
<div class="container-fluid page-header fade-in">
    <div class="container">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <h3 class="display-4 text-white text-uppercase">Hotels</h3>
            <div class="d-inline-flex text-white">
                <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Hotels</p>
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
            <!-- Filter Container -->
            <div class="filter-container fade-in">
                <!-- City Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by city</h5>
                    <form id="city-filter-form">
                        <?php foreach ($cityOptions as $city) {
                            $cityID = $city['id'];
                            $sql = "SELECT COUNT(*) as count FROM hotel WHERE CityID = $cityID";
                            $result = $conn->query($sql);
                            $hotelCount = ($result->num_rows > 0) ? $result->fetch_assoc()['count'] : 0;
                            ?>
                            <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-3">
                                <input type="radio" class="custom-control-input city-radio"
                                    name="city" id="city-<?php echo $city['id']; ?>" data-city="<?php echo $city['id']; ?>">
                                <label class="custom-control-label" for="city-<?php echo $city['id']; ?>">
                                    <?php echo $city['name']; ?>
                                </label>
                                <span class="badge border font-weight-normal"><?php echo $hotelCount; ?></span>
                            </div>
                        <?php } ?>
                    </form>
                </div>
                <!-- City End -->
            </div>
        </div>
        <!-- Shop Sidebar End -->

        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-12" id="hotel-list">
            <div class="row">
                <?php
                // Fetch hotel data from the database
                $query = "SELECT h.HotelID, h.Name AS HotelName, h.Description, h.CardImage, h.CityID
                          FROM hotel h";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $hotelID = $row['HotelID'];
                        $hotelName = $row['HotelName'];
                        $description = $row['Description'];
                        $cardImage = $row['CardImage'];
                        $cityID = $row['CityID'];
                        $truncatedDescription = strlen($description) > 100 ? substr($description, 0, 100) . '...' : $description;
                        ?>
                        <div class="col-md-4 col-sm-6 pb-4 hotel-item fade-in" data-city="<?php echo $cityID; ?>">
                            <div class="card product-item border-0 mb-4 shadow-sm">
                                <img class="card-img-top img-fluid" src="../admin/<?php echo $cardImage; ?>"
                                    alt="<?php echo $hotelName; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $hotelName; ?></h5>
                                    <p class="card-text"><?php echo $truncatedDescription; ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="hoteldetails.php?id=<?php echo $hotelID; ?>" class="btn btn-primary">Check More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } 
                } ?>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>

<style>
    /* Ensure all cards have the same height */
    .card {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Hover effect for card */
    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Set card image height and object-fit */
    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    /* Set the card body height to ensure consistent card height */
    .card-body {
        padding: 15px;
        flex-grow: 1;
    }

    /* Set the title, text, and price styles */
    .card-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .card-text {
        font-size: 14px;
        color: #555;
        flex-grow: 1;
    }

    .text-primary {
        font-size: 16px;
        font-weight: bold;
        color: #007bff;
        margin: 0;
    }

    /* Ensure consistent margin and padding */
    .card-body .btn-primary {
        padding: 8px 12px;
        font-size: 14px;
        font-weight: bold;
    }
</style>

<!-- AJAX script for handling city filter -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const cityRadios = document.querySelectorAll(".city-radio");
        const hotelItems = document.querySelectorAll(".hotel-item");

        const applyCityFilter = () => {
            const selectedCity = Array.from(cityRadios).find(radio => radio.checked)?.dataset.city;

            hotelItems.forEach(item => {
                const hotelCity = item.dataset.city;
                if (!selectedCity || hotelCity === selectedCity) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        };

        cityRadios.forEach(radio => radio.addEventListener("change", applyCityFilter));
        applyCityFilter(); // Apply the filter on page load
    });
</script>

<?php
require "footer.php";
?>
