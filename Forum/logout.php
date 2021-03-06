<?php

//Gets session data then unsets the idNumber then sends to Login Form

session_start();

      
//this will need to be set as a session when logging in 
unset($_SESSION["username"]);

header("Location:loginreg.php");
?>