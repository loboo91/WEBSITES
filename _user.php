<?php
include "_config.php";

		/* KONFIGURACJA MAILA */
require 'includes/PHPMailerAutoload.php';
ini_set('default_charset', 'UTF-8');
		
	class USER{
	public $db;
		public function __construct(){
			$this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
 
			if(mysqli_connect_errno()) {
				echo "Brak polączenia z bazą danych.";
			        exit;
			}
		}

		/* ETAP REJESTRACJI */
		public function register_user($user_name,$password, $password2, $email){
			if ($password === $password2 )
				{
					if (strlen($password)>=6)
					{											
						if ((strlen($user_name)>=4)&&(preg_match("/^[a-zA-Z0-9.\-_ ]*$/",$user_name)))
						{
							$password = md5($password);
							$sql="SELECT * FROM users WHERE user_name='$user_name' OR user_email='$email'";
							
							// SPRAWDZA CZY UŻYTKOWNIK ISTNIEJE W BAZIE DANYCH
							$check =  $this->db->query($sql) ;
							$count_row = $check->num_rows;
							
							// DODAJE UŻYTKOWNIKA DO BAZY
							if ($count_row == 0){
								$sql1="INSERT INTO users SET user_name='$user_name', user_pass='$password', user_email='$email'";
								$result = mysqli_query($this->db,$sql1) or die(mysqli_connect_errno()."Problem z zapisem do bazy");
								return TRUE;
							}
							else { return $error= 'Nazwa użytkownika lub email już istnieje';}
						}
						else 
							return $error= 'Nazwa użytkownika jest za krótka, lub posiada niedozwolone znaki';
					}
					else
						return $error= 'Podane haslo jest za krótkie';
				}
			else return $error= 'Hasla się nie zgadzają';
		}
		
		
		// WALIDACJA E-MAIL'A
		public function validate_email($email)
		{	
			if (strlen($email)<40 && strlen($email)>6) 
			{
				$check_email= '/^[a-zA-Z0-9.\-_]+@[a-zA-Z0-9\-.]+\.[a-zA-Z]{2,4}$/';
				if(preg_match($check_email, $email)) 
					{
					if(filter_var($email, FILTER_VALIDATE_EMAIL))
						return TRUE;

					list($prefix,$domain)=split('@',$email);
					if(checkdnsrr($domain,'MX')) 
						return TRUE;
					else
						return $error='Podany adres e-mail nie istnieje! ';
					}
				else return $error='Zły format email\'a ';
			}
			else return $error='Podany adres e-mail posiada niewłaściwe ilość znaków ';
			
		}
		
		// WYSLANIE LINKU AKTYWACJYNEGO
		public function verify_email($user_name,$email)
		{
			$activation_key=md5(rand(0,1000));
			$sql4="UPDATE users SET link_activation='".mysql_escape_string($activation_key)."' WHERE user_email='$email'";
			$result = mysqli_query($this->db,$sql4) or die(mysqli_connect_errno()."Problem z zapisem do bazy");
			if ($result)
			{ 		
				$sql7="SELECT * FROM settings";
				$result2=mysqli_query($this->db,$sql7);
				$settings= mysqli_fetch_array($result2);

				$mail = new PHPMailer(true);
				
				$mail->IsSMTP(); 	
				$mail->SMTPAuth   = true;     
				$mail->CharSet    = "UTF-8";				
				$mail->SMTPSecure = "tls";                
				$mail->Host       = "smtp.live.com";      
				$mail->Port       = 587;                 
				$mail->Username   = $settings['admin_email']; 
				$mail->Password   = $settings['admin_email_pass'];          
				$mail->AddAddress($email, $user_name);
				$mail->SetFrom($settings['admin_email'], 'Admin');
				$mail->Subject = ''.$settings['name_website'].' | Aktywacja konta';
				$mail->Body = 'Witaj '.$user_name.'. 
	
	Aby dokończyć rejestracje wejdź na podany adres: http://'.$settings['address_website'].'/verify.php?email='.$email.'&hash='.$activation_key.'';
			
				if($mail->Send())
					return true;
				else	
					echo 'Link aktywacyjny nie został wysłany, proszę o kontakt z administratorem strony';
				}
			else
				echo 'Nie można dodać kluczu do bazy danych';
		}
		
		// WERYFIKACJA MAILA
		public function verify($email,$hash)
		{	
		$sql5="SELECT user_email, link_activation, active FROM users WHERE user_email='$email' AND link_activation='$hash' AND active='0'";
		$result = mysqli_query($this->db,$sql5) or die(mysql_error()); 
		$match  = mysqli_num_rows($result);
	
		if($match > 0){
			$sql6="UPDATE users SET active='1' WHERE user_email='$email' AND link_activation='$hash' AND active='0'";
			$result = mysqli_query($this->db,$sql6) or die(mysqli_connect_errno()."Problem z zapisem do bazy");
			
			echo 'Gratuluje twoje konto zostało aktywowane możesz sie teraz logować.';
			}
		else
			echo 'Link aktywacyjny jest zły';
			
		}
		
		/* ETAP LOGOWANIA */
		public function check_login($email_username, $password){
			
        	$password = md5($password);
			$sql2="SELECT * FROM users WHERE (user_email='$email_username' OR user_name='$email_username') AND user_pass='$password'";
			
			// SPRAWDZA CZY UZYTKOWNIK ISTNIEJE W BAZIE DANYCH
        	$result = mysqli_query($this->db,$sql2);
        	$user_data = mysqli_fetch_array($result);
        	$count_row = $result->num_rows;
	        if ($count_row == 1) {
				if ( $user_data['active'] == 1 ){
					// ZMIENNA LOGOWANIA UZWANA DO SESJI
					$_SESSION['login'] = true;
					$_SESSION['user_id'] = $user_data['user_id'];
					return true;
					}
				else
					return $error='Twoje konto nie zostało aktywowane, sprawdz swoją skrzynkę e-mail';
	        }
	        else{
			    return $error='Żle podane hasło lub login';
			}
    	}
		
		/* RESTARTOWANIE HASLA */
		
		public function reset_pass($user_name) {
			$sql6="SELECT * FROM users WHERE user_name='$user_name'";
			$result=mysqli_query($this->db,$sql6);
			$user_data= mysqli_fetch_array($result);
			$count_row=$result->num_rows;
			$email=$user_data['user_email'];
			if ($count_row == 1)
			{ 
				$sql7="SELECT * FROM settings";
				$result2=mysqli_query($this->db,$sql7);
				$settings= mysqli_fetch_array($result2);
				
				$salt="123#2D83SD31%38023BD!801CCD*7E3SS16";
				$reset_hash = hash('sha512', $salt.$email);

				$mail2 = new PHPMailer(true);
				$mail2->IsSMTP(); 
				$mail2->SMTPAuth   = true;     
				$mail2->CharSet = "UTF-8";				
				$mail2->SMTPSecure = "tls";                
				$mail2->Host       = "smtp.live.com";      
				$mail2->Port       = 587;                 
				$mail2->Username   = $settings['admin_email']; 
				$mail2->Password   = $settings['admin_email_pass'];          
				$mail2->AddAddress($email, $user_name);
				$mail2->SetFrom($settings['admin_email'], 'Admin');
				$mail2->Subject = ''.$settings['name_website'].' | Resestowanie hasła';
				$mail2->Body = 'Witaj '.$user_name.'. 

	Została zgłoszona prośba o zmianę hasła do twojego konta
	Aby zmienić hasło, kliknij na poniższy link:http://'.$settings['address_website'].'/change_pass.php?email='.$email.'&q='.$reset_hash.'';
			
				if($mail2->Send())
					echo 'Link do zresetowania hasła został wysłany na adres e-mail.';
				else	
					return 'Problem z wysłaniem e-mail\'a, prosimy o kontakt z administratorem.';
				}
			else 
				return 'Użytkownik o takiej nazwie nie istnieje';
		}
		
		/* ZMIANA HASLA */
		public function change_password($email,$new_password,$new_password2,$hash)
		{
			if (strlen($new_password)>=6)
			{		
				$salt="123#2D83SD31%38023BD!801CCD*7E3SS16";
				$reset_hash = hash('sha512', $salt.$email);
				if ($reset_hash==$hash)
				{
					if ($new_password == $new_password2)
					{		
						$new_password = md5($new_password);
						$sql="UPDATE users SET user_pass='$new_password' WHERE user_email='$email'";
						$result = mysqli_query($this->db,$sql) or die(mysqli_connect_errno()."Problem z zapisem do bazy");
						return TRUE;
					}
					else
						return "Podane hasła są różne.";
				}
				else
					return 'Twój link do zmiany hasła jest zły'; 
			}
			else
				return 'Hasło powinno mieć conajmniej 6 znaków';
		}
		
		/* WYSWIETLENIE  NICKU*/
		public function get_user_name($user_id){
    		$sql3="SELECT user_name FROM users WHERE user_id = $user_id";
	        $result = mysqli_query($this->db,$sql3);
	        $user_data = mysqli_fetch_array($result);
	        echo $user_data['user_name'];
    	}
		
	
    	/* SESJE */
	    public function get_session(){
	        return $_SESSION['login'];
	    }
 
	    public function user_logout() {
	        $_SESSION['login'] = FALSE;
	        session_destroy();
	    }
 
	}
?>