<?php
require "header.php";
require "connection.php"; // Adjust based on your file structure

// Retrieve booking details from session
$booking = isset($_SESSION['booking']) ? $_SESSION['booking'] : null;

if (!$booking) {
    echo "<div class='container py-5'><div class='alert alert-danger'>No booking details found.</div></div>";
    require "footer.php";
    exit();
}

// Fetch additional details if needed
$package = [];
$dates = [];
if ($booking) {
    // Fetch package details
    $packageQuery = "
    SELECT 
        tc.pack_name, 
        tc.pack_price, 
        td.days AS num_days 
    FROM 
        tour_card AS tc
    JOIN 
        t_days AS td 
    ON 
        tc.day_id = td.day_id 
    WHERE 
        tc.pack_id = ?
";
    $stmt = $conn->prepare($packageQuery);
    if ($stmt) {
        $stmt->bind_param("i", $booking['packageID']);
        $stmt->execute();
        $packageResult = $stmt->get_result();
        
        if ($packageResult->num_rows > 0) {
            $package = $packageResult->fetch_assoc();
        } else {
            echo "<div class='container py-5'><div class='alert alert-warning'>Package details not found.</div></div>";
        }
        
        $stmt->close();
    } else {
        echo "<div class='container py-5'><div class='alert alert-danger'>Error preparing package query.</div></div>";
    }

    // Fetch date range
    $datesQuery = "SELECT start_date, end_date FROM tour_package_dates WHERE id = ?";
    $stmt = $conn->prepare($datesQuery);
    if ($stmt) {
        $stmt->bind_param("i", $booking['dateRange']);
        $stmt->execute();
        $datesResult = $stmt->get_result();
        
        if ($datesResult->num_rows > 0) {
            $dates = $datesResult->fetch_assoc();
        } else {
            echo "<div class='container py-5'><div class='alert alert-warning'>Date range details not found.</div></div>";
        }
        
        $stmt->close();
    } else {
        echo "<div class='container py-5'><div class='alert alert-danger'>Error preparing dates query.</div></div>";
    }
}

$conn->close();
?>

<div class='container py-5'>
    <?php if ($booking['status'] === 'confirmed'): ?>
        <div class='alert alert-success'>Your booking is confirmed. Thank you for booking a package!</div>
    <?php endif; ?>

    <div class='bg-light p-4 border rounded'>
        <h4>Booking Details</h4>
        <p><strong>Package Name:</strong> <?php echo htmlspecialchars($booking['packageName'] ?? 'N/A'); ?></p>
        <p><strong>Total Price:</strong> <?php echo htmlspecialchars(number_format($booking['totalPrice'] ?? 0, 2)); ?></p>
        <p><strong>Date Range:</strong> <?php echo htmlspecialchars($booking['startDate'] ?? 'N/A'); ?> to <?php echo htmlspecialchars($booking['endDate'] ?? 'N/A'); ?></p>
        <p><strong>Number of Days:</strong> <?php echo htmlspecialchars($package['num_days'] ?? 'N/A'); ?></p>
        <p><strong>Number of People:</strong> <?php echo htmlspecialchars($booking['peopleCount'] ?? '0'); ?></p>
        <p><strong>Additional Notes:</strong> <?php echo htmlspecialchars($booking['message'] ?? 'N/A'); ?></p>

        <?php 
        if (isset($_SESSION['email_sent'])) {
            echo '<p>' . $_SESSION['email_sent'] . '</p>';
            unset($_SESSION['email_sent']); // Clear the message after displaying
        }
        ?>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var form = document.getElementById('paymentForm');
        if (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent the form from submitting immediately
                var formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    body: formData
                }).then(response => response.text()).then(text => {
                    // After successful payment, show the confirmation alert
                    alert("Your booking is confirmed. Thank you for booking a package!");
                    // Redirect to the booking status page or update the page content
                    window.location.href = "booking_status.php"; // Redirect to the same page to refresh details
                }).catch(error => {
                    console.error('Error:', error);
                });
            });
        }
    });
</script>

<?php

require "footer.php";
?>
