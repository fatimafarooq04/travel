<?php
require 'connection.php';
$DestinationID = $_GET['dltid'];
//echo $userid
$dltquery = "DELETE FROM `facility` WHERE FacilityID=$DestinationID";
$result= mysqli_query($conn,$dltquery);
echo"<script>
alert('Deleted sucessfully');
window.location.href='facilityshow.php';
</script>"
?>