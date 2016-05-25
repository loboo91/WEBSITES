<?php 
	include_once '_user.php';
	$user = new USER();
	
		if (isset($_REQUEST['submit']))
			{
				extract($_REQUEST);
				$user_name = mysql_real_escape_string($_POST['username']);
				$reset_pass=$user->reset_pass($user_name);
			}	
	?>
	
	
	
<!DOCTYPE html>
<html lang="pl">

  <body>
		<form action="" method="post" name="reset_pass">
			<div class="col-md-4 col-md-offset-4 form-group">
			  <input type="text" class="form-control" placeholder="Nazwa użytkownika" name="username" required="">
			</div>
			<div class="col-md-1 col-md-offset-4 form-group">
  			  <button type="submit" class="btn btn-default" onclick="return(submitreset_pass());" name="submit" >Wyślij</button>
  			</div>
			<div class="col-md-12 text-center form-group">
	    
	        </div>
		</form>
  </body>
</html>