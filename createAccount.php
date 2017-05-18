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

		$username = $_POST["username"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		$bio = $_POST["bio"];
	

		//need to verify that username does not already exist
		$query = mysqli_query($dbc,"SELECT username FROM Users WHERE username='$username'");

  		if (mysqli_num_rows($query) != 0)
  		{
  			//add some sort of alarm/notification
			echo "Username already exists";
  		}

  		else
  		{
  			//inserting new user into Users table
  			$sql = "INSERT INTO Users (username,email,password,bio) VALUES ('$username','$email','$password','$bio')";
			mysqli_query($dbc,$sql);
			
			//logging user in using session variable
			$_SESSION["username"] = $username;
			$_SESSION["password"] = $password;
			$_SESSION["email"] = $email;

			//redirecting
			header("Location: https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/LoggedInObserver.php");
    		exit;
  		}



	}




?>