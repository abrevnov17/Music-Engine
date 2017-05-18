<?php

	session_start();
	$_SESSION["lastCategoryClicked"]="new";
	header("Location: https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/LoggedInObserver.php");
	exit;

?>