<?php
require "header.php";
require "connection.php"; // Adjust based on your file structure

if (!isset($_SESSION['UserID'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Retrieve userID from session
$userID = $_SESSION['UserID'];

// Get package ID from URL parameter
$packageID = isset($_GET['package']) ? intval($_GET['package']) : 0;

$user = [];
$package = [];
$dates = [];

// Fetch user details
$userQuery = "SELECT Name, email, phone FROM user WHERE UserID = ?";
$stmt = $conn->prepare($userQuery);
if ($stmt) {
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $userResult = $stmt->get_result();
    if ($userResult->num_rows > 0) {
        $user = $userResult->fetch_assoc();
    }
    $stmt->close();
}

// Fetch package details including name and price
$packageQuery = "SELECT pack_name, pack_price FROM tour_card WHERE pack_id = ?";
$stmt = $conn->prepare($packageQuery);
if ($stmt) {
    $stmt->bind_param("i", $packageID);
    $stmt->execute();
    $packageResult = $stmt->get_result();
    if ($packageResult->num_rows > 0) {
        $package = $packageResult->fetch_assoc();
    }
    $stmt->close();
}

// Get current date
$currentDate = new DateTime();

// Fetch available dates and capacity for the selected package
$datesQuery = "
    SELECT tpd.id, tpd.start_date, tpd.end_date, tpd.max_people, 
           COALESCE(SUM(pb.people_count), 0) AS booked_people
    FROM tour_package_dates tpd
    LEFT JOIN package_booking pb ON tpd.id = pb.date_range_id
    WHERE tpd.pack_id = ?
    GROUP BY tpd.id, tpd.start_date, tpd.end_date, tpd.max_people
";
$stmt = $conn->prepare($datesQuery);
if ($stmt) {
    $stmt->bind_param("i", $packageID);
    $stmt->execute();
    $datesResult = $stmt->get_result();
    while ($row = $datesResult->fetch_assoc()) {
        $startDate = new DateTime($row['start_date']);
        // Check if the start date is in the future
        if ($startDate >= $currentDate) {
            // Calculate available seats
            $row['available_seats'] = $row['max_people'] - $row['booked_people'];
            $dates[] = $row;
        }
    }
    $stmt->close();
}

$conn->close();
?>

<!-- Booking Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mb-3 pb-3">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Booking</h6>
            <h1>Book Your Package</h1>
        </div>
        <div class="row justify-content-center">
            <!-- Booking Form Column -->
            <div class="col-lg-8">
                <div class="booking-form bg-white" style="padding: 30px;">
                    <div id="success"></div>

                    <form action="booking_process.php" method="POST" name="bookingForm" id="bookingForm" novalidate="novalidate">
                        <!-- Hidden Inputs -->
                        <input type="hidden" name="userID" value="<?php echo htmlspecialchars($userID); ?>">
                        <input type="hidden" name="packageID" value="<?php echo htmlspecialchars($packageID); ?>">
                        <input type="hidden" name="message" value=""> <!-- Hidden input for additional notes -->
                        <input type="hidden" name="paymentMethod" value=""> <!-- Hidden input for payment method -->
                        <input type="hidden" name="totalPrice" id="totalPriceInput" value="0"> <!-- Hidden input for total price -->

                        <!-- User Information -->
                        <div class="form-row">
                            <div class="control-group col-sm-12">
                                <label for="firstName" class="mt-3">Name:</label>
                                <input type="text" class="form-control" id="firstName" name="firstName"
                                    value="<?php echo htmlspecialchars($user['Name'] ?? ''); ?>" required="required" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="control-group col-sm-6">
                                <label for="email" class="mt-3">Email:</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required="required" readonly />
                            </div>
                            <div class="control-group col-sm-6">
                                <label for="phone" class="mt-3">Phone:</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required="required" readonly />
                            </div>
                        </div>

                        <!-- Date Range -->
                        <div class="form-row">
                            <div class="control-group col-sm-12">
                                <label for="dateRange" class="mt-3">Select Date Range:</label>
                                <select class="form-control" id="dateRange" name="dateRange" required="required">
                                    <option value="">Select a date range</option>
                                    <?php foreach ($dates as $date): ?>
                                        <option value="<?php echo htmlspecialchars($date['id']); ?>"
                                            data-max-people="<?php echo htmlspecialchars($date['max_people']); ?>"
                                            data-available-seats="<?php echo htmlspecialchars($date['available_seats']); ?>">
                                            <?php echo htmlspecialchars($date['start_date']); ?> to
                                            <?php echo htmlspecialchars($date['end_date']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Number of People -->
                        <div class="form-row">
                            <div class="control-group col-sm-12">
                                <label for="numPeople" class="mt-3">Number of People:</label>
                                <input type="number" class="form-control" id="numPeople" name="numPeople" min="1" value="1"
                                    required="required">
                                <small class="form-text text-muted">Maximum allowed: <span id="maxPeopleText">0</span></small>
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="message" class="mt-3">Additional Notes :</label>
                            <textarea class="form-control py-3 px-4" rows="5" id="message" name="message"
                                placeholder="Additional Notes (Optional)"></textarea>
                        </div>

                        <!-- Payment Method -->
                        <div class="form-row">
                            <div class="control-group col-sm-12">
                                <label for="paymentMethod" class="mt-3">Payment Method:</label>
                                <div class="payment-options d-flex justify-content-between">
                                    <div class="payment-option">
                                        <div class="payment-card easypaisa-card" data-method="easypaisa">
                                            Easypaisa
                                        </div>
                                    </div>
                                    <div class="payment-option">
                                        <div class="payment-card jaazcash-card" data-method="jaazcash">
                                            JaazCash
                                        </div>
                                    </div>
                                    <div class="payment-option">
                                        <div class="payment-card sadapay-card" data-method="sadapay">
                                            Sadapay
                                        </div>
                                    </div>
                                    <div class="payment-option">
                                        <div class="payment-card mezaan-card" data-method="mezaan">
                                            Meezan Bank
                                        </div>
                                    </div>
                                </div>
                                <!-- Placeholder for selected payment method -->
                                <div id="selectedPaymentMethod" class="mt-3">
                                    <strong>Selected Payment Method:</strong> <span id="paymentMethodText">None</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary py-3 px-4" type="submit" id="sendMessageButton">Submit Booking</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Side Container -->
            <div class="col-lg-4">
                <div class="bg-light p-4 border rounded">
                    <h4>Package Details</h4>
                    <p><strong>Package Name:</strong> <?php echo htmlspecialchars($package['pack_name'] ?? ''); ?></p>
                    <p><strong>Price Per Person:</strong> <span id="pricePerPerson"><?php echo htmlspecialchars($package['pack_price'] ?? ''); ?></span></p>
                    <p><strong>Total Price:</strong> <span id="totalPrice">0</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Booking End -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const numPeopleInput = document.getElementById('numPeople');
    const dateRangeSelect = document.getElementById('dateRange');
    const maxPeopleText = document.getElementById('maxPeopleText');
    const totalPriceText = document.getElementById('totalPrice');
    const totalPriceInput = document.getElementById('totalPriceInput'); // Hidden input field
    const pricePerPerson = parseFloat(document.getElementById('pricePerPerson').textContent);

    // Set the default value for number of people
    numPeopleInput.value = 1;

    // Update max people display and total price calculation
    dateRangeSelect.addEventListener('change', function () {
        const selectedOption = dateRangeSelect.options[dateRangeSelect.selectedIndex];
        const maxPeople = parseInt(selectedOption.getAttribute('data-max-people'), 10);
        const availableSeats = parseInt(selectedOption.getAttribute('data-available-seats'), 10);

        maxPeopleText.textContent = maxPeople;
        if (availableSeats < 1) {
            numPeopleInput.value = 1;
        }

        // Calculate total price
        const numPeople = parseInt(numPeopleInput.value, 10);
        const totalPrice = pricePerPerson * numPeople;
        totalPriceText.textContent = totalPrice;
        totalPriceInput.value = totalPrice; // Update hidden input
    });

    // Update total price when number of people changes
    numPeopleInput.addEventListener('input', function () {
        const numPeople = parseInt(numPeopleInput.value, 10);
        const selectedOption = dateRangeSelect.options[dateRangeSelect.selectedIndex];
        const availableSeats = parseInt(selectedOption.getAttribute('data-available-seats'), 10);

        if (numPeople > availableSeats) {
            alert('Number of people exceeds available seats.');
            numPeopleInput.value = availableSeats;
        }

        const totalPrice = pricePerPerson * numPeople;
        totalPriceText.textContent = totalPrice.toFixed(2);
        totalPriceInput.value = totalPrice.toFixed(2); // Update hidden input
    });

    // Handle payment method selection
    document.querySelectorAll('.payment-card').forEach(card => {
        card.addEventListener('click', function () {
            document.querySelectorAll('.payment-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            document.getElementById('selectedPaymentMethod').querySelector('#paymentMethodText').textContent = this.textContent;
            document.getElementsByName('paymentMethod')[0].value = this.getAttribute('data-method');
        });
    });
});
</script>








<!-- Styles for Payment Options -->
<style>
    /* General Styles */
    .payment-options {
        display: flex;
        flex-wrap: wrap;
        /* Allow wrapping on smaller screens */
        gap: 10px;
        /* Add space between payment options */
    }

    .payment-option {
        flex: 1;
        min-width: 150px;
        /* Minimum width for each payment option */
        max-width: 150px;
        /* Maximum width for each payment option */
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 5px;
        padding: 10px;
        text-align: center;
    }

    .payment-card {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .payment-card.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }
</style>



<!-- Styles for Payment Options -->
<style>
    /* General Styles */
    .payment-options {
        display: flex;
        flex-wrap: wrap;
        /* Allow wrapping on smaller screens */
        gap: 10px;
        /* Add space between payment options */
    }

    .payment-option {
        flex: 1;
        min-width: 150px;
        /* Minimum width for each payment option */
        max-width: 150px;
        /* Maximum width for each payment option */
        height: 80px;
        /* Height for each payment option */
        cursor: pointer;
        transition: transform 0.2s, background-color 0.2s;
        /* Smooth transformation and color change */
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 5px;
        margin: 5px;
        /* Space around each payment option */
    }

    .payment-option:hover {
        transform: scale(1.03);
        /* Slightly scale up on hover */
    }

    .payment-card {
        color: white;
        cursor: pointer;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-align: center;
        margin: 5px;
        /* Space inside each payment card */
    }

    .payment-card.active {
        border-color: #007bff;
        background-color: #e7f0ff;
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

    /* Validation Styles */
    .is-invalid {
        border-color: #dc3545;
    }

    .is-invalid:focus {
        box-shadow: 0 0 0 .2rem rgba(220, 53, 69, .25);
    }

    /* Responsive Styles */
    @media (max-width: 1200px) {
        .payment-option {
            min-width: 120px;
            /* Adjust minimum width for medium screens */
            max-width: 120px;
            /* Adjust maximum width for medium screens */
            height: 70px;
            /* Adjust height for medium screens */
        }
    }

    @media (max-width: 992px) {
        .payment-options {
            flex-direction: column;
            /* Stack payment options vertically on tablets */
            align-items: center;
        }

        .payment-option {
            min-width: 120px;
            /* Adjust minimum width for tablets */
            max-width: 120px;
            /* Adjust maximum width for tablets */
            height: 70px;
            /* Adjust height for tablets */
            margin-bottom: 10px;
            /* Space between stacked payment options */
        }
    }

    @media (max-width: 576px) {
        .payment-option {
            min-width: 100px;
            /* Adjust minimum width for very small screens */
            max-width: 100px;
            /* Adjust maximum width for very small screens */
            height: 60px;
            /* Adjust height for very small screens */
            font-size: 0.9rem;
            /* Adjust font size for very small screens */
        }

        .payment-card {
            padding: 4px;
            /* Reduce padding for very small screens */
        }
    }

    #sendMessageButton {
        width: 100%;
        /* Increase the width to fill the container */
        padding: 15px;
        /* Increase padding for a larger button */
        margin-top: 20px;
        /* Move the button down a bit */
        font-size: 1.2rem;
        /* Adjust font size if needed */
    }
</style>