<?php
	session_start();

	if(!isset($_SESSION["username"])){ 
    	header("Location: https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/Home.php");
    	exit;
	}

	$url = "";
	
	/*Uploading file to directory folder: Strategy: get file from $_FILES, connect to FTP, save to FTP using file_put, close FTP server and print any errors */

	//make sure that file is of the appropriate type 
	if ((($_FILES["file-upload"]["type"] == "audio/mp3")
        || ($_FILES["file-upload"]["type"] == "audio/mpeg")
        || ($_FILES["file-upload"]["type"] == "video/mp4")
        || ($_FILES["file-upload"]["type"] == "audio/wma")
        && in_array($extension, $allowedExts)
        && $_FILES['file-upload']['size'][$number] <= 100000000))
	{
   		if ($_FILES["file-upload"]["error"] > 0)
   		{
      		echo "Return Code: " . $_FILES["file-upload"]["error"] . "<br>";
   		}
   		else
   		{

      		if (file_exists("/Users/student/Sites/abrevnov17/Music Engine/track_uploads/" . $_FILES["file-upload"]["name"]))
      		{
         		echo $_FILES["file-upload"]["name"] . " already exists. ";
		      }
		      else
		      {
		         move_uploaded_file($_FILES["file-upload"]["tmp_name"],
		         "/Users/student/Sites/abrevnov17/Music Engine/track_uploads/" . $_FILES["file-upload"]["name"]);
		         $url = "track_uploads/" . $_FILES["file-upload"]["name"];

		         
		      }
		}
	}

	//uploading track info to database

				/* To Do:
					1) check boxes to make sure info are up to scratch and display notification if not
					2) add notification if track name is repeated?
				*/

				$dbc= mysqli_connect("localhost", "abrevnov17", "abrevnov171234", "abrevnov17");

				if(!$dbc){ // there was an error connecting
					echo "Failed to connect to the database.  Error=".mysqli_connect_error();
				}
				else {

					//mysql connection has been established -> now we attempt to add a new track to database

					//setting variable values from POST

					//NEED TO IMPLEMENT $_SESSION STUFF
					$currentUsername = $_SESSION["username"];

					$track_name = $_POST["track-name"];
					$hashtag_one = $_POST["hashtag-one-input"];
					$hashtag_two = $_POST["hashtag-two-input"];
					$track_url = $url;

					/*ini_set('display_errors', '1');
					error_reporting(E_ALL); //use for error reporting */
					

					$sql1 = "SELECT `uid` FROM Users WHERE `username` = '$currentUsername'";

					$resultObjectUID = mysqli_query($dbc,$sql1);

					$row = mysqli_fetch_array($resultObjectUID, MYSQLI_NUM);
					$userid = $row[0];

			  		$sql2 = "INSERT INTO Tracks (track_name,userid,hashtag_one,hashtag_two,track_url) VALUES ('$track_name','$userid','$hashtag_one','$hashtag_two','$track_url');";
					mysqli_query($dbc,$sql2); 




				}

	    header("Location: https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/LoggedInObserver.php");
    	exit;	



?>