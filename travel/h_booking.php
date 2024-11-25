<?php
require "connection.php";
require "header.php";

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    echo '<div class="container mt-5">';
    echo '<div class="alert alert-warning">You need to <a href="login.php">log in</a> to book a room.</div>';
    echo '</div>';
    require "footer.php";
    exit();
}

$userID = $_SESSION['UserID'];

// Fetch user details
$qryUser = "SELECT name, email, phone FROM user WHERE UserID = ?";
$stmtUser = $conn->prepare($qryUser);
$stmtUser->bind_param("i", $userID);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$user = $resultUser->fetch_assoc();
$name = $user['name'] ?? '';
$email = $user['email'] ?? '';
$phone = $user['phone'] ?? '';

// Check if parameters are set
if (isset($_GET['hotelID']) && isset($_GET['roomID']) && isset($_GET['hotelName']) && isset($_GET['description'])) {
    $hotelID = intval($_GET['hotelID']);
    $roomID = intval($_GET['roomID']);
    $hotelName = htmlspecialchars($_GET['hotelName']);
    $description = htmlspecialchars($_GET['description']);

    // Fetch hotel details
    $qryHotel = "SELECT Name FROM hotel WHERE HotelID = ?";
    $stmtHotel = $conn->prepare($qryHotel);
    $stmtHotel->bind_param("i", $hotelID);
    $stmtHotel->execute();
    $resultHotel = $stmtHotel->get_result();
    $hotel = $resultHotel->fetch_assoc();
    $hotelNameFromDB = $hotel['Name'] ?? 'Unknown Hotel';

    // Fetch room facilities
    $qryFacilities = "
        SELECT hf.facility_name
        FROM hr_facilities hf
        JOIN hotel_room_facilities hrf ON hf.facility_id = hrf.facility_id
        WHERE hrf.room_id = ?";
    $stmtFacilities = $conn->prepare($qryFacilities);
    $stmtFacilities->bind_param("i", $roomID);
    $stmtFacilities->execute();
    $resultFacilities = $stmtFacilities->get_result();
    $facilities = [];
    while ($row = $resultFacilities->fetch_assoc()) {
        $facilities[] = $row;
    }

    // Fetch room prices
    $qryPrices = "
        SELECT hr.room_id, hr.room_type, hr.description, hr.price, rt.TypeName
        FROM hotel_rooms hr
        JOIN room_types rt ON hr.room_type = rt.RoomTypeID
        WHERE hr.room_id = ?";
    $stmtPrices = $conn->prepare($qryPrices);
    $stmtPrices->bind_param("i", $roomID);
    $stmtPrices->execute();
    $resultPrices = $stmtPrices->get_result();
    $prices = [];
    while ($row = $resultPrices->fetch_assoc()) {
        $prices[] = $row;
    }
} else {
    echo "Invalid parameters.";
    exit();
}
?>

<div class="container mt-5">
    <!-- Booking Information Section -->
    <div class="booking-information mb-5">
        <h2>Booking Information</h2>
        <form id="bookingForm" action="h_bookingaction.php" method="post" onsubmit="return validateForm()">
            <input type="hidden" name="hotelID" value="<?php echo htmlspecialchars($hotelID); ?>">
            <input type="hidden" name="roomID" value="<?php echo htmlspecialchars($roomID); ?>">

            <div class="mb-3">
                <label for="hotelName" class="form-label">Hotel Name</label>
                <input type="text" class="form-control" id="hotelName" name="hotelName" value="<?php echo htmlspecialchars($hotelName); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" readonly><?php echo htmlspecialchars($description); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="facilities" class="form-label">Facilities</label>
                <ul class="list-group">
                    <?php foreach ($facilities as $facility): ?>
                        <li class="list-group-item"><?php echo htmlspecialchars($facility['facility_name']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="mb-3">
                <label for="room-prices" class="form-label">Room Prices</label>
                <?php foreach ($prices as $price): ?>
                    <div class="mb-3">
                        <h5>Room Type: <?php echo htmlspecialchars($price['TypeName']); ?></h5>
                        <p>Description: <?php echo htmlspecialchars($price['description']); ?></p>
                        <p>Price: PKR <?php echo htmlspecialchars($price['price']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="row">
                <!-- Left Side: Booking Form -->
                <div class="col-md-6">
                    <div class="booking-form-box">
                        <h4>Booking Form</h4>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>

                        <div class="mb-3">
                            <label for="postalCode" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="postalCode" name="postalCode" required>
                        </div>

                        <!-- Check-in and Check-out Dates -->
                        <div class="mb-3">
                            <label for="checkinDate" class="form-label">Check-in Date</label>
                            <input type="date" class="form-control" id="checkinDate" name="checkinDate" required>
                        </div>

                        <div class="mb-3">
                            <label for="checkoutDate" class="form-label">Check-out Date</label>
                            <input type="date" class="form-control" id="checkoutDate" name="checkoutDate" required>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Payment Methods -->
                <div class="col-md-6">
                    <div class="payment-methods">
                        <h4>Payment Methods</h4>
                        <div class="payment-options">
                            <div class="payment-option" onclick="selectPaymentMethod('Easypaisa')">
                                <div class="payment-card easypaisa-card">
                                    <span class="card-name">Easypaisa</span>
                                    <span class="card-icon">💵</span>
                                </div>
                            </div>
                            <div class="payment-option" onclick="selectPaymentMethod('JaazCash')">
                                <div class="payment-card jaazcash-card">
                                    <span class="card-name">JaazCash</span>
                                    <span class="card-icon">💰</span>
                                </div>
                            </div>
                            <div class="payment-option" onclick="selectPaymentMethod('Sadapay')">
                                <div class="payment-card sadapay-card">
                                    <span class="card-name">Sadapay</span>
                                    <span class="card-icon">💳</span>
                                </div>
                            </div>
                            <div class="payment-option" onclick="selectPaymentMethod('Meezan Bank')">
                                <div class="payment-card mezaan-card">
                                    <span class="card-name">Meezan Bank</span>
                                    <span class="card-icon">🏦</span>
                                </div>
                            </div>
                        </div>
                        <!-- Display selected payment method -->
                        <div class="selected-payment-method mt-3">
                            <label for="paymentMethod" class="form-label">Selected Payment Method</label>
                            <input type="text" class="form-control" id="paymentMethod" name="paymentMethod" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Submit Booking</button>
            </div>
        </form>
    </div>
</div>

<!-- Include JavaScript to handle payment selection -->
<script>
function selectPaymentMethod(method) {
    document.getElementById('paymentMethod').value = method;
}

// Simple form validation function
function validateForm() {
    const paymentMethod = document.getElementById('paymentMethod').value;
    if (paymentMethod === '') {
        alert('Please select a payment method.');
        return false;
    }
    return true;
}
</script>



<script>
    // Function to set minimum date for check-in and check-out fields
    function setMinDates() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('checkinDate').setAttribute('min', today);
    }

    // Function to validate dates and form fields
    function validateForm() {
        const checkinDate = document.getElementById('checkinDate').value;
        const checkoutDate = document.getElementById('checkoutDate').value;
        const city = document.getElementById('city').value;
        const postalCode = document.getElementById('postalCode').value;
        const paymentMethod = document.getElementById('paymentMethod').value;

        // Validate dates
        if (checkinDate && checkoutDate && new Date(checkoutDate) <= new Date(checkinDate)) {
            alert("Check-out date must be after the Check-in date.");
            return false;
        }

        // Validate City (only alphabets)
        if (!/^[A-Za-z\s]+$/.test(city)) {
            alert("City must contain only alphabets.");
            return false;
        }

        // Validate Postal Code (exactly 5 digits)
        if (!/^\d{5}$/.test(postalCode)) {
            alert("Postal Code must be exactly 5 digits.");
            return false;
        }

        // Validate Payment Method
        if (!paymentMethod) {
            alert("Please select a payment method.");
            return false;
        }

        return true;
    }

    // Function to set minimum date for check-out based on check-in date
    function updateCheckoutMinDate() {
        const checkinDate = document.getElementById('checkinDate').value;
        document.getElementById('checkoutDate').setAttribute('min', checkinDate);
    }

    // Function to select payment method
    function selectPaymentMethod(method) {
        document.getElementById('paymentMethod').value = method;
    }

    // Set min dates on page load
    window.onload = function() {
        setMinDates();
        document.getElementById('checkinDate').addEventListener('change', updateCheckoutMinDate);
    };
</script>

<?php
require "footer.php";
?>






<style>
    .booking-form-box, .payment-methods {
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fff;
    }

    .payment-options {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.payment-option {
    flex: 1;
    min-width: 200px; /* Set a minimum width */
    max-width: 200px; /* Ensure all cards have the same width */
    height: 100px; /* Set a fixed height */
    cursor: pointer;
    transition: transform 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.payment-option:hover {
    transform: scale(1.05);
}

.payment-card {
    padding: 10px;
    border-radius: 8px;
    text-align: center;
    color: white;
    font-weight: bold;
    width: 100%; /* Ensure the card fills the container */
    height: 100%; /* Ensure the card fills the container */
    display: flex;
    align-items: center;
    justify-content: center;
}

.easypaisa-card {
    background: linear-gradient(to right, #00bfae, #002e6d);
}

.jaazcash-card {
    background: linear-gradient(to right, #f44d27, #f5e00b);
}

.sadapay-card {
    background: linear-gradient(to right, #007bff, #e14d2a);
}

.mezaan-card {
    background: linear-gradient(to right, #008000, #8a2d6c);
}

.payment-details input {
    width: 100%;
}

@media (max-width: 768px) {
    .payment-options {
        flex-direction: column;
        align-items: center;
    }

    .payment-option {
        margin-bottom: 10px;
    }
}
</style>