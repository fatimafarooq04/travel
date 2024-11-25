<?php
require 'connection.php';
$DestinationID = $_GET['dltid'];
//echo $userid
$dltquery = "DELETE FROM `destination` WHERE DestinationID=$DestinationID";
$result= mysqli_query($conn,$dltquery);
echo"<script>
alert('Deleted sucessfully');
window.location.href='destinationshow.php';
</script>"
?>