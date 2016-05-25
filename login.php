<?php
session_start();
	include_once '_user.php';
	$user = new USER();

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
          <p class="navbar-text navbar-right">Witaj <?php if(isset($_SESSION['user_id'])) $user->get_user_name($user_id); else echo "nieznajomy"; ?></p>
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
 
      <h1>LOGOWANIE</h1><br>

      <p>
        <?php 
	
	if (isset($_REQUEST['submit'])) {
		extract($_REQUEST);
			$check = $user->check_login($email_username, $password);
			if ($check===TRUE) {
			   header('Location: index.php');
			} else {
				echo $check;
			}
		}
        ?>
      </p>
  		
  		<form  class="row" action="" method="post" name="login">

  			<div class="col-md-4 col-md-offset-4 form-group">
  			  <input type="text" class="form-control" id="inputEmail3" placeholder="Nazwa użytkownika / Email" name="email_username" required="">
  			</div>

  			<div class="col-md-4 col-md-offset-4 form-group">
  			  <input type="password" class="form-control" id="inputPassword3" placeholder="Hasło" name="password" required="">
  			</div>
  		  
  			<div class="col-md-1 col-md-offset-4 form-group">
  			  <button type="submit" class="btn btn-default" onclick="return(submitlogin());" name="submit" >Zaloguj</button>
  			</div>

        <div class="col-md-12 text-center form-group">
          Nie masz jeszcze konta? <a href="register.php"> Zarejestruj się!</a>
        </div>
		  <div class="col-md-12 text-center form-group">
          <a href="reset_pass.php">Nie pamiętasz hasła?  </a>
        </div>
  		
      </form>
    
    </div>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>