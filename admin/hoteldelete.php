<?php
require 'connection.php';
$HotelID = $_GET['dltid'];
//echo $userid
$dltquery = "DELETE FROM `hotel` WHERE HotelID=$HotelID";
$result= mysqli_query($conn,$dltquery);
echo"<script>
alert('Deleted sucessfully');
window.location.href='hotelshow.php';
</script>"
?>