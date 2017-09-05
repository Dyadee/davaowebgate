<?php
if(isset($_POST['registerBusiness'])){
	
	$errors_register = array();

	if (!isset($_POST['businessName']) || empty($_POST['businessName']) || strlen($_POST['businessName'])<3 ){
		$errbusinessName = '* Please provide the name of your business.';
			$errors_register[] = $errbusinessName;		
	}else{$businessName = strip_tags($_POST['businessName']);}

	if (!isset($_POST['businessCategory']) || empty($_POST['businessCategory'])){
		$errbusinessCategory = '* Please select a category.';
			$errors_register[] = $errbusinessCategory;		
	}else{$businessCategory = $_POST['businessCategory'];}
	
	if(isset($_POST['businessCategory']) || !empty($_POST['businessCategory'])){	
		if(($_POST['businessCategory'] == "Products") && (!isset($_POST['businessTypeProducts']) || empty($_POST['businessTypeProducts']))){
			$errbusinessTypeProducts = '* Please select a business type for Products.';
			$errors_register[] = $errbusinessTypeProducts;			
		}else{$businessTypeProducts = $_POST['businessTypeProducts'];}
		
		if(($_POST['businessCategory'] == "Services") && (!isset($_POST['businessTypeServices']) || empty($_POST['businessTypeServices']))){
			$errbusinessTypeServices = '* Please select a business type for Services.';
			$errors_register[] = $errbusinessTypeServices;			
		}else{$businessTypeServices = $_POST['businessTypeServices'];}
	}
	if ((!isset($_POST['businessCategory']) || empty($_POST['businessCategory'])) && ((!isset($_POST['businessTypeProducts']) || empty($_POST['businessTypeProducts'])) && (!isset($_POST['businessTypeServices']) || empty($_POST['businessTypeServices'])))){
		$errbusinessCategoryType = '* Please select a business category and a business type.';
		$errors_register[] = $errbusinessCategoryType;		 
	}
	
	if (!isset($_POST['businessAddress']) || empty($_POST['businessAddress']) || strlen($_POST['businessName'])<4){
		$errbusinessAddress = '* Please provide an address for your business.';
		$errors_register[] = $errbusinessAddress;		
	}else{$businessAddress = strip_tags($_POST['businessAddress']);}
	
	if (!isset($_POST['businessLocation']) || empty($_POST['businessLocation'])){
		$errbusinessLocation = '* Please choose a location for your business.';
		$errors_register[] = $errbusinessLocation;		
	}else{$businessLocation = $_POST['businessLocation'];}

	//REGULAR EXPRESSIONS
	//BUSINESS PHONE VALIDATION
	if ((!isset($_POST['businessPhone']) || empty($_POST['businessPhone'])) || (isset($_POST['businessPhone']) && valid_phone($_POST['businessPhone'])==FALSE)){
		$errbusinessPhone = '*Invalid Phone Number';
		$errors_register[] = $errbusinessPhone;		
	}else{$businessPhone = $_POST['businessPhone'];}
	//BUSINESS FAX VALIDATION
	if ((!empty($_POST['businessFax'])) && isset($_POST['businessFax']) && valid_fax($_POST['businessFax'])==FALSE){
		$errbusinessFax = '* Invalid Fax Number';
		$errors_register[] = $errbusinessFax;		
	}else{$businessFax = $_POST['businessFax'];}
	//BUSINESS EMAIL VALIDATION
	if ((!isset($_POST['businessEmail']) || empty($_POST['businessEmail'])) || (isset($_POST['businessEmail']) && valid_email($_POST['businessEmail'])==FALSE)){
		$errbusinessEmail = '* Please supply a valid email address.';
		$errors_register[] = $errbusinessEmail;
	}else{$businessEmail = $_POST['businessEmail'];}

	if (isset($_POST['businessWebsite']) || !empty($_POST['businessWebsite'])){ //RECODE FOR A BETTER WEBSITE ADDRESS VALIDATION
		$businessWebsite = strip_tags($_POST['businessWebsite']);		
	}
	
	if (!isset($_POST['businessDescription']) || empty($_POST['businessDescription']) || strlen($_POST['businessDescription'])<4){
		$errbusinessDescription = '* Please provide a short description of your business.';
		$errors_register[] = $errbusinessDescription;		
	}else{$businessDescription = strip_tags($_POST['businessDescription']);}
	
	if (!isset($_POST['businessTags']) || empty($_POST['businessTags']) || strlen($_POST['businessTags'])<4){
		$errbusinessTags = "* Don't leave this empty. It will help users find your business.";
		$errors_register[] = $errbusinessTags;		
	}else{$businessTags = strip_tags($_POST['businessTags']);}
	
	if (!isset($_POST['businessAgree'])){
		$errbusinessAgree = '* You Must Agree to the Terms and Conditions';
		$errors_register[] = $errbusinessAgree;
	}else{$businessAgree = $_POST['businessAgree'];}	
	if (empty($errors_register)){									
		
		$business = new Business();
		
		global $database;
				
		$business->businessName = $database->PrepSQL($businessName);
		$business->businessCategory = $database->PrepSQL($businessCategory);
		
		if (isset($_POST['businessTypeProducts']) && ($_POST['businessCategory'] === 'Products')){
			$business->businessType = $database->PrepSQL($_POST['businessTypeProducts']);
		}
		if (isset($_POST['businessTypeServices'])&& ($_POST['businessCategory'] === 'Services')){
			$business->businessType = $database->PrepSQL($_POST['businessTypeServices']);
		}
		$business->businessAddress = $database->PrepSQL($businessAddress);
		$business->businessLocation = $database->PrepSQL($_POST['businessLocation']);
		$business->businessPhone = $database->PrepSQL($_POST['businessPhone']);
		$business->businessFax = $database->PrepSQL($_POST['businessFax']);
		$business->businessEmail = trim($database->PrepSQL($_POST['businessEmail']));
		$business->businessWebsite = trim($database->PrepSQL($businessWebsite));
		$business->businessDescription = $database->PrepSQL(removeslashes(nl2br($businessDescription)));
		$business->businessTags = $database->PrepSQL(removeslashes($businessTags));
		$business->businessPostDate = $database->PrepSQL($_POST['businessPostDate']);
		if (isset($_SESSION['userID'])){
			$business->userID = $database->PrepSQL($_SESSION['userID']);
		}		
		//echo var_dump($business);
		$business->create();		
	}else {	
			$errMessage = "There is a problem with the information you provided. Please check the form and try again.";
			return false;
	}
}//END registerBusiness VALIDATION

//BEGIN updateBusiness VALIDATION
if(isset($_POST['updateBusiness'])){
	$errors_update = array();

	if (!isset($_POST['businessName']) || empty($_POST['businessName']) || strlen($_POST['businessName'])<3 ){
		$errbusinessName = '* Please provide the name of your business.';
			$errors_update[] = $errbusinessName;		
	}else{$businessName = strip_tags($_POST['businessName']);}

	if (!isset($_POST['businessCategory']) || empty($_POST['businessCategory'])){
		$errbusinessCat = '* Please select a category.';
			$errors_update[] = $errbusinessCat;		
	}else{$businessCategory = $_POST['businessCategory'];}
	
	if(isset($_POST['businessCategory']) || !empty($_POST['businessCategory'])){	
		if(($_POST['businessCategory'] == "Products") && (!isset($_POST['businessTypeProducts']) || empty($_POST['businessTypeProducts']))){
			$errbusinessTypeProducts = '* Please select a business type for Products.';
			$errors_update[] = $errbusinessTypeProducts;			
		}else{$businessTypeProducts = $_POST['businessTypeProducts'];}
		if(($_POST['businessCategory'] == "Services") && (!isset($_POST['businessTypeServices']) || empty($_POST['businessTypeServices']))){
			$errbusinessTypeServices = '* Please select a business type for Services.';
			$errors_update[] = $errbusinessTypeServices;			
		}else{$businessTypeServices = $_POST['businessTypeServices'];}
	}
	if ((!isset($_POST['businessCategory']) || empty($_POST['businessCategory'])) && ((!isset($_POST['businessTypeProducts']) || empty($_POST['businessTypeProducts'])) && (!isset($_POST['businessTypeServices']) || empty($_POST['businessTypeServices'])))){
		$errbusinessCategoryType = '* Please select a business category and business type.';
		$errors_update[] = $errbusinessCategoryType;		 
	}
	if (!isset($_POST['businessAddress']) || empty($_POST['businessAddress']) || strlen($_POST['businessName'])<4){
		$errbusinessAddress = '* Please provide an address for your business.';
		$errors_update[] = $errbusinessAddress;		
	}else{$businessAddress = strip_tags($_POST['businessAddress']);}
	
	if (!isset($_POST['businessLocation']) || empty($_POST['businessLocation'])){
		$errbusinessLocation = '* Please choose a location for your business.';
		$errors_register[] = $errbusinessLocation;		
	}else{$businessLocation = $_POST['businessLocation'];}

	//REGULAR EXPRESSIONS
	//BUSINESS PHONE VALIDATION
	if ((!isset($_POST['businessPhone']) || empty($_POST['businessPhone'])) || (isset($_POST['businessPhone']) && valid_phone($_POST['businessPhone'])==FALSE)){
		$errbusinessPhone = '*Invalid Phone Number';
		$errors_update[] = $errbusinessPhone;		
	}else{$businessPhone = $_POST['businessPhone'];}
	//BUSINESS FAX VALIDATION
	if ((!empty($_POST['businessFax'])) && isset($_POST['businessFax']) && valid_fax($_POST['businessFax'])==FALSE){
		$errbusinessFax = '* Invalid Fax Number';
		$errors_update[] = $errbusinessFax;		
	}else{$businessFax = $_POST['businessFax'];}
	//BUSINESS EMAIL VALIDATION
	if ((!isset($_POST['businessEmail']) || empty($_POST['businessEmail'])) || (isset($_POST['businessEmail']) && valid_email($_POST['businessEmail'])==FALSE)){
		$errbusinessEmail = '* Please supply a valid email address.';
		$errors_update[] = $errbusinessEmail;
	}else{$businessEmail = $_POST['businessEmail'];}

	if (isset($_POST['businessWebsite']) || !empty($_POST['businessWebsite'])){ //RECODE FOR A BETTER WEBSITE ADDRESS VALIDATION
		$businessWebsite = strip_tags($_POST['businessWebsite']);		
	}
	if (!isset($_POST['businessDescription']) || empty($_POST['businessDescription']) || strlen($_POST['businessDescription'])<4){
		$errbusinessDescription = '* Please provide a short description of your business.';
		$errors_update[] = $errbusinessDescription;		
	}else{$businessDescription = strip_tags($_POST['businessDescription']);}
	if (!isset($_POST['businessTags']) || empty($_POST['businessTags']) || strlen($_POST['businessTags'])<4){
		$errbusinessTags = "* Don't leave this empty. It will help users find your business.";
		$errors_update[] = $errbusinessTags;		
	}else{$businessTags = strip_tags($_POST['businessTags']);}
	if (!isset($_POST['businessAgree'])){
		$errbusinessAgree = '* You Must Agree to the Terms and Conditions';
		$errors_update[] = $errbusinessAgree;
	}else{$businessAgree = $_POST['businessAgree'];}
	
	if (empty($errors_update)){									
		
		$business = new Business();
		
		global $database;
				
		$business->businessName = $database->PrepSQL($businessName);
		$business->businessCategory = $database->PrepSQL($_POST['businessCategory']);
		
		if (isset($_POST['businessTypeProducts']) && ($_POST['businessCategory'] === 'Products')){
			$business->businessType = $database->PrepSQL($_POST['businessTypeProducts']);
		}
		if (isset($_POST['businessTypeServices'])&& ($_POST['businessCategory'] === 'Services')){
			$business->businessType = $database->PrepSQL($_POST['businessTypeServices']);
		}
		$business->businessAddress = $database->PrepSQL($businessAddress);
		$business->businessLocation = $database->PrepSQL($_POST['businessLocation']);
		$business->businessPhone = $database->PrepSQL($_POST['businessPhone']);
		$business->businessFax = $database->PrepSQL($_POST['businessFax']);
		$business->businessEmail = trim($database->PrepSQL($_POST['businessEmail']));
		$business->businessWebsite = trim($database->PrepSQL($businessWebsite));
		$business->businessDescription = $database->PrepSQL(removeslashes(nl2br($businessDescription)));
		$business->businessTags = $database->PrepSQL(removeslashes($businessTags));
		$business->businessUpDate = $database->PrepSQL($_POST['businessUpDate']);
			
		//echo var_dump($business);
		$business->update();		
	}else {	
			$errMessage = "Sorry, cannot update. Please check the form and try again."; 
			return false;
	}
}//END updateBusiness VALIDATION

?>