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

		$email = $_POST["email"];
		$password = $_POST["password"];
	
		//need to verify that username does not already exist
		$query = mysqli_query($dbc,"SELECT COUNT(email) FROM Users WHERE email = '$email' AND password = '$password' LIMIT 0, 1");
		$row = mysqli_fetch_array($query, MYSQLI_NUM);

  		if ($row[0] != 0)
  		{
			//logging user in using session variable
			$_SESSION["password"] = $password;
			$_SESSION["email"] = $email;  

			$query = mysqli_query($dbc,"SELECT username FROM Users WHERE email = '$email' AND password = '$password' LIMIT 0, 1");
			$row = mysqli_fetch_array($query, MYSQLI_NUM);

			$_SESSION["username"] = $row[0];

			//redirecting
			header("Location: https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/LoggedInObserver.php");
    		exit;

		
		}

  		else
  		{
  			echo "Incorrect login information";
  		}



	}




?>