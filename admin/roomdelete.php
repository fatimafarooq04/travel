<?php
require 'connection.php';
$RoomID = $_GET['dltid'];
//echo $userid
$dltquery = "DELETE FROM `room` WHERE RoomID=$RoomID";
$result= mysqli_query($conn,$dltquery);
echo"<script>
alert('Deleted sucessfully');
window.location.href='roomshow.php';
</script>"
?>