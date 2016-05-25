<?php 
	include_once '_user.php';
	$user = new USER();

	if (isset($_REQUEST['submit']))
	{
	extract($_REQUEST);
	$new_pass= mysql_real_escape_string($_POST['newpass']);  
	$new_pass2= mysql_real_escape_string($_POST['newpass2']);  

	
		if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['q']) && !empty($_GET['q']))
		{	
			$email = mysql_escape_string($_GET['email']);
			$hash = mysql_escape_string($_GET['q']);   
			$check=$user->change_password($email,$new_pass,$new_pass2,$hash);
			if ($check === TRUE)
			{
				echo 'Twoje hasło zostało zmienione';
				header('Refresh: 2; URL=login.php'); 
			}
			else
				echo $check;
		}
		else
			echo $check;
		
	}


	?>
	
<!DOCTYPE html>
<html lang="pl">

  <body>
		<form action="" method="post" name="reset_pass">
			<div class="col-md-4 col-md-offset-4 form-group">
			  <input type="password" class="form-control" placeholder="Nowe hasło" name="newpass" required="">
			</div>
			<div class="col-md-4 col-md-offset-4 form-group">
			  <input type="password" class="form-control" placeholder="Powtórz hasło" name="newpass2" required="">
			</div>
			<div class="col-md-1 col-md-offset-4 form-group">
  			  <button type="submit" class="btn btn-default" onclick="return(submitreset_pass());" name="submit" >Zmień hasło</button>
  			</div>
			
		</form>
  </body>
</html>