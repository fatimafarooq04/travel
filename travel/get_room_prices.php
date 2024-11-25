<?php
require 'connection.php';

if (isset($_GET['room_id']) && is_numeric($_GET['room_id'])) {
    $roomId = $_GET['room_id'];

    $qry = "
        SELECT hr.room_id, rt.TypeName AS room_type, hr.description, hr.price 
        FROM hotel_rooms hr 
        JOIN room_types rt ON hr.room_type = rt.RoomTypeID
        WHERE hr.room_id = ?";
        
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("i", $roomId);
    $stmt->execute();
    $result = $stmt->get_result();

    $prices = [];
    while ($row = $result->fetch_assoc()) {
        $prices[] = $row;
    }

    echo json_encode($prices);
} else {
    echo json_encode([]);
}
?>
