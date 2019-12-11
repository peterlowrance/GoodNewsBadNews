<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>User Page</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
			  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<!--css file using bootstrap from an example in class-->
		<link rel="stylesheet" href="style.css">
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

		<script src="scripts/sentimentColors.js"></script>
	</head>
		<body id = "body">
		<nav id="topBar" class="navbar navbar-expand-md navbar-light happyTop">
			<a class="p-0 mr-lg-3 mr-1 navbar-brand" href="index.php">Good News Bad News</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<div class="mx-auto"></div>
				<a id="userButton" type="button" class="m-lg-1 button btn btn-happy" href="userPage.php">User Page</a>
				<!--disabled-->
				<a id="loginButton" type="button" class="m-lg-1 button btn btn-happy" href="scripts/Login.php">Login</a>
				<a type="button" class="button m-lg-1 btn btn-happy disabled" href="scripts/NewUser.php">Create Account</a>
			</div>
		</nav>
		<div class="container d-flex">
        <div class="flex-column mx-auto text-center">
            <h1 class="h1 font-weight-normal">Login</h1>
            <div class="card mx-5" style="width:25rem;">
                <div class="card-header p-2">
                    <h5>Password Recovery</h5>
                </div>
                <div class="card-body">
					<form method="get">
						<p>Please enter the answer to the security question below</p>
						<?php
							$servername = "127.0.0.1";
							$username = "root";
							$password = "";
							$dbname = "happysadnews";
							
							session_start();
							
							$conn = new mysqli($servername, $username, $password, $dbname);
			  
							// Check connection
							if ($conn->connect_errno) {
								echo("Database failure");
							}
							else{
								$stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
								$stmt->bind_param("s",$_SESSION["name"]);
								$stmt->execute();
								$result = $stmt -> get_result();
								$secQuest;
								while($row = $result->fetch_assoc()){
									$secQuest = $row["securityQuestion"];
								}
								echo"<br/><p>". $secQuest ."</p>";
							}
						?>
						<input type="text" name="secAnswer" class="form-control" id="f-secAnswer" placeholder="Answer"/>
						<br/>
						<p>Please enter a new password</p>
						<input type="password" name="newPassword" class="form-control" id="f-newPassword" placeholder="New Password"/>
						<br/>
						<input type="submit" value="Change Password" class="btn btn-primary btn-block"/>
					</form>
                </div>
            </div>
        </div>
    </div>
	<?php
	
		$servername = "127.0.0.1";
		$username = "root";
		$password = "";
		$dbname = "happysadnews";
		
		if( !isset($_GET["secAnswer"]) || !isset($_GET["newPassword"]) ){
			//dont do anything
		}
		else{
			//get vars
			$secAnswer = $_GET["secAnswer"];
			$newPass = $_GET["newPassword"];
			
			$conn = new mysqli($servername, $username, $password, $dbname);
			  
			// Check connection
			if ($conn->connect_errno) {
				echo("Database failure");
			}
			else{
				$stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
				$stmt->bind_param("s",$_SESSION["name"]);
				$stmt->execute();
				$result = $stmt -> get_result();
				
				while($row = $result->fetch_assoc()){
					//echo $row["username"] . $row["securityQuestion"] . $row["securityAnswer"];
					if ($secAnswer == $row["securityAnswer"]){
						if (strlen($newPass) >= 5){
							$stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
							$stmt->bind_param("ss",$newPass,$_SESSION["name"]);
							$stmt->execute();
							echo "password changed successfully";
						}
						else{
							echo "password must be longer than five letters";
						}
					}
				}
			}
		}
	?>
	</body>
</html>