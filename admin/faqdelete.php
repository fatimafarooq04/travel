<?php

require "connection.php";
$ID = $_GET['id'];
$dltquery= "DELETE FROM `faqs` WHERE faq_id=$ID ";
$result = mysqli_query($conn,$dltquery);

 echo"<script>
 alert('deleted successfully'); window.location.href='faqshow.php'; </script> ";
?> 