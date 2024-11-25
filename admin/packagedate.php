<!DOCTYPE html>
<html>

<head>
    <title>Add Package Date</title>
    <link rel="stylesheet" href="path/to/your/admin-theme.css"> <!-- Replace with your theme's CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#pack_id').change(function () {
                var packID = $(this).val();
                if (packID) {
                    $.ajax({
                        url: 'package_days.php', // Correct path to the PHP script
                        type: 'GET',
                        data: { pack_id: packID },
                        success: function (response) {
                            var data = JSON.parse(response);
                            if (data) {
                                var days = data.day_count;
                                $('#day_count').text(days + ' days');
                                $('#day_count').data('days', days); // Store days in data attribute

                                // Adjust end date based on new day count if start date is already set
                                var startDate = $('#start_date').val();
                                if (startDate) {
                                    var endDate = new Date(startDate);
                                    endDate.setDate(endDate.getDate() + parseInt(days));
                                    $('#end_date').val(endDate.toISOString().split('T')[0]);

                                    // Update min and max attributes of end date input
                                    $('#end_date').attr('min', startDate);
                                    $('#end_date').attr('max', endDate.toISOString().split('T')[0]);
                                }
                            }
                        }
                    });
                }
            });

            $('#start_date').change(function () {
                var startDate = new Date($(this).val());
                var days = $('#day_count').data('days');
                if (startDate && days) {
                    var endDate = new Date(startDate);
                    endDate.setDate(endDate.getDate() + parseInt(days));
                    $('#end_date').val(endDate.toISOString().split('T')[0]);

                    // Update min and max attributes of end date input
                    $('#end_date').attr('min', startDate.toISOString().split('T')[0]);
                    $('#end_date').attr('max', endDate.toISOString().split('T')[0]);
                }
            });

            $('#end_date').change(function () {
                var startDate = new Date($('#start_date').val());
                var endDate = new Date($(this).val());
                var days = $('#day_count').data('days');

                if (startDate && endDate && days) {
                    var maxEndDate = new Date(startDate);
                    maxEndDate.setDate(maxEndDate.getDate() + parseInt(days));

                    if (endDate > maxEndDate) {
                        alert('End date cannot be later than the calculated end date for this package.');
                        $(this).val('');
                    }
                }
            });
        });
    </script>
</head>

<body>
    <?php
    require "header.php";
    require "connection.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $pack_id = mysqli_real_escape_string($conn, $_POST['pack_id']);
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
        $max_people = mysqli_real_escape_string($conn, $_POST['max_people']); // Add this line
    
        // Insert package date into tour_package_dates table
        $insert_query = "INSERT INTO tour_package_dates (pack_id, start_date, end_date, max_people) 
                         VALUES ('$pack_id', '$start_date', '$end_date', '$max_people')"; // Update query
        $result = mysqli_query($conn, $insert_query);
    
        if ($result) {
            echo "<script>
                alert('Package date added successfully');
                window.location.href='packagedateshow.php'; // Redirect to a page that shows package dates
            </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    
    
    // Fetch packages from the database with days
    $sql_packages = "SELECT t.pack_id, t.pack_name, d.days AS day_count 
                     FROM tour_card t
                     LEFT JOIN t_days d ON t.day_id = d.day_id";
    $result_packages = $conn->query($sql_packages);

    ?>

    <div class="container">
        <h1 class="mt-5 text-center">Add Package Date</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4 mx-5">
            <div class="form-group">
                <label for="pack_id">Package:</label>
                <select class="form-control" id="pack_id" name="pack_id" required>
                    <option value="">Select a package</option>
                    <?php
                    if ($result_packages->num_rows > 0) {
                        while ($row = $result_packages->fetch_assoc()) {
                            echo "<option value='" . $row["pack_id"] . "'>" . htmlspecialchars($row["pack_name"]) . 
                                 " (" . htmlspecialchars($row["day_count"]) . " days)</option>";
                        }
                    } else {
                        echo "<option value=''>No packages available</option>";
                    }
                    ?>
                </select>
                <p id="day_count" class="mt-2"></p>
            </div>
            <div class="form-group">
    <label for="max_people">Maximum People:</label>
    <input type="number" class="form-control" id="max_people" name="max_people" required>
</div>

            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary mx-4" name="submit">Add Date</button>
                <button type="reset" class="btn btn-secondary mx-4">Reset</button>
            </div>
        </form>
    </div>

    <?php
    $conn->close();
    require "footer.php";
    ?>
</body>

</html>
