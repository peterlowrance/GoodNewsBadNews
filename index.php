
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Happy Sad News</title>
    <!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
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
    <script src="scripts/sentiment.js"></script>
    <script src="scripts/fetchNews.js"></script>
    <script src="scripts/loadPage.js"></script>
	

</head>
<body id="body">

<!-- checks if the user is logged in -->
	<?php
	session_start();
	if (isset($_SESSION['loggedin'])) {
		//If the user is logged in put in their home page preferences here
		echo '<script type = "text/javascript">
		console.log("logged in");
		</script>';
	}
	else{
		echo '<script type = "text/javascript">
		console.log("not logged in");
		</script>';
	}
	?>

    <nav id="topBar" class="navbar navbar-expand-md navbar-light happyTop">
        <a class="p-0 mr-lg-3 mr-1 navbar-brand" href="index.php">Good News Bad News</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="mx-auto navbar-nav mr-auto">
                <input id="toggle" type="checkbox" checked data-toggle="toggle" data-on="Happy" data-off="Sad"
                       data-onstyle="happyToggle" data-offstyle="sadToggle">
            </div>
            <a id="userButton" type="button" class="m-lg-1 button btn btn-happy" href="userPage.html">User Page</a> <!--disabled-->
            <a type="button" class="m-lg-1 button btn btn-happy" href="scripts/Login.php">Login</a>
            <a type="button" class="m-lg-1 button btn btn-happy" href="scripts/NewUser.php">Create Account</a>
        </div>
    </nav>



    <div class="content container-fluid">
        <div id="news" class="row">
            <!--Large Article-->
            <div id="largeArticle" class="float-left"></div>
        </div>
    </div>

	
</body>
</html>
