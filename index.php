<?php
session_start();
include_once '_user.php';
include_once 'includes/functions.php';
$user = new USER(); 
$functions = new FUNCTIONS();



if (isset($_SESSION['user_id']))
	$user_id = $_SESSION['user_id'];

	 
	if (isset($_GET['q'])){
		 $user->user_logout();
		 header("Location:login.php"); 
		}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>GAME MEM | FUNNY IMAGES</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">GAME MEM</a>
          <p class="navbar-text navbar-right">Witaj <?php if(isset($_SESSION['user_id'])) $functions->get_single_value($user_id,"user_name"); else echo "nieznajomy"; ?></p>
        </div>
        <div id="navbar" class="navbar-collapse collapse ">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php">GŁÓWNA</a></li>
            <li><a href="#">POCZEKALNIA</a></li>
            <li><a href="#">TOP 10</a></li>
            <li><a href="#">LOSUJ</a></li>
            <?php
            
            if(isset($_SESSION['user_id'])){
              echo '
              <li><a href="#">DODAJ</a></li>
              <li><a href="index.php?q=logout">WYLOGUJ</a></li>';
            }else{
              echo '
              <li><a href="login.php">ZALOGUJ</a></li>
              <li><a href="register.php">REJESTRACJA</a></li>';
            }

            ?>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container text-center" style="margin-top:80px;">
    <div class="jumbotron">
      <img src="img/sample_photo.jpg" class="img-responsive" style="margin:0 auto"><br><br>
      <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span></button>
      <button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></button>
    </div>
    <div class="jumbotron">
      <img src="img/sample_photo.jpg" class="img-responsive" style="margin:0 auto"><br><br>
      <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span></button>
      <button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></button>
    </div>
    <div class="jumbotron">
      <img src="img/sample_photo.jpg" class="img-responsive" style="margin:0 auto"><br><br>
      <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span></button>
      <button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></button>
    </div>
    <div class="jumbotron">
      <img src="img/sample_photo.jpg" class="img-responsive" style="margin:0 auto"><br><br>
      <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span></button>
      <button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></button>
    </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>