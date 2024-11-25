<?php
require "header.php";
require "connection.php";





?>


<!-- Carousel Start -->
<div class="container-fluid p-0">
    <div id="header-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="img/carousel-1.jpg" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 900px;">
                        <h4 class="text-white text-uppercase mb-md-3">Tours & Travel</h4>
                        <h1 class="display-3 text-white mb-md-4">Let's Discover The World Together</h1>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="w-100" src="img/carousel-2.jpg" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 900px;">
                        <h4 class="text-white text-uppercase mb-md-3">Tours & Travel</h4>
                        <h1 class="display-3 text-white mb-md-4">Discover Amazing Places With Us</h1>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-prev-icon mb-n2"></span>
            </div>
        </a>
        <a class="carousel-control-next" href="#header-carousel" data-slide="next">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-next-icon mb-n2"></span>
            </div>
        </a>
    </div>
</div>
<!-- Carousel End -->


<!-- Booking Start -->
<?php


// Fetch package names
$sql = "SELECT pack_id, pack_name FROM tour_card";
$result = $conn->query($sql);

$packages = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $packages[] = $row;
    }
} else {
    echo "0 results";
}


?>
<div class="container-fluid booking mt-5 pb-5">
    <div class="container pb-5">
        <div class="bg-light shadow" style="padding: 30px;">
            <form id="bookingForm" method="GET" action="tour.php">
                <div class="row align-items-center" style="min-height: 60px;">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 mb-md-0">
                                    <select id="citySelect" name="city" class="custom-select px-4" style="height: 47px;">
                                        <option selected value="">Destination</option>
                                        <?php
                                        $sql = "SELECT CityID, CityName FROM city";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row['CityID'] . "'>" . $row['CityName'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 mb-md-0">
                                    <select id="packageSelect" name="package" class="custom-select px-4" style="height: 47px;">
                                        <option selected value="">Package</option>
                                        <!-- Packages will be dynamically populated based on city selection -->
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-block" type="submit" style="height: 47px; margin-top: -2px;">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('citySelect').addEventListener('change', function () {
        var cityId = this.value;
        var packageSelect = document.getElementById('packageSelect');
        packageSelect.innerHTML = '<option selected value="">Package</option>';

        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'getPackages.php?city_id=' + cityId, true);
        xhr.onload = function () {
            if (this.status == 200) {
                try {
                    var packages = JSON.parse(this.responseText);
                    if (packages.length > 0) {
                        packages.forEach(function (pkg) {
                            var option = document.createElement('option');
                            option.value = pkg.pack_id;
                            option.textContent = pkg.pack_name;
                            packageSelect.appendChild(option);
                        });
                    }
                } catch (e) {
                    console.error('Error parsing JSON response:', e);
                }
            } else {
                console.error('Error with AJAX request:', this.status);
            }
        };
        xhr.onerror = function () {
            console.error('Request error...');
        };
        xhr.send();
    });
    document.querySelector('button[type="submit"]').addEventListener('click', function () {
    var cityId = document.getElementById('citySelect').value;
    var sortOrder = document.getElementById('price-sort') ? document.getElementById('price-sort').value : 'default';
    var url = new URL('tour.php', window.location.href);
    url.searchParams.set('city', cityId);
    url.searchParams.set('sort', sortOrder);
    window.location.href = url.toString();
});

</script>



<!-- Booking End -->




<!-- Destination Start -->


<div class="container-fluid py-5">
    <div class="container pt-5 pb-3">
        <div class="text-center mb-3 pb-3">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Destination</h6>
            <h1>Explore Top Destinations</h1>
        </div>
        <div class="row">
            <?php
            // Fetch 3 random destinations along with city names from the database
            $sql = "SELECT destination.*, city.CityName as CityName 
            FROM `destination` 
            JOIN `city` ON destination.CityID = city.CityID 
            ORDER BY RAND() 
            LIMIT 3"; // Adjust SQL query to fetch random destinations
            
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) {
                $destination_id = $row['DestinationID']; // Assuming 'DestinationID' is the primary key of your destination table
                ?>
                <div class="col-lg-4 col-md-6 mb-4">
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
            ?>
        </div>


    </div>
</div>

<!-- package Start -->
<div class="container">
    <div class="row pb-3">
        <h1 class="text-center w-100">Perfect Tour Packages</h1>
    </div>
    <div class="row">
        <?php
        // Modify query to select 3 random packages
        $query = "SELECT p.pack_id, p.pack_name, p.day_id,  p.pack_img, p.pack_price, p.CityID, c.CityName, d.days
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
                    <div class="bg-white package d-flex flex-column" style="height:530px"
                        data-city="<?php echo htmlspecialchars($CityName); ?>"
                        data-price="<?php echo htmlspecialchars($pack_price); ?>">
                        <img class="img-fluid" src="../admin/<?php echo htmlspecialchars($pack_img); ?>" alt=""
                            style="height:300px">
                        <div class="p-4 flex-grow-1">
                            <div class="d-flex justify-content-between mb-3">
                                <small class="m-0"><i
                                        class="fa fa-map-marker-alt text-primary mr-2"></i><?php echo htmlspecialchars($CityName); ?></small>
                                <small class="m-0"><i
                                        class="fa fa-calendar-alt text-primary mr-2"></i><?php echo htmlspecialchars($days); ?>
                                    days</small>
                            </div>
                            <a class="h5 text-decoration-none"
                                href="packagedetails.php?id=<?php echo htmlspecialchars($pack_id); ?>"><?php echo htmlspecialchars($pack_name); ?>
                            </a>
                            <div class="border-top mt-4 pt-4">
                                <div class="d-flex justify-content-between">
                                    <h5 class="m-0">PKR <?php echo htmlspecialchars($pack_price); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 d-flex justify-content-between">
                            <a href="packagedetails.php?id=<?php echo htmlspecialchars($pack_id); ?>"
                                class="btn btn-sm btn-primary">View Details</a>

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

<!-- Service Start -->
<?php
// Fetch three services
$sql = "SELECT `service_id`, `service_name`, `service_desc` FROM `services` LIMIT 3";
$result = $conn->query($sql);

$services = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
} else {
    echo "0 results";
}
?>
<div class="container-fluid py-5">
    <div class="container pt-5 pb-3">
        <div class="text-center mb-3 pb-3">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Services</h6>
            <h1>Tours & Travel Services</h1>
        </div>
        <div class="row">
            <?php foreach ($services as $service): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-item bg-white text-center mb-2 py-5 px-4">
                        <i class="fa fa-2x fa-route mx-auto mb-4"></i>
                        <h5 class="mb-2"><?php echo htmlspecialchars($service['service_name']); ?></h5>
                        <p class="m-0"><?php echo htmlspecialchars($service['service_desc']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- Service End -->


<!-- Testimonial Start -->
<?php

// Fetch comments
$sql = "SELECT dc.id, dc.comment, u.Name as client_name,dc.created_at
FROM destination_comments dc
JOIN user u ON dc.user_id = u.UserID
LIMIT 4
"; // Adjust the LIMIT as needed
$result = $conn->query($sql);

$comments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
} else {
    echo "0 results";
}

?>
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mb-3 pb-3">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Testimonial</h6>
            <h1>What Say Our Clients</h1>
        </div>
        <div class="owl-carousel testimonial-carousel">
            <?php foreach ($comments as $comment): ?>
                <div class="text-center pb-4">
                    <div class="testimonial-text bg-white p-4 mt-n5">
                        <p class="mt-5"><?php echo htmlspecialchars($comment['comment']); ?></p>
                        <h5 class="text-truncate">Client Name</h5>
                        <span><?php echo htmlspecialchars($comment['created_at']); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- Testimonial End -->


<!-- Blog Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mb-3 pb-3">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Blogs</h6>
            <h1>Discover The World</h1>
        </div>
        <?php
        // Fetch three random blogs
        $sql = "SELECT `blog_id`, `blog_img`, `blog_date`, `blog_month`, `blog_head`, `blog_text` FROM `blog` ORDER BY RAND() LIMIT 3";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $blogs = [];
            while ($row = $result->fetch_assoc()) {
                $blogs[] = $row;
            }
        } else {
            echo "0 results";
        }
        ?>

        <div class="row">
            <?php foreach ($blogs as $blog): ?>
                <div class="col-md-6 mb-4 pb-2">
                    <div class="blog-item">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="../admin/<?php echo htmlspecialchars($blog['blog_img']); ?>"
                                alt="" style="height: 300px; width:400px">
                            <div class="blog-date">
                                <h6 class="font-weight-bold mb-n1"><?php echo htmlspecialchars($blog['blog_date']); ?></h6>
                                <small
                                    class="text-white text-uppercase"><?php echo htmlspecialchars($blog['blog_month']); ?></small>
                            </div>
                        </div>
                        <div class="bg-white p-4">
                            <div class="d-flex mb-2">
                                <a class="text-primary text-uppercase text-decoration-none"
                                    href="blog-detail.php?id=<?php echo htmlspecialchars($blog['blog_id']); ?>"><?php echo htmlspecialchars($blog['blog_head']); ?></a>
                            </div>
                            <a class="h5 m-0 text-decoration-none"
                                href="blog-detail.php?id=<?php echo htmlspecialchars($blog['blog_id']); ?>"><?php echo htmlspecialchars($blog['blog_text']); ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>



    </div>
</div>
<!-- Blog End -->



<?php
require "footer.php";
?>
