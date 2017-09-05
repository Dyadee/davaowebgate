<?php
if(isset($_POST['sendPrivateMessage'])){
	
	//var_dump($_POST);
	$errors_sendPrivateMessage = array();

	if (!isset($_POST['messageSubject']) || empty($_POST['messageSubject']) || strlen($_POST['messageSubject'])<3 ){
		$errMessageSubject = '* Please provide subject of your message.';
			$errors_sendPrivateMessage[] = $errMessageSubject;		
	}else{$messageSubject = strip_tags($_POST['messageSubject']);}

	if (!isset($_POST['privateMessageContent']) || empty($_POST['privateMessageContent']) || strlen($_POST['privateMessageContent'])<4){
		$errprivateMessageContent = '* You cannot send an empty message.';
		$errors_sendPrivateMessage[] = $errprivateMessageContent;		
	}else{$privateMessageContent = htmlspecialchars($_POST['privateMessageContent']);}
	
	if (isset($_POST['privateMessagePostDate'])){$privateMessagePostDate = $_POST['privateMessagePostDate'];}
	if (isset($_POST['itemID'])){$itemID = $_POST['itemID'];}
	if (isset($_POST['toUserID'])){$toUserID = $_POST['toUserID'];}
	if (isset($_POST['fromUserID'])){$fromUserID = $_POST['fromUserID'];}
	if (!isset($_POST['fromUserMail']) || empty($_POST['fromUserMail'])){
		$errfromUserMail = '* You need to login to send private message.';
			$errors_sendPrivateMessage[] = $errfromUserMail;		
	}else{$fromUserMail = strip_tags($_POST['fromUserMail']);}
	
	
	//IF NO ERRORS OCCURED THEN 
	if (empty($errors_sendPrivateMessage)){		
		
		$privateMessage = new PrivateMessage();		
		global $database;
		
		$privateMessage->messageSubject = $database->PrepSQL(removeslashes($messageSubject));
		$privateMessage->privateMessage = $database->PrepSQL(removeslashes(nl2br($privateMessageContent)));
		$privateMessage->privateMessagePostDate = $database->PrepSQL($privateMessagePostDate);
		$privateMessage->itemID = $database->PrepSQL($itemID);
		if (isset($_SESSION['userID'])){
			$privateMessage->fromUserID = $database->PrepSQL($fromUserID);
		}
		$privateMessage->toUserID = $database->PrepSQL($toUserID);
		$privateMessage->fromUserMail = $database->PrepSQL(removeslashes($fromUserMail));
				
		//var_dump($privateMessage);
		$privateMessage->sendPrivateMessage();
		$successMessage = "Your private message was successfully sent.";
	
	}else {	
			$errMessage = "There is a problem submitting your message. Please check the form and try again.";
			return false;
	}
	
}//END sendPrivateMessage3 VALIDATION

?>