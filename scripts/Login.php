<!DOCTYPE html>
<html lang="en">
<head>
  <title>HappyNewsSadNews</title>
  <meta charset="utf-8">
</head>
<body>
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
				echo("You need both a username and a password");
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
					
					//get rows from result
					//$check = $result->fetch_assoc();
					//if($check < 1){
						//echo "Login failed";
					//}
					$row;

					while($row = $result->fetch_assoc()){
						 
						
						//get the user's relevant info
						$Uusername = $row["username"];
						$UHappyOrSad = $row["HappyOrSad"];
						$UFavTone = $row["FavoriteTone"];
						
						session_regenerate_id();
						$_SESSION['loggedin'] = TRUE;
						$_SESSION['name'] = $Uusername;
						$_SESSION['id'] = $Uusername;
						//echo " " . $Uusername . " " . $UHappyOrSad . " " . $UFavTone;
						
						echo "Welcome " . $_SESSION["name"] . "!";
						exit;
					}
					
					//$check = $result->fetch_assoc();
					if ($row == 0){
						echo ("login failed");
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