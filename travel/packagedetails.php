<?php
require 'connection.php';
require 'header.php';

$pack_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($pack_id > 0) {
    // Fetch package details
    $qry = "
        SELECT 
            p.pack_id, 
            p.pack_name, 
            p.pack_price, 
            p.CityID, 
            p.HotelID, 
            c.CityName, 
            h.Name, 
            p.pack_img
        FROM 
            tour_card p
        LEFT JOIN 
            city c ON p.CityID = c.CityID
        LEFT JOIN 
            hotel h ON p.HotelID = h.HotelID
        WHERE 
            p.pack_id = ?
    ";

    $stmt = $conn->prepare($qry);
    $stmt->bind_param('i', $pack_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $package = [];

    if ($result && $result->num_rows > 0) {
        $package = $result->fetch_assoc();
    } else {
        echo "Package not found.";
        exit;
    }

    // Fetch itineraries
    $qry_itinerary = "
        SELECT 
            d.days, 
            pi.Description AS day_description
        FROM 
            package_itinerary pi
        LEFT JOIN 
            t_days d ON pi.DayID = d.day_id
        WHERE 
            pi.PackID = ?
        ORDER BY 
            d.days
    ";

    $stmt_itinerary = $conn->prepare($qry_itinerary);
    $stmt_itinerary->bind_param('i', $pack_id);
    $stmt_itinerary->execute();
    $result_itinerary = $stmt_itinerary->get_result();

    $itineraries = [];

    if ($result_itinerary && $result_itinerary->num_rows > 0) {
        while ($row = $result_itinerary->fetch_assoc()) {
            $itineraries[] = $row;
        }
    }

    // Fetch date ranges and calculate remaining people
    $qry_dates = "
        SELECT 
            pd.id, 
            pd.pack_id, 
            pd.start_date, 
            pd.end_date, 
            pd.max_people,
            COALESCE(SUM(pb.people_count), 0) AS total_booked
        FROM 
            tour_package_dates pd
        LEFT JOIN 
            package_booking pb ON pd.id = pb.date_range_id
        WHERE 
            pd.pack_id = ?
        GROUP BY 
            pd.id
    ";

    $stmt_dates = $conn->prepare($qry_dates);
    $stmt_dates->bind_param('i', $pack_id);
    $stmt_dates->execute();
    $result_dates = $stmt_dates->get_result();

    $date_ranges = [];

    if ($result_dates && $result_dates->num_rows > 0) {
        while ($row = $result_dates->fetch_assoc()) {
            $row['remaining_people'] = $row['max_people'] - $row['total_booked'];
            $date_ranges[] = $row;
        }
    }
} else {
    echo "Invalid package ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Details</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS -->
    <style>
        .right {
            display: flex;
            flex-wrap: wrap;
        }

        .package-details {
            flex: 1;
            margin-right: 20px; 
            
        }

        .date-availability {
            width: 300px; /* Adjust width as needed */
        }

        .date-availability ul {
            list-style-type: none;
            padding: 0;
        }

        .date-availability li {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .date-availability li:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container right mt-5">
        <div class="package-details">
            <h1>Tour Packages: <?php echo htmlspecialchars($package['pack_name']); ?> in <?php echo htmlspecialchars($package['CityName']); ?></h1>

            <section class="package">
                <div class="package-details">
                    <h3>Accommodation</h3>
                    <p>Hotel Name: <?php echo htmlspecialchars($package['Name']); ?></p>
                    <p>Facilities: Free Wi-Fi, Breakfast included, Gym, Pool</p>

                    <h3>Itinerary</h3>
                    <ul>
                        <?php foreach ($itineraries as $itinerary): ?>
                            <li><strong>Day <?php echo htmlspecialchars($itinerary['days']); ?>:</strong> <?php echo htmlspecialchars($itinerary['day_description']); ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <h3>Estimated Budget</h3>
                    <p>Total: PKR <?php echo number_format($package['pack_price'], 0); ?></p>

                    <?php
                    // Check if the user is logged in
                    $isLoggedIn = isset($_SESSION['UserID']); // Replace 'UserID' with your session variable that tracks login status
                    $packageId = htmlspecialchars($package['pack_id']);
                    ?>

                    <!-- Conditionally display the "Book Now" link -->
                    <?php if ($isLoggedIn): ?>
                        <a href="booking.php?package=<?php echo $packageId; ?>" class="book-now">Book Now</a>
                    <?php else: ?>
                        <a href="login.php" class="book-now">Log in to Book</a>
                    <?php endif; ?>
                </div>
            </section>
        </div>

        <div class="date-availability" style="margin-top:120px;">
            <h3>Date Availability</h3>
            <ul>
                <?php foreach ($date_ranges as $date_range): ?>
                    <li>
                        <strong>From:</strong> <?php echo htmlspecialchars($date_range['start_date']); ?> 
                        <strong>To:</strong> <?php echo htmlspecialchars($date_range['end_date']); ?> 
                        <strong>Available Slots:</strong> <?php echo htmlspecialchars($date_range['remaining_people']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="row pb-3">
            <h1 class="text-center w-100">Perfect Tour Packages</h1>
        </div>
        <div class="row">
            <?php
            // Modify query to select 3 random packages
            $query = "SELECT p.pack_id, p.pack_name, p.day_id, p.pack_img, p.pack_price, p.CityID, c.CityName, d.days
                      FROM tour_card p
                      LEFT JOIN city c ON p.CityID = c.CityID
                      LEFT JOIN t_days d ON p.day_id = d.day_id
                      ORDER BY RAND() LIMIT 3";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $pack_id = $row['pack_id'];
                    $day_id = $row['day_id'];
                    $days = $row['days'];
                    $pack_img = $row['pack_img'];
                    $pack_price = $row['pack_price'];
                    $CityID = $row['CityID'];
                    $CityName = $row['CityName'];
                    $pack_name = $row['pack_name'];
            ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="bg-white package d-flex flex-column" data-city="<?php echo htmlspecialchars($CityName); ?>" data-price="<?php echo htmlspecialchars($pack_price); ?>">
                    <img class="img-fluid" src="../admin/<?php echo htmlspecialchars($pack_img); ?>" alt="">
                    <div class="p-4 flex-grow-1">
                        <div class="d-flex justify-content-between mb-3">
                            <small class="m-0"><i class="fa fa-map-marker-alt text-primary mr-2"></i><?php echo htmlspecialchars($CityName); ?></small>
                            <small class="m-0"><i class="fa fa-calendar-alt text-primary mr-2"></i><?php echo htmlspecialchars($days); ?> days</small>
                        </div>
                        <a class="h5 text-decoration-none" href="packagedetails.php?id=<?php echo htmlspecialchars($pack_id); ?>"><?php echo htmlspecialchars($pack_name); ?> </a>
                        <div class="border-top mt-4 pt-4">
                            <div class="d-flex justify-content-between">
                                <h5 class="m-0">PKR <?php echo htmlspecialchars($pack_price); ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 d-flex justify-content-between">
                        <a href="packagedetails.php?id=<?php echo htmlspecialchars($pack_id); ?>" class="btn btn-sm btn-primary">View Details</a>
                        <a href="booking.php?id=<?php echo htmlspecialchars($pack_id); ?>" class="btn btn-sm btn-primary">Book Now</a>
                    </div>
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

    <?php require 'footer.php'; ?>
</body>
</html>

</html>


<style>
/* General Styles */


h1, h2 {
    color: #333;
}

.container {
    width: 80%;
    margin: auto;
    overflow: hidden;
}

/* Card Styles */
.package {
    border: 1px solid #ddd;
    margin: 20px; /* Increased margin to create space between cards */
    padding: 20px;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease; /* Smooth scaling effect */
}

.package:hover {
    transform: scale(1.02); /* Slightly enlarge the card on hover */
}

.package img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

.package-details ul {
    list-style-type: none;
    padding: 0;
}

.package-details li {
    padding: 5px 0;
}

.book-now {
    background: #28a745;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    margin-top: 10px;
    text-align: center;
}

.book-now:hover {
    background: #218838;
    color: white;
    text-decoration: none;
}

footer {
    margin-top: 20px;
}

.image-collage {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.image-collage img {
    width: calc(33% - 10px); /* Three images per row with space */
    border-radius: 8px;
    object-fit: cover;
}

.image-collage img:nth-child(3n) {
    margin-right: 0; /* Remove margin from the last image in each row */
}

.image-collage img:nth-last-child(-n+3) {
    margin-bottom: 0; /* Remove margin from the last row */
}

/* Responsive design */
@media (max-width: 768px) {
    .container {
        width: 90%;
    }

    .image-collage img {
        width: calc(50% - 10px); /* Two images per row on medium screens */
    }

    .package {
        margin: 15px; /* Adjusted margin for medium screens */
    }

    .package-item {
        flex-direction: column;
    }

    .package-item img {
        width: 100%;
    }

    .package-item .p-4 {
        padding: 15px;
    }
}

@media (max-width: 576px) {
    .container {
        width: 100%;
    }

    .image-collage img {
        width: 100%; /* One image per row on small screens */
        margin-bottom: 10px;
    }

    .package {
        padding: 15px;
        margin: 10px; /* Adjusted margin for small screens */
    }

    .book-now {
        font-size: 13px;
        padding: 6px 12px;
    }
}
</style>
