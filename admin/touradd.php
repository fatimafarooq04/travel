<!DOCTYPE html>
<html>

<head>
    <title>Add Tour Package</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
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
        });
    </script>
</head>

<body>
    <?php
    require "header.php";
    require "connection.php";

    // Fetch cities from the database
    $sql_city = "SELECT CityID, CityName FROM city";
    $result_city = $conn->query($sql_city);

    // Fetch days from the database
    $sql_days = "SELECT day_id, days FROM t_days";
    $result_days = $conn->query($sql_days);
    ?>

    <div class="container">
        <h1 class="mt-5 text-center">Add Tour Package</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4 mx-5" enctype="multipart/form-data">
            <div class="form-group">
                <label for="pack_name">Name:</label>
                <input type="text" name="pack_name" id="pack_name" required class="form-control">
            </div>
            <div class="form-group">
                <label for="pack_desc">Description:</label>
                <textarea class="form-control" id="pack_desc" name="pack_desc" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="day_id">Days:</label>
                <select class="form-control" id="day_id" name="day_id" required>
                    <?php
                    if ($result_days->num_rows > 0) {
                        while ($row = $result_days->fetch_assoc()) {
                            echo "<option value='" . $row["day_id"] . "'>" . $row["days"] . "</option>";
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
                    <option value="">Select a city</option>
                    <?php
                    if ($result_city->num_rows > 0) {
                        while ($row = $result_city->fetch_assoc()) {
                            echo "<option value='" . $row["CityID"] . "'>" . $row["CityName"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No cities available</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="HotelID">Hotel:</label>
                <select class="form-control" id="HotelID" name="HotelID" required>
                    <option value="">Select a city first</option>
                </select>
            </div>

            <div class="form-group">
                <label for="pack_price">Price:</label>
                <input type="number" step="0.01" class="form-control" id="pack_price" name="pack_price" required>
            </div>

            <div class="form-group">
                <label for="pack_img">Upload Image:</label>
                <input type="file" class="form-control-file" id="pack_img" name="pack_img" accept=".jpg,.jpeg,.png" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary mx-4" name="sub">Add Tour Card</button>
                <button type="reset" class="btn btn-secondary mx-4">Reset</button>
            </div>
        </form>
    </div>

    <?php
    if (isset($_POST['sub'])) {
        // Escape special characters in input values
        $pack_name = mysqli_real_escape_string($conn, $_POST['pack_name']);
        $pack_desc = mysqli_real_escape_string($conn, $_POST['pack_desc']);
        $day_id = mysqli_real_escape_string($conn, $_POST['day_id']);
        $CityID = mysqli_real_escape_string($conn, $_POST['CityID']);
        $HotelID = mysqli_real_escape_string($conn, $_POST['HotelID']);
        $pack_price = mysqli_real_escape_string($conn, $_POST['pack_price']);

        // Handle image upload
        $pack_img = handleImageUpload('pack_img');

        // Insert tour card details into tour_card table
        $Insert_qry = "INSERT INTO tour_card (day_id, pack_name, pack_desc, pack_price, pack_img, CityID, HotelID) 
                        VALUES ('$day_id', '$pack_name', '$pack_desc', '$pack_price', '$pack_img', '$CityID', '$HotelID')";
        $res = mysqli_query($conn, $Insert_qry);

        if ($res) {
            // Redirect or display success message
            echo "<script>
                alert('Tour Package Added Successfully');
                window.location.href='tourshow.php';
            </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    function handleImageUpload($fieldName)
    {
        global $conn;

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

    $conn->close();
    require "footer.php";
    ?>
</body>

</html>
