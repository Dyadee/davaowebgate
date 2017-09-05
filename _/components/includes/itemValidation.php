<?php
if(isset($_POST['itemPost'])){
	
	$errors_itemPost = array();

	if (!isset($_POST['itemTitle']) || empty($_POST['itemTitle']) || strlen($_POST['itemTitle'])<3 ){
		$erritemTitle = '* Please provide the name of your item.';
			$errors_itemPost[] = $erritemTitle;		
	}else{$itemTitle = strip_tags($_POST['itemTitle']);}

	if (!isset($_POST['itemCategory']) || empty($_POST['itemCategory'])){
		$erritemCategory = '* Please select item category.';
			$errors_itemPost[] = $erritemCategory;		
	}else{$itemCategory = strip_tags($_POST['itemCategory']);}
		
	// if (!isset($_POST['itemPrice']) || empty($_POST['itemPrice']) || strlen($_POST['itemPrice'])<4){
		// $erritemPrice = '* Please provide a price for your item.';
		// $errors_itemPost[] = $erritemPrice;		
	// }else{$itemPrice = $_POST['itemPrice'];}
	
	//itemPrice VALIDATION
	if (!isset($_POST['itemPrice']) || empty($_POST['itemPrice']) || (valid_price($_POST['itemPrice'])==FALSE)){
		$erritemPrice = 'Please enter a valid price qoute';
		$errors_itemPost[] = $erritemPrice;
	}else{$itemPrice = strip_tags($_POST['itemPrice']);}	
	//END itemPrice VALIDATION
	
	if (!isset($_POST['itemContactInfo']) || empty($_POST['itemContactInfo']) || strlen($_POST['itemContactInfo'])<4){
		$erritemContactInfo = '* Please provide your contact info.';
		$errors_itemPost[] = $erritemContactInfo;		
	}else{$itemContactInfo = strip_tags($_POST['itemContactInfo']);}

	if (!isset($_POST['itemDescription']) || empty($_POST['itemDescription']) || strlen($_POST['itemDescription'])<4){
		$erritemDescription = '* Please provide a short description of your item.';
		$errors_itemPost[] = $erritemDescription;		
	}else{$itemDescription = htmlspecialchars($_POST['itemDescription']);}
	
	
	if (!isset($_POST['itemTags']) || empty($_POST['itemTags']) || strlen($_POST['itemTags'])<4){
		$erritemTags = "* Don't leave this empty. It will help users find your item.";
		$errors_itemPost[] = $erritemTags;		
	}else{$itemTags = strip_tags($_POST['itemTags']);}
	
	if (!isset($_POST['itemAgree'])){
		$erritemAgree = '* You Must Agree to the Terms and Conditions';
		$errors_itemPost[] = $erritemAgree;
	}else{$itemAgree = strip_tags($_POST['itemAgree']);}	
	
	//IF NO ERRORS OCCURED THEN 
	if (empty($errors_itemPost)){		
		
		$item = new Item();		
		global $database;
				
		$item->itemTitle = $database->PrepSQL(removeslashes($itemTitle));
		$item->itemCategory = $database->PrepSQL($itemCategory);
		$item->itemPrice = $database->PrepSQL($itemPrice);
		$item->itemContactInfo = $database->PrepSQL($itemContactInfo);
		$item->itemDescription = $database->PrepSQL(removeslashes(nl2br($itemDescription)));
		$item->itemTags = $database->PrepSQL(removeslashes($itemTags));
		$item->itemPostDate = $database->PrepSQL($_POST['itemPostDate']);
		if (isset($_SESSION['userID'])){
			$item->userID = $database->PrepSQL($_SESSION['userID']);
		}		
		//echo var_dump($item);
		$item->create();		
	}else {	
			$errMessage = "There is a problem with the information you provided. Please check the form and try again.";
			return false;
	}
}//END itemPost VALIDATION

//BEGIN updateItem VALIDATION
if(isset($_POST['itemUpdate'])){
	$errors_update = array();

	if (!isset($_POST['itemTitle']) || empty($_POST['itemTitle']) || strlen($_POST['itemTitle'])<3 ){
		$erritemTitle = '* Please provide the name of your item.';
			$errors_update[] = $erritemTitle;		
	}else{$itemTitle = strip_tags($_POST['itemTitle']);}

	if (!isset($_POST['itemCategory']) || empty($_POST['itemCategory'])){
		$erritemCategory = '* Please select item category.';
			$errors_update[] = $erritemCategory;		
	}else{$itemCategory = strip_tags($_POST['itemCategory']);}
		
	// if (!isset($_POST['itemPrice']) || empty($_POST['itemPrice']) || strlen($_POST['itemPrice'])<4){
		// $erritemPrice = '* Please provide a price for your item.';
		// $errors_update[] = $erritemPrice;		
	// }else{$itemPrice = $_POST['itemPrice'];}
	
	//itemPrice VALIDATION
	if (!isset($_POST['itemPrice']) || empty($_POST['itemPrice']) || (valid_price($_POST['itemPrice'])==FALSE)){
		$erritemPrice = 'Please enter a valid price qoute';
		$errors_update[] = $erritemPrice;
	}else{$itemPrice = strip_tags($_POST['itemPrice']);}	
	//END itemPrice VALIDATION
	
	if (!isset($_POST['itemContactInfo']) || empty($_POST['itemContactInfo']) || strlen($_POST['itemContactInfo'])<4){
		$erritemContactInfo = '* Please provide your contact info.';
		$errors_update[] = $erritemContactInfo;		
	}else{$itemContactInfo = strip_tags($_POST['itemContactInfo']);}
		
	if (!isset($_POST['itemDescription']) || empty($_POST['itemDescription']) || strlen($_POST['itemDescription'])<4){
		$erritemDescription = '* Please provide a short description of your item.';
		$errors_update[] = $erritemDescription;		
	}else{$itemDescription = htmlspecialchars($_POST['itemDescription']);}
	
	if (!isset($_POST['itemTags']) || empty($_POST['itemTags']) || strlen($_POST['itemTags'])<4){
		$erritemTags = "* Don't leave this empty. It will help users find your item.";
		$errors_update[] = $erritemTags;		
	}else{$itemTags = strip_tags($_POST['itemTags']);}
	
	if (!isset($_POST['itemAgree'])){
		$erritemAgree = '* You Must Agree to the Terms and Conditions';
		$errors_update[] = $erritemAgree;
	}else{$itemAgree = strip_tags($_POST['itemAgree']);}	
	
	//IF NO ERRORS OCCURED THEN
	if (empty($errors_update)){									
		global $database;				
		$item = new Item();		
						
		$item->itemTitle = $database->PrepSQL(removeslashes($itemTitle));
		$item->itemCategory = $database->PrepSQL($itemCategory);
		$item->itemPrice = $database->PrepSQL($itemPrice);
		$item->itemContactInfo = $database->PrepSQL($itemContactInfo);
		$item->itemDescription = $database->PrepSQL(removeslashes(nl2br($itemDescription)));
		$item->itemTags = $database->PrepSQL(removeslashes($itemTags));
		$item->itemUpDate = $database->PrepSQL($_POST['itemUpDate']);
		if (isset($_SESSION['userID'])){
			$item->userID = $database->PrepSQL($_SESSION['userID']);
		}		
			
		//echo var_dump($item);
		$item->update();		
	}else {	
			$errMessage = "Sorry, cannot update. Please check the form and try again."; 
			return false;
	}
}//END itemUpdate VALIDATION

?>