<?php
include "header.php";
?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>
            </div>
        </div>
        <div class="row">
            <?php
            require "connection.php";

            // Query to get the count of all users
            $user_count_query = "SELECT COUNT(*) as total_users FROM `user`";
            $user_count_result = mysqli_query($conn, $user_count_query);
            $user_count_row = mysqli_fetch_assoc($user_count_result);
            $total_users = $user_count_row['total_users'];
            ?>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Users</p>
                                    <h4 class="card-title"><?php echo htmlspecialchars($total_users); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            // Fetch package orders
            $package_orders_query = "SELECT COUNT(*) AS total_packages FROM package_booking";
            $package_orders_result = mysqli_query($conn, $package_orders_query);
            $package_orders_count = mysqli_fetch_assoc($package_orders_result)['total_packages'];

            // Fetch hotel orders
            $hotel_orders_query = "SELECT COUNT(*) AS total_hotels FROM hotelbookings";
            $hotel_orders_result = mysqli_query($conn, $hotel_orders_query);
            $hotel_orders_count = mysqli_fetch_assoc($hotel_orders_result)['total_hotels'];
            ?>

            <!-- Package Orders Card -->
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-box"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Package Orders</p>
                                    <h4 class="card-title"><?php echo htmlspecialchars($package_orders_count); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hotel Orders Card -->
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-hotel"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Hotel Orders</p>
                                    <h4 class="card-title"><?php echo htmlspecialchars($hotel_orders_count); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        // Query to fetch the latest 5 users
        $query = "SELECT * FROM `user` ORDER BY `UserID` DESC LIMIT 5";
        $result = mysqli_query($conn, $query);
        ?>

        <div class="row">
            <div class="col-md-4">
                <div class="card card-round">
                    <div class="card-body">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">New Customers</div>
                        </div>
                        <div class="card-list py-4">
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <div class="item-list">
                                    <div class="avatar">
                                        <span class="avatar-title rounded-circle border border-white bg-primary">
                                            <?php echo strtoupper($row['Name'][0]); ?>
                                        </span>
                                    </div>
                                    <div class="info-user ms-3">
                                        <div class="username"><?php echo htmlspecialchars($row['Name']); ?></div>
                                        <div class="status"><?php echo htmlspecialchars($row['Role']); ?></div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            // Query to fetch booking details with status "Confirmed" and room prices
            $query = "
            SELECT hb.booking_id, hb.user_id, hb.hotel_id, hb.check_in_date, hb.check_out_date, hb.payment_method_id, hb.status, hb.created_at, hb.updated_at, hb.new_room_id, hr.price
            FROM hotelbookings hb
            JOIN hotel_rooms hr ON hb.new_room_id = hr.room_id
            WHERE hb.status = 'Confirmed'
            ORDER BY hb.created_at DESC 
            LIMIT 5";
            
            $result = mysqli_query($conn, $query);
            ?>

            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Transaction History</div>
                            <div class="card-tools">
                                <div class="dropdown">
                                    <button class="btn btn-icon btn-clean me-0" type="button" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Payment Number</th>
                                        <th scope="col" class="text-end">Date & Time</th>
                                        <th scope="col" class="text-end">Amount</th>
                                        <th scope="col" class="text-end">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <th scope="row">
                                                <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                Payment from #<?php echo htmlspecialchars($row['booking_id']); ?>
                                            </th>
                                            <td class="text-end">
                                                <?php echo date("M d, Y, g:i a", strtotime($row['created_at'])); ?>
                                            </td>
                                            <td class="text-end">
                                                <?php
                                                // Fetch the actual price from the hotel_rooms table
                                                $amount = $row['price'];
                                                echo   number_format($amount, 2);
                                                ?>
                                            </td>
                                            <td class="text-end">
                                                <span class="badge badge-success">Confirmed</span>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            // Query to fetch package booking details with status "Confirmed" and package prices
            $query = "
            SELECT pb.booking_id, pb.package_id, pb.date_range_id, pb.message, pb.booking_date, pb.status, pb.userid, tc.pack_name, tc.pack_price
            FROM package_booking pb
            JOIN tour_card tc ON pb.package_id = tc.pack_id
            WHERE pb.status = 'Confirmed'
            ORDER BY pb.booking_date DESC 
            LIMIT 5";
            
            $result = mysqli_query($conn, $query);
            ?>

            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Package Booking History</div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Booking Number</th>
                                        <th scope="col" class="text-end">Booking Date</th>
                                        <th scope="col" class="text-end">Package Name</th>
                                        <th scope="col" class="text-end">Amount</th>
                                        <th scope="col" class="text-end">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <th scope="row">
                                                <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                Booking #<?php echo htmlspecialchars($row['booking_id']); ?>
                                            </th>
                                            <td class="text-end">
                                                <?php echo date("M d, Y, g:i a", strtotime($row['booking_date'])); ?>
                                            </td>
                                            <td class="text-end">
                                                <?php echo htmlspecialchars($row['pack_name']); ?>
                                            </td>
                                            <td class="text-end">
                                                <?php
                                                // Fetch the actual package price
                                                $amount = $row['pack_price'];
                                                echo  number_format($amount, 2);
                                                ?>
                                            </td>
                                            <td class="text-end">
                                                <span class="badge badge-success">Confirmed</span>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>
