<!DOCTYPE html>
<html lang="en">
<head>
  <title>HappyNewsSadNews</title>
  <meta charset="utf-8">
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--css file using bootstrap from an example in class-->
    <link rel="stylesheet" href="../style.css">
    <script src="http://code.jquery.com/jquery-3.1.0.min.js"
            integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>
    <script type="text/javascript"
            src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
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
            <a type="button" class="button m-lg-1 btn btn-happy" href="Login.php">Login</a>
            <a type="button" class="button m-lg-1 btn btn-happy disabled" href="">Create Account</a>
        </div>
    </nav>
    <div class="signUp">
        <form method="get">
            <h1 class="h1 mb-3 font-weight-normal">Sign Up</h1>
            <input type="text" name="username" class="form-control" id="f-usernameNew" placeholder="Username"/>
            <br/>
            <input type="password" name="password" class="form-control" id="f-passwordNew" placeholder="Password"/>
            <br/>
            <input type="submit" value="Create Account" class="btn btn-lg btn-primary btn-block"/>
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
	  
	  
		if( $_SERVER['REQUEST_METHOD'] === 'GET' ){
			if( !isset($_GET["username"]) || !isset($_GET["password"]) ){
				//echo("You need both a username and a password");
			}
			else{
				//get vars from the form input
				$user = $_GET["username"];
				$pass = $_GET["password"];
				//$sQuest = $_GET["secQuest"];
				//$sAnsw = $_Get["secAnsw"];
			  
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
			  
				// Check connection
				if ($conn->connect_errno) {
					echo("Database failure");
				}
				else {
					//check if username is unique
					$stmt = $conn->prepare("SELECT * from users WHERE username = ?");
					$stmt->bind_param("s",$user);
					$stmt->execute();
					
					$result = $stmt-> get_result();
					$resultArr = $result->fetch_assoc();
					
					if ($resultArr != NULL){
						echo("username is taken");
						exit();
					}
					
					
					//check if password is longer than 5 characters
					$passLen = strlen($pass);
					if ($passLen < 5){
						echo("password must be longer than 5 characters.");
						exit();
					}
					
					
					$stmt = $conn->prepare("INSERT INTO users (username, password) 
					VALUES (?,?)");
					$stmt->bind_param("ss",$user,$pass);//,$sQuest,$sAnsw);
					$stmt->execute();
					
					//echo("account added sucessfully!");
					
					session_regenerate_id();
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['name'] = $user;

					//echo " " . $Uusername . " " . $UHappyOrSad . " " . $UFavTone;
					
					echo "<script type='text/javascript'>console.log('Account Created');</script>";
					header('Location: ../index.php');
					exit();
					
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
   
   