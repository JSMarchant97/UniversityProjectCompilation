<?php 
session_start();
session_destroy();
setcookie("userid", null, time() - 3600);
header("Location: http://voltafy.co.uk/jakevolt/");
?>