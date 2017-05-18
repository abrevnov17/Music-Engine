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
			<button id="edit-profile-button" type="button" onclick="location.href = 'https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/EditProfile.php'">Edit Profile</button>
			<button id="log-out-button" type="button" onclick="location.href = 'https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/logout.php'">Log Out</button>
			<button id="upload-button" type="button" onclick="openPopUp()">Upload Track</button>
		</div>
		<div id = "leftbar">
			<ul>
				<li onmousedown='changeColor(this.id)' onclick="location.href = 'https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/changeToPopular.php'" id="popular" class="leftButton">Popular</li>
				<li onmousedown="changeColor(this.id)" onclick="location.href = 'https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/changeToNew.php'" id="new" class="leftButton">New</li>
				<li onmousedown="changeColor(this.id)" onclick="location.href = 'https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/changeToRap.php'" id="rap" class="leftButton">#rap</li>
				<li onmousedown="changeColor(this.id)" onclick="location.href = 'https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/changeToPop.php'" id="pop" class="leftButton">#pop</li>
				<li onmousedown="changeColor(this.id)" onclick="location.href = 'https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/changeToEDM.php'" id="EDM" class="leftButton">#edm</li>
				<li onmousedown="changeColor(this.id)" onclick="location.href = 'https://csweb.sidwell.edu/~student/abrevnov17/Music%20Engine/changeToAlternative.php'" id="alternative" class="leftButton">#alternative</li>

				<!-- below is necessary to ensure that the right category is blued-out -->
				<?php echo "<script type='text/javascript'>"."setInitialCategory('".$_SESSION["lastCategoryClicked"]."');"."</script>" ?>
			</ul>
		</div>
		
		<!-- feed -->
		<div id = "feed">
		<audio id="currentSong">
  			<source type="audio/mpeg">
		</audio>
		<?php 
			$dbc= mysqli_connect("localhost", "abrevnov17", "abrevnov171234", "abrevnov17");

			if(!$dbc){ // there was an error connecting
				echo "Failed to connect to the database.  Error=".mysqli_connect_error();
			}
			else {

				if ($_SESSION["lastCategoryClicked"] == "pop"){
					$sql2 = "SELECT `trackid` FROM Tracks WHERE hashtag_one='#pop' OR hashtag_two='#pop'";

				}
				else if ($_SESSION["lastCategoryClicked"] == "rap"){
					$sql2 = "SELECT `trackid` FROM Tracks WHERE hashtag_one='#rap' OR hashtag_two='#rap'";

				}
				else if ($_SESSION["lastCategoryClicked"] == "EDM"){
					$sql2 = "SELECT `trackid` FROM Tracks WHERE hashtag_one='#edm' OR hashtag_two='#edm'";

				}
				else if ($_SESSION["lastCategoryClicked"] == "alternative"){
					$sql2 = "SELECT `trackid` FROM Tracks WHERE hashtag_one='#alternative' OR hashtag_two='#alternative'";

				}
				else if ($_SESSION["lastCategoryClicked"] == "new"){
					$sql2 = "SELECT `trackid` FROM Tracks ORDER BY `timestamp` DESC LIMIT 0, 30";

				}
				else {
					$sql2 = "SELECT `trackid` FROM Tracks ORDER BY `likes` DESC LIMIT 0, 30";

				}

				$resultObjectUIDFinal = mysqli_query($dbc,$sql2); 

				$num_rows = mysqli_num_rows($resultObjectUIDFinal);


				for ($i = 0; $i < $num_rows; $i++){
					$row = mysqli_fetch_array($resultObjectUIDFinal, MYSQLI_NUM);
					$trackid = $row[0];
					
					$sql3 = "SELECT `userid` FROM Tracks WHERE `trackid` = '$trackid'";
					$resultObjectUID = mysqli_query($dbc,$sql3);
					$row = mysqli_fetch_array($resultObjectUID, MYSQLI_NUM);
					$uid = $row[0];
					
					$sql3 = "SELECT `username` FROM Users WHERE `uid` = '$uid'";
					$resultObjectUID = mysqli_query($dbc,$sql3);
					$row = mysqli_fetch_array($resultObjectUID, MYSQLI_NUM);
					$currentUsername = $row[0];

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




					echo"<div id = 'feed-element'>
						<button class='username-button' type='button'>@".$currentUsername."</button>
						<button class='like-button' onclick='changeLikeImage(\"".$trackid."\")' id='like-button".$trackid."' type='button'></button>
						<button class='hashtag-one-button' type='button'>".$hashtag_one."</button>
						<button class='hashtag-two-button' type='button'>".$hashtag_two."</button>
						<button class='play-button' id='play-button".$i."' type='button' onclick='changeImage(this.id,\"".$track_url."\")'></button>
						<button class='song-name-button' type='button'>".$track_name."</button>
						<button class='email-button' type='button'>Contact: ".$email."</button>
					</div>";

					//here I check whether the like button should be liked or unliked upon initiliazition 
					$sql1 = "SELECT `timestamp` FROM Likes WHERE `trackid` = '$trackid' AND `userid` = '$uid'";
					$query = mysqli_query($dbc,$sql1);
  					if (mysqli_num_rows($query) != 0){
  						//have already liked
  						 echo "<script type='text/javascript'>"."likeImageInitialToUnlike('like-button".$trackid."');"."</script>";

  					}
  					else {
  						 echo "<script type='text/javascript'>"."likeImageInitialToLike('like-button".$trackid."');"."</script>";
  					}
				}

			}


		
		?>

		</div>
	</body>
</html>