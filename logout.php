<?php
	session_start();
	//clearing session variables
	session_destroy();

	//redirecting
	header("Location: https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/Home.php");
    exit;
?>