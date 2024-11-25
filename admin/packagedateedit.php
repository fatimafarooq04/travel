<!DOCTYPE html>
<html>

<head>
    <title>Edit Package Date</title>
    <link rel="stylesheet" href="path/to/your/admin-theme.css"> <!-- Replace with your theme's CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Fetch and display day count based on package selection
            $('#pack_id').change(function () {
                var packID = $(this).val();
                if (packID) {
                    $.ajax({
                        url: 'package_days.php', // Path to the script that fetches day count
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

            // Calculate end date based on start date and day count
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

            // Validate end date to ensure it doesn't exceed the maximum allowed
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

    // Retrieve the package date id from the URL
    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        // Fetch the current details of the package date
        $query = "SELECT d.id, d.pack_id, d.start_date, d.end_date, d.max_people, t.pack_name 
        FROM tour_package_dates d 
        JOIN tour_card t ON d.pack_id = t.pack_id
        WHERE d.id = '$id'";

        $result = mysqli_query($conn, $query);
        $dateDetails = mysqli_fetch_assoc($result);

        if (!$dateDetails) {
            echo "Invalid package date ID.";
            exit;
        }
    } else {
        echo "No package date ID provided.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $pack_id = mysqli_real_escape_string($conn, $_POST['pack_id']);
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
        $max_people = mysqli_real_escape_string($conn, $_POST['max_people']); // Get max_people
    
        // Update the package date in the database
        $update_query = "UPDATE tour_package_dates 
                         SET pack_id = '$pack_id', start_date = '$start_date', end_date = '$end_date', max_people = '$max_people' 
                         WHERE id = '$id'";
        $result = mysqli_query($conn, $update_query);
    
        if ($result) {
            echo "<script>
                alert('Package date updated successfully');
                window.location.href='packagedateshow.php'; // Redirect to a page that shows package dates
            </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    

    // Fetch packages from the database for the dropdown
    $sql_packages = "SELECT t.pack_id, t.pack_name, d.days AS day_count 
                     FROM tour_card t
                     LEFT JOIN t_days d ON t.day_id = d.day_id";
    $result_packages = $conn->query($sql_packages);

    ?>

    <div class="container">
        <h1 class="mt-5 text-center">Edit Package Date</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>" class="mt-4 mx-5">
            <div class="form-group">
                <label for="pack_id">Package:</label>
                <select class="form-control" id="pack_id" name="pack_id" required>
                    <option value="">Select a package</option>
                    <?php
                    while ($row = $result_packages->fetch_assoc()) {
                        $selected = ($row['pack_id'] == $dateDetails['pack_id']) ? 'selected' : '';
                        echo "<option value='" . $row["pack_id"] . "' $selected>" . htmlspecialchars($row["pack_name"]) . 
                             " (" . htmlspecialchars($row["day_count"]) . " days)</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
    <label for="max_people">Max People:</label>
    <input type="number" class="form-control" id="max_people" name="max_people" value="<?php echo htmlspecialchars($dateDetails['max_people']); ?>" required>
</div>

            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo htmlspecialchars($dateDetails['start_date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo htmlspecialchars($dateDetails['end_date']); ?>" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary mx-4" name="submit">Update Date</button>
            </div>
        </form>
    </div>

    <?php
    $conn->close();
    require "footer.php";
    ?>
</body>

</html>
