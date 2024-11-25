<?php
require 'connection.php';
$about_id = $_GET['dltid'];
//echo $userid
$dltquery = "DELETE FROM `about_us` WHERE about_id=$about_id";
$result= mysqli_query($conn,$dltquery);
echo"<script>
alert('Deleted sucessfully');
window.location.href='aboutshow.php';
</script>"
?>