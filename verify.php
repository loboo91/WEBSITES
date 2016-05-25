<?php 
	include_once '_user.php';
	$user = new USER();

	if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
	{
		$email = mysql_escape_string($_GET['email']);
		$hash = mysql_escape_string($_GET['hash']);       
		$result=$user->verify($email,$hash);
		header('Refresh: 2; URL=login.php'); 
	}
	
?>