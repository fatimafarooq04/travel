<?php

require "connection.php";
$service_id = $_GET['id'];
$dltquery= "DELETE FROM `services` WHERE service_id=$service_id ";
$result = mysqli_query($conn,$dltquery);

 echo"<script>
 alert('deleted successfully'); window.location.href='serviceshow.php'; </script> ";
?> 