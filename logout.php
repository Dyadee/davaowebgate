<?php ob_start(); ?>
<?php require("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require("_/components/includes/functions.php"); ?>
<?php
		//**TO DO **//
		// TRY MOVING THESE FUNCTIONS INTO THE SESSION CLASS
		// Unset all the session variables
		 $_SESSION = array(); //THIS SETS THE $_SESSION INTO AN EMPTY ARRAY
		
		//DESTROY THE SESSION COOKIE
		if(isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}		
		//DESTROY THE SESSION
		$session->logout();
		session_destroy();		
		redirect_to("index.php?logout=1");
?>
<?php ob_end_flush();?>