<?php
require 'connection.php';
$CityID = $_GET['dltid'];
//echo $userid
$dltquery = "DELETE FROM `city` WHERE CityID=$CityID";
$result= mysqli_query($conn,$dltquery);
echo"<script>
alert('Deleted sucessfully');
window.location.href='cityshow.php';
</script>"
?>