<?php

class FUNCTIONS{
	public $db;
		public function __construct(){
			$this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
 
			if(mysqli_connect_errno()) {
				echo "Brak połączenia z bazą danych.";
			        exit;
		}
	}


public function get_single_value($user_id,$quest)
{
			$sql="SELECT $quest FROM users WHERE user_id = $user_id";
	        $result = mysqli_query($this->db,$sql);
	        $user_data = mysqli_fetch_array($result);
	        echo $user_data[$quest];
}

	public function send_email($user_name,$email,$subject,$content)
		{
			require_once('includes/class.phpmailer.php');
				include("includes/class.smtp.php");
				$mail = new PHPMailer(true);
				$mail->IsSMTP(); 
				$mail->SMTPAuth   = true;                 
				$mail->SMTPSecure = "tls";                
				$mail->Host       = "smtp.live.com";      
				$mail->Port       = 587;                 
				$mail->Username   = "loboo1991k@windowslive.com"; 
				$mail->Password   = "qweQWE123";   				
				$mail->AddAddress($email, $user_name);
				$mail->SetFrom('loboo1991k@windowslive.com', 'Admin');
				$mail->Subject = $subject;
				$mail->Body = $content;
				$mail->Send();
				if($mail->Send())
					return 1;
				else	
					return 0;
		}
}
		?>