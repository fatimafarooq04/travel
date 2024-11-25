<?php

require "connection.php";
$ID = $_GET['id'];
$dltquery= "DELETE FROM `carousel` WHERE carousel_id=$ID ";
$result = mysqli_query($conn,$dltquery);

 echo"<script>
 alert('deleted successfully'); window.location.href='carouselshow.php'; </script> ";
?> 