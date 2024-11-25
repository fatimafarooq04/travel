<?php
require "connection.php";
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

$cityId = isset($_GET['city_id']) ? intval($_GET['city_id']) : 0;

if ($cityId > 0) {
    

    // Fetch packages based on city ID
    $query = "SELECT pack_id, pack_name FROM tour_card WHERE CityID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $cityId);
    $stmt->execute();
    $result = $stmt->get_result();

    $packages = [];
    while ($row = $result->fetch_assoc()) {
        $packages[] = $row;
    }

    // Debugging: Log the packages array
    file_put_contents('debug_log.txt', print_r($packages, true));

    // Return the JSON-encoded packages array
    echo json_encode($packages);

    $stmt->close();
} else {
    echo json_encode([]);
}
?>
