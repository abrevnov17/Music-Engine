<?php

	session_start();
	$dbc= mysqli_connect("localhost", "abrevnov17", "abrevnov171234", "abrevnov17");
	if(!$dbc){ // there was an error connecting
		echo "Failed to connect to the database.  Error=".mysqli_connect_error();
	}
	else {
		//mysql connection has been established

		//getting ajax trackid variable

		$trackID = intval($_GET['q']);

		//getting userid variable

		$username = $_SESSION["username"];

		$sql3 = "SELECT `uid` FROM Users WHERE `username` = '$username'";
		$resultObjectUID = mysqli_query($dbc,$sql3);
		$row = mysqli_fetch_array($resultObjectUID, MYSQLI_NUM);
		$uid = $row[0];

		//see whether I am liking or unliking a given track

		//here I check whether the like button should be liked or unliked upon initiliazition 
		$sql1 = "SELECT `likeid` FROM Likes WHERE `trackid`='$trackID' AND `userid`='$uid'";
		$query = mysqli_query($dbc,$sql1);
		if (mysqli_num_rows($query) == 0){

			//adding 1 to likes column of track

			$query = mysqli_query($dbc,"UPDATE Tracks SET `likes`=`likes`+1 WHERE trackid='$trackID'");

			//adding a like row to the likes table

			$query = mysqli_query($dbc,"INSERT INTO Likes (userid,trackid) VALUES ('$uid','$trackID')");
		}
		else {
			//unliking
			$query = mysqli_query($dbc,"UPDATE Tracks SET `likes` = `likes` - 1 WHERE trackid='$trackID'");
			$query = mysqli_query($dbc,"DELETE FROM Likes where `userid`='$uid' AND `trackid`='$trackID'");


		}


	}
	//header("Location: https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/LoggedInObserver.php");
	//exit;

?>