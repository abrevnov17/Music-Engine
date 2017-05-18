<!DOCTYPE HTML>
<html>
    <head>
        <title>Music Engine</title>
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel='stylesheet' type='text/css' href='stylesheet.css'/>	
    </head>
    
    <body id="welcome-body">
        <h1>Create an account.</h1>
        <form action="createAccount.php" method="POST">
            <input type="text" name="username" placeholder="username (no spaces)" maxlength="20" class="text-input"></input><br>
            <input type="email" name="email" placeholder="email" maxlength="35" class="text-input"></input><br>
            <input type="password" name="password" placeholder="password" maxlength="50" class="text-input"></input><br>
            <input type="text" name="bio" placeholder="bio (optional)" maxlength="100" class="text-input"></input><br>
            <input type="submit" id="artist-submit-button" value="Submit"></input>
        </form>
        
        <!-- need to add javascript script that prevents users from entering spaces in the username field -->   
        
    </body>
</html>