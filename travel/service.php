<?php
require "header.php";
?>

    <!-- Header Start -->
    <div class="container-fluid page-header">
        <div class="container">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
                <h3 class="display-4 text-white text-uppercase">Services</h3>
                <div class="d-inline-flex text-white">
                    <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                    <i class="fa fa-angle-double-right pt-1 px-3"></i>
                    <p class="m-0 text-uppercase">Services</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Service Start -->
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Services</h6>
                <h1>Tours & Travel Services</h1>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                       <div class="search-container">
            <form method="GET" action="" class="search-box">
                <input type="text" class="form-control" name="search" id="searchInput" placeholder="Search..." >
                <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
            </form>
        </div>
                </div>
            </div>
            <div class="row">
                <?php 

                // Check if search query exists
                if (isset($_GET['search'])) {
                    $search = mysqli_real_escape_string($conn, $_GET['search']);
                    $qry = "SELECT * FROM `services` WHERE `service_name` LIKE '%$search%' OR `service_desc` LIKE '%$search%'";
                } else {
                    $qry = "SELECT * FROM `services`";
                }

                $res = mysqli_query($conn, $qry);

                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-item bg-white text-center mb-2 py-5 px-4">
                        <i class="fa fa-2x fa-route mx-auto mb-4"></i>
                        <h5 class="mb-2"><?php echo $row['service_name']; ?></h5>
                        <p class="m-0"><?php echo $row['service_desc']; ?></p>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <?php
require "footer.php";
?>
