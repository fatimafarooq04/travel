<!DOCTYPE html>
<html>

<head>
    <title>Edit Tour Package</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Load hotels based on selected city
            $('#CityID').change(function () {
                var cityID = $(this).val();
                if (cityID) {
                    $.ajax({
                        type: 'POST',
                        url: 'get_hotels.php',
                        data: { CityID: cityID },
                        success: function (response) {
                            $('#HotelID').html(response);
                        }
                    });
                } else {
                    $('#HotelID').html('<option value="">Select a city first</option>');
                }
            });

            // Set initial hotel options
            var initialCityID = $('#CityID').val();
            if (initialCityID) {
                $.ajax({
                    type: 'POST',
                    url: 'get_hotels.php',
                    data: { CityID: initialCityID },
                    success: function (response) {
                        $('#HotelID').html(response);
                        var selectedHotelID = $('#HotelID').data('selected');
                        $('#HotelID').val(selectedHotelID); // Set the selected hotel
                    }
                });
            }
        });
    </script>
</head>

<body>
    <?php
    require "header.php";
    require "connection.php";

    // Get the tour card ID from the URL
    $pack_id = isset($_GET['pack_id']) ? (int)$_GET['pack_id'] : 0;

    // Fetch the details of the selected tour card
    $query = "
        SELECT tc.*, c.CityName, d.days, h.Name AS HotelName
        FROM tour_card tc
        JOIN city c ON tc.CityID = c.CityID
        JOIN t_days d ON tc.day_id = d.day_id
        JOIN hotel h ON tc.HotelID = h.HotelID
        WHERE tc.pack_id = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $pack_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tour_card = $result->fetch_assoc();

    if (!$tour_card) {
        echo "<p>Tour card not found.</p>";
        require "footer.php";
        exit;
    }

    // Function to handle image upload
    function handleImageUpload($fieldName) {
        $pack_img = $_FILES[$fieldName];
        $imagename = $pack_img['name'];
        $actualpath = $pack_img['tmp_name'];
        $mypath = "uploads/" . $imagename;

        // Check if the file extension is allowed
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtension = strtolower(pathinfo($imagename, PATHINFO_EXTENSION));

        if (in_array($fileExtension, $allowedExtensions)) {
            move_uploaded_file($actualpath, $mypath);
            return $mypath; // Return the uploaded file path
        } else {
            echo "<script>
                alert('Sorry, only JPG, JPEG, and PNG files are allowed.');
                window.location.href='showt_card.php';
            </script>";
            exit; // Stop further execution
        }
    }

    // Handle form submission for updating
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pack_name = $_POST['pack_name'];
        $pack_desc = $_POST['pack_desc'];
        $day_id = $_POST['day_id'];
        $CityID = $_POST['CityID'];
        $HotelID = $_POST['HotelID'];
        $pack_price = $_POST['pack_price'];

        // Handle image upload
        $pack_img = $tour_card['pack_img']; // Default to current image

        if (!empty($_FILES["pack_img"]["tmp_name"])) {
            $pack_img = handleImageUpload("pack_img");
        }

        // Update query
        $sql = "
            UPDATE tour_card SET 
                pack_name = ?, 
                day_id = ?, 
                pack_desc = ?, 
                pack_price = ?, 
                pack_img = ?, 
                CityID = ?, 
                HotelID = ? 
            WHERE pack_id = ?
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sisdsiii', $pack_name, $day_id, $pack_desc, $pack_price, $pack_img, $CityID, $HotelID, $pack_id);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Record updated successfully');
                    window.location.href='tourshow.php';
                  </script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Fetch cities and days for form options
    $sql_city = "SELECT CityID, CityName FROM city";
    $result_city = $conn->query($sql_city);

    $sql_days = "SELECT day_id, days FROM t_days";
    $result_days = $conn->query($sql_days);

    // Fetch hotels based on current city
    $sql_hotels = "SELECT HotelID, Name FROM hotel WHERE CityID = ?";
    $stmt = $conn->prepare($sql_hotels);
    $stmt->bind_param('i', $tour_card['CityID']);
    $stmt->execute();
    $result_hotels = $stmt->get_result();
    ?>

    <div class="container">
        <h1 class="mt-5 text-center">Update Tour Package</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?pack_id=' . $pack_id; ?>" class="mt-4 mx-5" enctype="multipart/form-data">
            <div class="form-group">
                <label for="pack_name">Tour Name:</label>
                <input type="text" class="form-control" id="pack_name" name="pack_name" value="<?php echo htmlspecialchars($tour_card['pack_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="pack_desc">Description:</label>
                <textarea class="form-control" id="pack_desc" name="pack_desc" required><?php echo htmlspecialchars($tour_card['pack_desc']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="day_id">Days:</label>
                <select class="form-control" id="day_id" name="day_id" required>
                    <?php
                    if ($result_days->num_rows > 0) {
                        while($row = $result_days->fetch_assoc()) {
                            $selected = $row["day_id"] == $tour_card['day_id'] ? 'selected' : '';
                            echo "<option value='" . $row["day_id"] . "' $selected>" . $row["days"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No days available</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="CityID">City:</label>
                <select class="form-control" id="CityID" name="CityID" required>
                    <?php
                    if ($result_city->num_rows > 0) {
                        while($row = $result_city->fetch_assoc()) {
                            $selected = $row["CityID"] == $tour_card['CityID'] ? 'selected' : '';
                            echo "<option value='" . $row["CityID"] . "' $selected>" . $row["CityName"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No cities available</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="HotelID">Hotel:</label>
                <select class="form-control" id="HotelID" name="HotelID" required data-selected="<?php echo htmlspecialchars($tour_card['HotelID']); ?>">
                    <?php
                    if ($result_hotels->num_rows > 0) {
                        while($row = $result_hotels->fetch_assoc()) {
                            $selected = $row["HotelID"] == $tour_card['HotelID'] ? 'selected' : '';
                            echo "<option value='" . $row["HotelID"] . "' $selected>" . $row["Name"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hotels available</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="pack_price">Price:</label>
                <input type="number" step="0.01" class="form-control" id="pack_price" name="pack_price" value="<?php echo htmlspecialchars($tour_card['pack_price']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="pack_img">Upload Image:</label>
                <input type="file" class="form-control-file" id="pack_img" name="pack_img">
                <?php if ($tour_card['pack_img']): ?>
                    <img src="<?php echo htmlspecialchars($tour_card['pack_img']); ?>" alt="Current Image" class="mt-2" width="100">
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Tour</button>
        </form>
    </div>

    <?php
    require "footer.php";
    ?>
</body>

</html>
