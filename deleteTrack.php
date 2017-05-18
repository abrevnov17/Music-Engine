<?php

	session_start();
	
	/* To Do:
		1) check boxes to make sure username/password/email/bio are up to scratch and display notification if not
		2) add notification if username is repeated
	*/

	$dbc= mysqli_connect("localhost", "abrevnov17", "abrevnov171234", "abrevnov17");
	if(!$dbc){ // there was an error connecting
		echo "Failed to connect to the database.  Error=".mysqli_connect_error();
	}
	else {
		//mysql connection has been established -> now we attempt to create a user from inputted data

		//setting variable values from POST
		echo '<script>console.log("hi:'.$_SESSION["username"].'")</script>';

		$trackid = $_POST["actionResult"];
		echo '<script>console.log("hi:'.$trackid.'")</script>';

		//need to verify that username does not already exist
		$query = mysqli_query($dbc,"DELETE FROM Tracks WHERE trackid='$trackid'");

		//redirecting
		header("Location: https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/EditProfile.php");
		exit;


	}




?>