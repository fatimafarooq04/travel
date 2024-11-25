<?php
require "connection.php";
require "header.php";

// Ensure hotel ID is provided and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $hotelID = $_GET['id'];

    // Prepared statement to fetch hotel details
    $query = "SELECT * FROM hotel WHERE HotelID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $hotelID); // Bind the hotel ID as an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $hotel = $result->fetch_assoc();
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
                <!-- Image Carousel and Hotel Details -->
                <div class="col-md-6 mb-4">
                    <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="../admin/<?php echo $hotel['Image1']; ?>" class="d-block w-100" alt="Image 1">
                            </div>
                            <div class="carousel-item">
                                <img src="../admin/<?php echo $hotel['Image2']; ?>" class="d-block w-100" alt="Image 2">
                            </div>
                            <div class="carousel-item">
                                <img src="../admin/<?php echo $hotel['Image3']; ?>" class="d-block w-100" alt="Image 3">
                            </div>
                            <!-- Add more carousel items as needed -->
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <!-- Hotel Details -->
                <div class="col-md-6">
                    <h3><?php echo $hotelName; ?></h3>
                    <p><strong>Address:</strong> <?php echo $address; ?></p>
                    <p><strong>Contact Info:</strong> <?php echo $contactInfo; ?></p>



                </div>
            </div>

            <!-- Hotel History Section -->
            <div class="row mt-5">
                <div class="col-md-12">
                    <h2>Hotel History</h2>
                    <p><?php echo $description; ?></p>
                </div>
            </div>

            <div class="container mt-5">
                <!-- Hotel Facilities Section -->
                <div class="row mt-5">
                    <div class="col-md-12">
                        <h2>Hotel Facilities</h2>
                        <div class="facilities">
                            <?php
                            // Query to fetch facilities associated with the hotel
                            $facilityQuery = "SELECT f.FacilityName
    FROM facility f
    INNER JOIN hotel_facility hf ON f.FacilityID = hf.FacilityID
    WHERE hf.HotelID = $hotelID";
                            $result = mysqli_query($conn, $facilityQuery);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <div class="facility">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span><?php echo $row['FacilityName'] ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Availability Check Section -->
            <!-- <div class="row availability">
                <div class="col-md-12">
                    <h2>Check Availability</h2>
                    <form action="booking.php" method="post">
                        <div class="form-group">
                            <label for="check-in">Check-in Date</label>
                            <input type="date" class="form-control" id="check-in" name="check-in" required>
                        </div>
                        <div class="form-group">
                            <label for="check-out">Check-out Date</label>
                            <input type="date" class="form-control" id="check-out" name="check-out" required>
                        </div>
                        <button type="submit" class="btn-search">Search</button>
                    </form>
                </div>
            </div> -->

            <!-- Room Details Table -->
            <div class="row mt-5">
                <div class="col-md-12">
                    <h2>Available Rooms</h2>
                    <table class="room-table">
                        <thead>
                            <tr>
                                <th>Room Type</th>
                                <th>Description</th>
                                <th>Room Size</th>
                                <th>Guest Capacity</th>
                                <th>Policy</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $qry = "
                    SELECT hr.room_id, rt.TypeName AS room_type, hr.description, hr.room_size, hr.guest_capacity, hr.price, hr.policy 
                    FROM hotel_rooms hr 
                    JOIN room_types rt ON hr.room_type = rt.RoomTypeID";
                            $result = mysqli_query($conn, $qry);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['room_type'] ?></td>
                                    <td><?php echo $row['description'] ?></td>
                                    <td><?php echo $row['room_size'] ?></td>
                                    <td><?php echo $row['guest_capacity'] ?></td>
                                    <td><?php echo $row['policy'] ?></td>
                                    <td>
                                        <button class="btn-show-prices" data-room-id="<?php echo $row['room_id']; ?>"
                                            data-bs-toggle="modal" data-bs-target="#priceModal">
                                            Show Prices
                                        </button>
                                    </td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Modal Structure -->
            <div class="modal fade" id="priceModal" tabindex="-1" aria-labelledby="priceModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="priceModalLabel">Room Prices</h5>
                        </div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <h4 id="hotel-name"><?php echo $hotelName; ?></h4>
                            <p id="hotel-description"><?php echo $description; ?></p>
                            <p><strong>Facilities:</strong></p>
                            <div class="facilities-modal" id="facilities-list">
                                <!-- Facilities will be loaded here via AJAX -->
                            </div>
                            <div id="room-prices" class="mt-5">
                                <!-- Room prices will be loaded here via AJAX -->
                            </div>
                            <a id="book-now" href="#" class="btn btn-primary my-4">Book Now</a>

                        </div>


                    </div>
                </div>
            </div>


        </div>
        </div>
        </div>



        <?php
    } else {
        echo "Hotel not found.";
    }

    $stmt->close();
} else {
    echo "Invalid hotel ID.";
}

require "footer.php";
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var priceModal = new bootstrap.Modal(document.getElementById('priceModal'));

        document.querySelectorAll('.btn-show-prices').forEach(button => {
            button.addEventListener('click', function () {
                var roomId = this.getAttribute('data-room-id');
                var hotelName = document.getElementById('hotel-name').innerText;
                var description = document.getElementById('hotel-description').innerText;

                // Fetch facilities for the selected room
                fetch('get_room_facilities.php?room_id=' + roomId)
                    .then(response => response.json())
                    .then(data => {
                        var facilitiesList = document.getElementById('facilities-list');
                        facilitiesList.innerHTML = ''; // Clear existing facilities

                        data.forEach(facility => {
                            var facilityDiv = document.createElement('div');
                            facilityDiv.className = 'facility-modal';
                            facilityDiv.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>${facility.facility_name}</span>
                    `;
                            facilitiesList.appendChild(facilityDiv);
                        });
                    });

                // Fetch room prices for the selected room
                fetch('get_room_prices.php?room_id=' + roomId)
                    .then(response => response.json())
                    .then(data => {
                        var roomPrices = document.getElementById('room-prices');
                        roomPrices.innerHTML = ''; // Clear existing room prices

                        data.forEach(room => {
                            var roomPriceDiv = document.createElement('div');
                            roomPriceDiv.className = 'room-price';
                            roomPriceDiv.innerHTML = `
                        <h5>Room Type: ${room.room_type}</h5>
                        <p>Description: ${room.description}</p>
                        <p>Price: ${room.price}</p>
                    `;
                            roomPrices.appendChild(roomPriceDiv);

                            // Update the "Book Now" button with query parameters
                            var bookNowBtn = document.getElementById('book-now');
                            bookNowBtn.href = `h_booking.php?hotelID=${<?php echo $hotelID; ?>}&roomID=${room.room_id}&hotelName=${encodeURIComponent(hotelName)}&description=${encodeURIComponent(description)}`;
                        });

                        // Show the modal
                        priceModal.show();
                    });
            });
        });
    });




</script>




<style>
    /* Custom styles for facilities in the modal */
    .facilities-modal {
        display: flex;
        flex-wrap: wrap;
        /* Allow items to wrap to the next line if needed */
        gap: 10px;
        /* Space between items */
        margin: 0;
        /* Remove margin to ensure proper alignment */
        padding: 0;
        /* Remove padding to ensure proper alignment */
    }

    /* Add space between facilities and room prices */
    .modal-body {
        padding-top: 20px;
        /* Add top padding to create space above the room prices section */
    }

    .facility-modal {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 8px;
        background-color: #f0f8ff;
        /* Light background color */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Subtle shadow */
        max-width: 200px;
        /* Restrict maximum width */
        box-sizing: border-box;
        /* Include padding and border in width/height calculations */
    }

    .facility-modal svg {
        width: 30px;
        height: 30px;
        margin-right: 10px;
        stroke: #28a745;
        /* Green color for SVG icons */
        stroke-width: 2;
        /* Set stroke width */
    }

    .facility-modal span {
        font-size: 16px;
        color: #333;
        /* Dark text color */
    }

    /* Custom styles for carousel */
    #imageCarousel .carousel-item img {
        height: 400px;
        /* Adjust the height as needed */
        object-fit: cover;
        /* Maintain aspect ratio */
    }

    /* Hide the next and previous buttons */
    .carousel-control-prev,
    .carousel-control-next {
        display: none;
    }

    /* Custom styles for facilities */
    .facilities {
        display: flex;
        flex-wrap: wrap;
        /* Allows items to wrap to the next line if needed */
        gap: 20px;
        /* Space between items */
        justify-content: flex-start;
        /* Align items to the start of the container */
        margin: 0;
        /* Remove margin to ensure proper alignment */
        padding: 0;
        /* Remove padding to ensure proper alignment */
    }

    .facility {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 8px;
        background-color: #f0f8ff;
        /* Light background color */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Subtle shadow */
        flex: 1 1 auto;
        /* Allow items to grow and shrink, taking available space */
        max-width: 200px;
        /* Restrict maximum width */
        margin: 10px;
        /* Margin around each item for spacing */
        box-sizing: border-box;
        /* Include padding and border in width/height calculations */
    }

    .facility svg {
        width: 30px;
        height: 30px;
        margin-right: 15px;
        stroke: #28a745;
        /* Green color for SVG icons */
        stroke-width: 2;
        /* Set stroke width */
    }

    .facility span {
        font-size: 16px;
        color: #333;
        /* Dark text color */
    }

    /* Responsive styles */
    @media (max-width: 767.98px) {
        .facility {
            flex: 1 1 100%;
            /* Full width on small screens */
            max-width: none;
            /* Remove max-width restriction */
            margin: 10px 0;
            /* Add margin for vertical spacing on small screens */
        }

        .modal-body {
            padding-top: 10px;
            /* Adjust top padding for small screens */
        }
    }

    /* Custom styles for availability section */
    .availability {
        margin-top: 40px;
    }

    .availability h2 {
        margin-bottom: 20px;
    }

    .availability .form-group {
        margin-bottom: 15px;
    }

    .availability .form-control {
        border-radius: 8px;
    }

    .availability .btn-search {
        background-color: #28a745;
        /* Green color for the search button */
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
    }

    /* Custom styles for the room table */
    .room-table {
        margin-top: 30px;
        width: 100%;
        border-collapse: collapse;
    }

    .room-table th,
    .room-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .room-table th {
        background-color: #f8f9fa;
    }

    .room-table button {
        background-color: #28a745;
        /* Green color for "Show Prices" button */
        color: white;
        border: none;
        border-radius: 8px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .room-table button:hover {
        background-color: #218838;
        /* Darker green on hover */
    }

    /* Custom styles for modal */
    .modal-dialog {
        max-width: 80%;
        /* Adjust this percentage as needed */
        margin: 1.75rem auto;
        /* Center the modal */
    }

    .modal-content {
        border-radius: 8px;
        /* Maintain rounded corners */
        padding: 20px;
        /* Add padding for better spacing */
    }

    /* Responsive styles */
    @media (max-width: 767.98px) {
        .modal-dialog {
            max-width: 90%;
            /* Increase max-width for smaller screens */
        }
    }

    @media (min-width: 768px) {

        /* Responsive styles for medium to large screens */
        #imageCarousel .carousel-item img {
            height: 400px;
            /* Restore image height on larger screens */
        }
    }

    .guest-reviews {
        margin-top: 40px;
    }

    .review-item {
        border-bottom: 1px solid #ddd;
        padding: 15px 0;
    }

    .review-item:last-child {
        border-bottom: none;
    }

    .review-item .reviewer-name {
        font-weight: bold;
        color: #333;
    }

    .review-item .review-date {
        color: #888;
        font-size: 14px;
    }

    .review-item .review-text {
        margin-top: 10px;
    }

    .review-form textarea {
        width: 100%;
        border-radius: 8px;
        padding: 10px;
        border: 1px solid #ddd;
    }

    .review-form button {
        background-color: #28a745;
        /* Green color for the submit button */
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        margin-top: 10px;
    }

    /* Responsive styles */
    @media (max-width: 767.98px) {

        /* Stack columns on smaller screens */
        .carousel-inner img {
            height: auto;
            /* Adjust image height */
        }

        .facility {
            flex: 1 1 100%;
            /* Full width on small screens */
            max-width: none;
            /* Remove max-width restriction */
        }

        .availability .form-group {
            margin-bottom: 10px;
        }

        .review-form button {
            width: 100%;
            /* Full width for submit button */
        }

        .room-table th,
        .room-table td {
            font-size: 14px;
            /* Adjust font size for small screens */
        }

        .room-table {
            display: block;
            /* Make table scrollable on small screens */
            overflow-x: auto;
        }
    }
</style>