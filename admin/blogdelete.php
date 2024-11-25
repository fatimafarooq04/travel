<?php
require 'connection.php';
$blog_id = $_GET['dltid'];
//echo $userid
$dltquery = "DELETE FROM `blog` WHERE blog_id=$blog_id";
$result= mysqli_query($conn,$dltquery);
echo"<script>
alert('Deleted sucessfully');
window.location.href='blogshow.php';
</script>"
?>