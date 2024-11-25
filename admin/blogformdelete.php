<?php
require 'connection.php';
$form_id = $_GET['dltid'];
//echo $userid
$dltquery = "DELETE FROM `blog_form` WHERE form_id=$form_id";
$result= mysqli_query($conn,$dltquery);
echo"<script>
alert('Deleted sucessfully');
window.location.href='blogformshow.php';
</script>"
?>