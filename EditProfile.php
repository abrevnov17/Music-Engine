<?php 
	session_start();

	if(!isset($_SESSION["username"])){ 
    	header("Location: https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/Home.php");
    	exit;
	}

?> 
<!DOCTYPE HTML>
<html>
	<head>
		<title>Music Engine</title>
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel='stylesheet' type='text/css' href='stylesheet.css'/>	
		<script src="functions.js"></script>		
	</head>
	<body>
		<!-- hidden (initally) pop-up view to upload a track -->
		<div id = "pop-up">
			<h1>Upload a track.</h1>
			<button id="x-out-button" type="button" onclick="closePopUp()">x</button>
			<form name="upload" action="uploadTrack.php" method="POST" enctype="multipart/form-data">
            	<input type="text" name="track-name" placeholder="track name" maxlength="35" class="pop-up-input"></input><br>
            	<input type="text" name="hashtag-one-input" placeholder="#tag" maxlength="15" class="pop-up-input"></input><br>
            	<input type="text" name="hashtag-two-input" placeholder="#tag" maxlength="15" class="pop-up-input"></input><br>
            	<input type="file" name="file-upload" value="Choose File" class="pop-up-file-input"></input><br>
            	<input type="submit" id="pop-up-submit-button" value="Submit"></input>
        </form>
		</div>
		<!-- navigation bars -->
		<div id = "menubar">
			<a href="LoggedInObserver.php">Music Engine</a>
		</div>
		<div id = "leftbar">
			<ul>
				<li onmousedown='changeColor(this.id)' id="popular" class="leftButton">Profile</li>
			</ul>
		</div>
		
		<!-- feed -->
		<div id = "feed">
		<audio id="currentSong">
  			<source src='track_uploads/Mike_B_Fort_-_04_-_Mike_B_Fort_-_Ocean_Floor' type="audio/mpeg">
		</audio>
		<?php 
			$dbc= mysqli_connect("localhost", "abrevnov17", "abrevnov171234", "abrevnov17");

			if(!$dbc){ // there was an error connecting
				echo "Failed to connect to the database.  Error=".mysqli_connect_error();
			}
			else {
				$currentUsername = $_SESSION["username"];
				
				$sql1 = "SELECT `uid` FROM Users WHERE `username` = '$currentUsername'";
				$resultObjectUID = mysqli_query($dbc,$sql1);
				$row = mysqli_fetch_array($resultObjectUID, MYSQLI_NUM);
				$userid = $row[0];

				$sql2 = "SELECT `trackid` FROM Tracks WHERE `userid` = '$userid'";
				$resultObjectUIDFinal = mysqli_query($dbc,$sql2); 

				$num_rows = mysqli_num_rows($resultObjectUIDFinal);

				  
				//echo '<script>console.log("hi:'.$row2[0].'")</script>';

				for ($i = 0; $i < $num_rows; $i++){
					$row = mysqli_fetch_array($resultObjectUIDFinal, MYSQLI_NUM);

					$trackid = $row[0];

					$sql3 = "SELECT `track_name` FROM Tracks WHERE `trackid` = '$trackid'";
					$resultObjectUID = mysqli_query($dbc,$sql3);
					$row = mysqli_fetch_array($resultObjectUID, MYSQLI_NUM);
					$track_name = $row[0];

					$sql3 = "SELECT `hashtag_one` FROM Tracks WHERE `trackid` = '$trackid'";
					$resultObjectUID = mysqli_query($dbc,$sql3);
					$row = mysqli_fetch_array($resultObjectUID, MYSQLI_NUM);
					$hashtag_one = $row[0];

					$sql3 = "SELECT `hashtag_two` FROM Tracks WHERE `trackid` = '$trackid'";
					$resultObjectUID = mysqli_query($dbc,$sql3);
					$row = mysqli_fetch_array($resultObjectUID, MYSQLI_NUM);
					$hashtag_two = $row[0];

					$sql3 = "SELECT `track_url` FROM Tracks WHERE `trackid` = '$trackid'";
					$resultObjectUID = mysqli_query($dbc,$sql3);
					$row = mysqli_fetch_array($resultObjectUID, MYSQLI_NUM);
					$track_url = $row[0];
					
					$sql3 = "SELECT `track_name` FROM Tracks WHERE `trackid` = '$trackid'";
					$resultObjectUID = mysqli_query($dbc,$sql3);
					$row = mysqli_fetch_array($resultObjectUID, MYSQLI_NUM);
					$track_name = $row[0];
					
					$sql1 = "SELECT `email` FROM Users WHERE `username` = '$currentUsername'";
					$resultObjectUID = mysqli_query($dbc,$sql1);
					$row = mysqli_fetch_array($resultObjectUID, MYSQLI_NUM);
					$email = $row[0];

					echo"
					<div id = 'feed-element'>
						<form action='deleteTrack.php' method='POST'>
							<button class='username-button' type='button'>@".$currentUsername."</button>
							<button class='hashtag-one-button' type='button'>".$hashtag_one."</button>
							<button class='hashtag-two-button' type='button'>".$hashtag_two."</button>
							<button class='play-button' id='play-button".$i."' type='button' onclick='changeImage(this.id,\"".$track_url."\")'></button>
							<input type='hidden' name='actionResult' id='actionResult' value='".$trackid."'></input>
							<input type='submit' class='delete-button' id='delete".$i."' type='button' value='x'></input>
							<button class='song-name-button' type='button'>".$track_name."</button>
							<button class='email-button' type='button'>Contact: ".$email."</button>
						</form>
					</div>";
				}

			}


		
		?>

		</div>
	</body>
</html>