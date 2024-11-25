<?php
require "connection.php";
require "header.php";

// Ensure hotel ID is provided and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $hotelID = $_GET['id'];

    // Query to fetch hotel details
    $query = "SELECT * FROM hotel WHERE HotelID = $hotelID";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $hotel = mysqli_fetch_assoc($result);
        $hotelName = $hotel['Name'];
        $description = $hotel['Description'];
        $address = $hotel['Address'];
        $contactInfo = $hotel['ContactInfo'];
        $cityID = $hotel['CityID'];
        // You can fetch more details as needed

        // Display hotel details
        ?>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-8">
                    <h2><?php echo $hotelName; ?></h2>
                    <p><?php echo $description; ?></p>
                    <p><strong>Address:</strong> <?php echo $address; ?></p>
                    <p><strong>Contact Info:</strong> <?php echo $contactInfo; ?></p>
                    <!-- Add more details as needed -->
                </div>
                <div class="col-md-4">
                    <!-- You can display hotel images or other relevant information here -->
                    <img src="../admin/<?php echo $hotel['CardImage']; ?>" class="img-fluid" alt="<?php echo $hotelName; ?>">
                </div>
            </div>
        </div>

        <div class="facilities-container">
            <h2>Most popular facilities</h2>
            <div class="facilities">
                <div class="facility">
                    <i class="fas fa-wifi"></i>
                    <span>Free WiFi</span>
                </div>
                <div class="facility">
                    <i class="fas fa-shuttle-van"></i>
                    <span>Airport shuttle</span>
                </div>
                <div class="facility">
                    <i class="fas fa-parking"></i>
                    <span>Free parking</span>
                </div>
                <div class="facility">
                    <i class="fas fa-wheelchair"></i>
                    <span>Facilities for disabled guests</span>
                </div>
                <div class="facility">
                    <i class="fas fa-smoking-ban"></i>
                    <span>Non-smoking rooms</span>
                </div>
                <div class="facility">
                    <i class="fas fa-users"></i>
                    <span>Family rooms</span>
                </div>
            </div>
        </div>

        <?php
    } else {
        echo '<p>Hotel not found.</p>'; // Handle case where hotel ID is not found
    }
} else {
    echo '<p>Invalid hotel ID.</p>'; // Handle case where hotel ID is not provided or invalid
}

require "footer.php";
?>

 <!-- Font Awesome for icons -->
 <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<style>



.facilities-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    width: 100%;
    margin-top: 20px;
}

.facilities-container h2 {
    margin-bottom: 20px;
}

.facilities {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.facility {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    flex: 1 1 calc(50% - 20px);
    box-sizing: border-box;
}

.facility i {
    color: green;
}

.facility span {
    color: #333;
    font-size: 14px;
}

@media (max-width: 600px) {
    .facility {
        flex: 1 1 100%;
    }
}
</style>
