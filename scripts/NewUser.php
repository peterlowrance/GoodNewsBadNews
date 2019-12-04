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
	  
	  
		if( $_SERVER['REQUEST_METHOD'] === 'GET' ){
			if( !isset($_GET["username"]) || !isset($_GET["password"]) ){
				echo("You need both a username and a password");
			}
			else{
				//get vars from the form input
				$user = $_GET["username"];
				$pass = $_GET["password"];
				$sQuest = $_GET["secQuest"];
				$sAnsw = $_Get["secAnsw"];
			  
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
			  
				// Check connection
				if ($conn->connect_errno) {
					echo("Database failure");
				}
				else {
					
					$stmt = $conn->prepare("INSERT INTO users (username, password, securityQuestion, securityAnswer) 
					VALUES (?,?,?,?)");
					$stmt->bind_param("ssss",$user,$pass,$sQuest,$sAnsw);
					$stmt->execute();
					
					echo("account added sucessfully!");
					
					session_regenerate_id();
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['name'] = $user;
					$_SESSION['id'] = $user;
					//echo " " . $Uusername . " " . $UHappyOrSad . " " . $UFavTone;
					
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
   
   