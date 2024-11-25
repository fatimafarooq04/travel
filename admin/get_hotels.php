<?php
require "connection.php";

if (isset($_POST['CityID'])) {
    $cityID = intval($_POST['CityID']);
    
    // Fetch hotels based on the selected city
    $sql_hotels = "SELECT HotelID, Name FROM hotel WHERE CityID = ?";
    $stmt = $conn->prepare($sql_hotels);
    $stmt->bind_param("i", $cityID);
    $stmt->execute();
    $result_hotels = $stmt->get_result();

    if ($result_hotels->num_rows > 0) {
        echo "<option value=''>Select Hotel</option>";
        while ($row = $result_hotels->fetch_assoc()) {
            echo "<option value='" . $row["HotelID"] . "'>" . $row["Name"] . "</option>";
        }
    } else {
        echo "<option value=''>No hotels available</option>";
    }
    
    $stmt->close();
}
$conn->close();
?>
