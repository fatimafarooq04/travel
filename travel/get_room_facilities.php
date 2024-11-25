<?php
require "connection.php";

if (isset($_GET['room_id']) && is_numeric($_GET['room_id'])) {
    $roomId = $_GET['room_id'];

    // Prepare and execute query to get facilities for the room
    $qry = "
        SELECT hf.facility_name
        FROM hr_facilities hf
        JOIN hotel_room_facilities hrf ON hf.facility_id = hrf.facility_id
        WHERE hrf.room_id = ?
    ";
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("i", $roomId);
    $stmt->execute();
    $result = $stmt->get_result();

    $facilities = [];
    while ($row = $result->fetch_assoc()) {
        $facilities[] = $row;
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($facilities);
}
?>
