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
<body id="body">
	<?php
    session_start();

    // DB connection parameters
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "happysadnews";

    if( $_SERVER['REQUEST_METHOD'] === 'GET' ){
        if(isset($_GET["keywords"])) {
            //get vars from the form input
            $keywords = $_GET["keywords"];
            $user = $_SESSION["name"];

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_errno) {
                echo("Database failure");
            } else {

                $stmt = $conn->prepare("UPDATE users SET blacklist=? WHERE username=?");
                $stmt->bind_param("ss", $keywords, $user);
                $status = $stmt->execute();

                if($status == 1){
                    $_SESSION["blacklist"] = $keywords;
                    $hs = 1;
                    if(isset($_GET["happyorsad"])){
                        $hs = 0;
                    }
                    $stmt = $conn->prepare("UPDATE users SET HappyOrSad=? WHERE username=?");
                    $stmt->bind_param("is", $hs, $user);
                    $status2 = $stmt->execute();
                    if($status2 == 1){
                        $_SESSION["happyorsad"] = $hs;
                        echo '<script>$(document).ready(function(){$("#settingsCard").append("<p>Saved</p>")})</script>';
                    }
                    else{
                        echo "Unable to update user settings";
                    }
                }
                else{
                    echo "Unable to update user settings";
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
    <nav id="topBar" class="navbar navbar-expand-md navbar-light happyTop">
        <a class="p-0 mr-lg-3 mr-1 navbar-brand" href="index.php">Good News Bad News</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="mx-auto"></div>
            <a id="userButton" type="button" class="button btn btn-happy disabled" href="">User Page</a>
            <!--disabled-->
            <a type="button" class="button m-lg-1 btn btn-happy disabled" href="Login.php">Login</a>
            <a type="button" class="button m-lg-1 btn btn-happy disabled" href="NewUser.php">Create Account</a>
        </div>
    </nav>
    <div class="container d-flex">
        <div class="flex-column mx-auto text-center">
            <h1 class="h1 font-weight-normal">User Page</h1>
            <div class="card mx-5" style="width:25rem;">
                <div class="card-header p-2">
                    <h5>Profile</h5>
                </div>

                <div class="card-body">
                    <p id = "usernameDisplay">Username: <?php echo "<a>" . $_SESSION['name'] . "</a>"; ?></p>
                    <a type="submit" value="Create Account" class="btn btn-primary" href="passwordReset.php">Change Password</a>
                </div>
            </div>

            <div class="card mx-5 my-2" style="width:25rem;">
                <div class="card-header p-2">
                    <h5>Settings</h5>
                </div>
                <div class="card-body px-3" id="settingsCard">
                    <form method="get">
                        <p>Exclude articles with keywords (comma separated):</p>
                        <textarea class="form-control" name="keywords" id="f-usernameNew" placeholder="Keywords"></textarea>
						<?php
						$blacklist = $_SESSION['blacklist'];
						echo'<script>console.log("Value:'.$blacklist.'")</script>';
						if ($blacklist){
                            echo'<script>$(document).ready(function(){$("#f-usernameNew").val("'. $blacklist .'")});</script>';
                        }
						?>
                        <br/>
                        <p>Default sentiment:</p>
                        <input id="toggle" name="happyorsad" type="checkbox" checked data-toggle="toggle" data-on="Happy" data-off="Sad"
                               data-onstyle="happyToggle" data-offstyle="sadToggle">

                        <br/>
                        <br/>
                        <input type="submit" value="Save" class="btn btn-primary btn-block"/>
                    </form>
                </div>
            </div>
        </div>
    </div>



</body>
</html>
