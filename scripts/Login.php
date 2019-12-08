<!DOCTYPE html>
<html lang="en">
<head>
  <title>HappyNewsSadNews</title>
  <meta charset="utf-8">
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <script src="http://code.jquery.com/jquery-3.1.0.min.js"
            integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>
    <script type="text/javascript"
            src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script src="sentimentColors.js"></script>
  
</head>
<body class="text-center" id="body">
    <nav id="topBar" class="navbar navbar-expand-md navbar-light happyTop">
        <a class="p-0 mr-lg-3 mr-1 navbar-brand" href="../index.php">Good News Bad News</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="mx-auto"></div>
            <a id="userButton" type="button" class="button btn btn-happy disabled" href="">User Page</a>
            <!--disabled-->
            <a type="button" class="button m-lg-1 btn btn-happy disabled" href="">Login</a>
            <a type="button" class="button m-lg-1 btn btn-happy" href="NewUser.php">Create Account</a>
        </div>
    </nav>
    <div class="login">
        <form method="get" class="form-signin">
            <h1 class="h1 mb-3 font-weight-normal">Log in</h1>
            <input type="text" name="username" class="form-control" id="f-usernameLogin" placeholder="Username"/>
            <br/>
            <input type="password" name="password" class="form-control" id="f-passwordLogin" placeholder="Password"/>
            <br/>
            <input type="submit" value="Login" class="btn btn-lg btn-primary btn-block"/>
        </form>
        <br/>
    </div>
	
	
	<?php

	session_start();

	  // DB connection parameters
	  $servername = "127.0.0.1";
	  $username = "root";
	  $password = "";
	  $dbname = "happysadnews";
	  
	  //vars for the user
	  $Uusername = "";
	  $UHappyOrSad = 0;
	  $UFavTone = "";
	  
	  
	  
		if( $_SERVER['REQUEST_METHOD'] === 'GET' ){
			if( !isset($_GET["username"]) || !isset($_GET["password"]) ){
				//echo
			}
			else{
				//get vars from the form input
				$user = $_GET["username"];
				$pass = $_GET["password"];
			  
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
			  
				// Check connection
				if ($conn->connect_errno) {
					echo("Database failure");
				}
				else {
					
					$stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
					$stmt->bind_param("ss",$user,$pass);
					$stmt->execute();
					
					$result = $stmt-> get_result();
					
					$row;

					while($row = $result->fetch_assoc()){
						 
						
						//get the user's relevant info
						$Uusername = $row["username"];
						$UHappyOrSad = $row["HappyOrSad"];
						$UFavTone = $row["FavoriteTone"];
						$UQuestion = $row["securityQuestion"];
						$UAnswer = $row["securityAnswer"];
						
						session_regenerate_id();
						$_SESSION['loggedin'] = TRUE;
						$_SESSION['name'] = $Uusername;
						$_SESSION['faveTone'] = $UFavTone;
						$_SESSION['happyorsad'] = $UHappyOrSad;
						$_SESSION['question'] = $UQuestion;
						$_SESSION['answer'] = $UAnswer;
						
						header('Location: ../index.php');
						exit();
					}
					
					if ($row == 0){
						echo ("Login failed. Please check your credentials are correct.");

					}
						
					
					$stmt->close();
					$conn->close();
					
			}
		}
		}
		else{
		  echo("No GET request received.");
		}
	  
	   ?>
	
</body>
</html>


