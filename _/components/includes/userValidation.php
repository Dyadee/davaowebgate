 <?php require_once('recaptchalib.php');?>
 <?php
if(isset($_POST['registerUser'])){
		$errors_register = array();

  $privatekey = "6Lc5-_ISAAAAAJukRXKqqeybEAzuy2Im3gyP484W";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    $errMessage = "The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")";
  } else {
    // Your code here to handle a successful verification
  	
	
	$password_1 = strip_tags($_POST['userPassword1']);
	$password_2 = strip_tags($_POST['userPassword2']);
	
	if(!isset($_POST['firstName']) || empty($_POST['firstName']) || strlen($_POST['firstName'])<2){
          $errfirstName = '* Please provide your first name';
			$errors_register[] = $errfirstName;			
	}else {$firstName = strip_tags($_POST['firstName']);}
	if(isset($_POST['middleName']) || !empty($_POST['middleName']) || strlen($_POST['middleName'])>=2){
		$middleName = strip_tags($_POST['middleName']);
	}	
	if(!isset($_POST['lastName']) || empty($_POST['lastName']) || strlen($_POST['lastName'])<2){
          $errlastName = '* Please provide your last name';
			$errors_register[] = $errlastName;			
	}else {$lastName = strip_tags($_POST['lastName']);}		
	if(!isset($_POST['gender']) || empty($_POST['gender'])){	
		$erruserGender = '* Please choose a gender.';
		$errors_register[] = $erruserGender;
	}else {$gender = strip_tags($_POST['gender']);}		
	//REQUIRES functions.php
	//PHONE VALIDATION
	if ((!isset($_POST['userPhone']) || empty($_POST['userPhone'])) || (isset($_POST['userPhone']) && valid_phone($_POST['userPhone'])==FALSE)){
		$erruserPhone = '* You entered an invalid phone number';		
		$errors_register[] = $erruserPhone;
	}else {$userPhone = strip_tags($_POST['userPhone']);}
	//FAX VALIDATION	
	if ((!empty($_POST['userFax'])) && isset($_POST['userFax']) && valid_fax($_POST['userFax'])==FALSE){
		$erruserFax = '* You entered an invalid fax number';		
		$errors_register[] = $erruserFax;
	}else {$userFax = strip_tags($_POST['userFax']);}
	//EMAIL VALIDATION
	if ((!isset($_POST['userMail']) || empty($_POST['userMail'])) || (isset($_POST['userMail']) && valid_email($_POST['userMail'])==FALSE)){
		$erruserMail = '* Please provide a valid email address';
		$errors_register[] = $erruserMail;
	}else{$userMail = strip_tags($_POST['userMail']);}
	//PASSWORD VALIDATION	
	if (!isset($password_1) || empty($password_1) || strlen($password_1)<6){
		$errpassword_1 = '* Password must be at least 6 characters';
		$errors_register[] = $errpassword_1;
	}else if (!isset($errpassword_1) && (!isset($password_2) || empty($password_2))){
		$errpassword_2 = '* Please retype your password';
		$errors_register[] = $errpassword_2;
	}else if((isset($password_1) && isset($password_2)) && ($password_1 != $password_2)){
		$errpassword_2 = '* Passwords must match';
		$errors_register[] = 'Passwords must match.';
	}else if((!isset($password_1) && isset($password_2)) && ($password_1 != $password_2)){
		$errpassword_2 = '* Passwords must match';
		$errors_register[] = 'Passwords must match.';
	}
	else {
			$password_1 = strip_tags($_POST['userPassword1']);
			$password_2 = strip_tags($_POST['userPassword2']);
		}
	if (!isset($_POST['agree'])){
		$errAgree = '* You Must Agree to the Terms and Conditions';
		$errors_register[] = $errAgree;
	}
	if (isset($_POST['registerDate'])){$registerDate = $_POST['registerDate'];}
	
	if (empty($errors_register)){									
		
		$user = new User();
		
		global $database;
		if (isset($_SESSION['userID'])){
			$user->userID = $database->PrepSQL($_SESSION['userID']);
		}		
		$user->firstName = trim($database->PrepSQL($firstName));
		$user->middleName = trim($database->PrepSQL($middleName));
		$user->lastName = trim($database->PrepSQL($lastName));
		$user->gender = $database->PrepSQL($_POST['gender']);
		$user->userPhone = $database->PrepSQL($_POST['userPhone']);
		$user->userFax = $database->PrepSQL($_POST['userFax']);
		$user->userMail = trim($database->PrepSQL($_POST['userMail']));
		$user->userPassword = trim($database->PrepSQL($password_1));
		$user->hashedPassword = hash('sha256', $user->userPassword);
		$user->registerDate = $database->PrepSQL($_POST['registerDate']);
		
		//check to see if userMail already exist is the database
		$userExist = User::find_by_userMail($user->userMail);
		if(!empty($userExist)){ 
			$errMessage = "Sorry, cannot submit. Login Information already exist."; 
			return false;
		}else {
			$user->create();
				
		}		
		
	}else {				
			$errMessage = "Sorry, cannot submit. Please check the form and try again."; 
			return false;
	}
}//end else for recaptcha
}//END registerUser VALIDATION

//BEGIN updateUser VALIDATION

if(isset($_POST['updateUser'])){
	$errors_update = array();
			
	if(!isset($_POST['firstName']) || empty($_POST['firstName']) || strlen($_POST['firstName'])<2){
          $errfirstName = '* Please provide your first name';
			$errors_update[] = $errfirstName;			
	}
	if(isset($_POST['middleName']) || !empty($_POST['middleName']) || strlen($_POST['middleName'])>=2){
		$middleName = strip_tags($_POST['middleName']);
	}	
	if(!isset($_POST['lastName']) || empty($_POST['lastName']) || strlen($_POST['lastName'])<2){
          $errlastName = '* Please provide your last name';
			$errors_update[] = $errlastName;			
	}		
	if(!isset($_POST['gender']) || empty($_POST['gender'])){	
		$erruserGender = '* Please choose a gender.';
		$errors_update[] = $erruserGender;
	}	
	
	//REQUIRES functions.php
	//PHONE VALIDATION
	if ((!isset($_POST['userPhone']) || empty($_POST['userPhone'])) || (isset($_POST['userPhone']) && valid_phone($_POST['userPhone'])==FALSE)){
		$erruserPhone = '* You entered an invalid phone number';		
		$errors_update[] = $erruserPhone;
	}
	//FAX VALIDATION	
	if ((!empty($_POST['userFax'])) && isset($_POST['userFax']) && valid_fax($_POST['userFax'])==FALSE){
		$erruserFax = '* You entered an invalid fax number';		
		$errors_update[] = $erruserFax;
	}
	if (isset($_POST['registerUpDate'])){$registerUpDate = $_POST['registerUpDate'];}

	if (empty($errors_update)){									
		
		$user = new User();		
		global $database;
		if (isset($_SESSION['userID'])){
			$user->userID = $database->PrepSQL($_SESSION['userID']);
		}		
		$user->firstName = $database->PrepSQL(strip_tags($_POST['firstName']));
		$user->middleName = $database->PrepSQL(strip_tags($_POST['middleName']));
		$user->lastName = $database->PrepSQL(strip_tags($_POST['lastName']));
		$user->gender = $database->PrepSQL($_POST['gender']);
		$user->userPhone = $database->PrepSQL($_POST['userPhone']);
		$user->userFax = $database->PrepSQL($_POST['userFax']);
		$user->registerUpDate = $database->PrepSQL($_POST['registerUpDate']);
		$user->update();	
		
	}else {	
			$errMessage = "Sorry, cannot update. Please check the form and try again."; 
			return false;				
	}
	
}//END updateUser VALIDATION

if(isset($_POST['updateLogin'])){
	$errors_update_login = array();
	$password_1 = strip_tags($_POST['userPassword1']);
	$password_2 = strip_tags($_POST['userPassword2']);
			
	//EMAIL VALIDATION
	if ((!isset($_POST['userMail']) || empty($_POST['userMail'])) || (isset($_POST['userMail']) && valid_email($_POST['userMail'])==FALSE)){
		$erruserMail = '* Please provide a valid email address';
		$errors_update_login[] = $erruserMail;
	}
	//PASSWORD VALIDATION	
	if (!isset($password_1) || empty($password_1) || strlen($password_1)<6){
		$errpassword_1 = '* password is required and must be at least 6 characters long';
		$errors_update_login[] = $errpassword_1;
	}else if (!isset($password_2) || empty($password_2)){
		$errpassword_2 = '* Please retype your password';
		$errors_update_login[] = $errpassword_2;
	}else if((isset($password_1) && isset($password_2)) && ($password_1 != $password_2)){
		$errpassword_2 = '* passwords must match';
		$errors_update_login[] = 'Passwords must match.';
	}else if((!isset($password_1) && isset($password_2)) && ($password_1 != $password_2)){
		$errpassword_2 = '* passwords must match';
		$errors_update_login[] = 'Passwords must match.';
	}
	else {
			$password_1 = strip_tags($_POST['userPassword1']);
			$password_2 = strip_tags($_POST['userPassword2']);
		}
	if (isset($_POST['registerUpDate'])){$registerUpDate = $_POST['registerUpDate'];}

	if (empty($errors_update_login)){									
		
		$user = new User();		
		global $database;
		if (isset($_SESSION['userID'])){
			$user->userID = $database->PrepSQL($_SESSION['userID']);
		}
		$user->userMail = strip_tags($database->PrepSQL($_POST['userMail']));
		$user->userPassword = strip_tags($database->PrepSQL($password_1));
		$user->hashedPassword = hash('sha256', $user->userPassword);
		$user->registerUpDate = $database->PrepSQL($_POST['registerUpDate']);	
	
		$user->update_login();
		
	}else {	
			$errMessage = "Sorry, cannot update. Please check the form and try again."; 
			return false;
	}
}//END updateLogin VALIDATION

?>