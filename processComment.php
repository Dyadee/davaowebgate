<?php ob_start(); ?>
<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require_once("_/components/includes/functions.php"); ?>
<?php require_once("_/components/includes/class/comments.php"); ?>
<?php require_once("_/components/includes/class/user.php"); ?>  
<?php
	if(isset($_SESSION['userID'])){
			$userID = $_SESSION['userID'];
		}else {$userID = 0;}
		
	$user = new User();
	$userObject = User::find_by_id($userID);
	if(!empty($userObject)){
		$userDetails = get_object_vars($userObject);
		 $userName = $userDetails['firstName'];
	}								
	if(isset($_POST['method']) && isset($_POST['itemID']) && isset($_POST['comment']) && $userID != 0){	
		
		$comment = new Comments();
		$comment->itemID = $_POST['itemID'];
		$comment->comment = $_POST['comment'];		
		$method = $_POST['method']; //insertComment OR readComments		
		
		if ($method == 'insertComment') {			
			global $database;			
			$comment = new Comments();		
			$comment->comment = $database->PrepSQL(htmlspecialchars($_POST['comment']));
			$comment->commentPostDate = $database->PrepSQL(time());
			$comment->itemID = $database->PrepSQL($_POST['itemID']);
			$comment->userID = $database->PrepSQL($userID);
			$comment->userName = $database->PrepSQL($userName);
			$comment->create();				
		}//END insertComments
		
		
		
	}//END IF
	else if(isset($_POST['method']) && isset($_POST['itemID'])){
		
		$comment = new Comments();
		$comment->itemID = $_POST['itemID'];		
		$method = $_POST['method']; //insertComment OR readComments
		
		
		if($method == "readComments"){
			
			$commentObject = Comments::find_by_itemID($comment->itemID);
			if(!empty($commentObject)){
				foreach($commentObject as $commentDetails){
					$userName = $commentDetails->userName;
					$message = removeslashes($commentDetails->comment);
					$messageTime = makeAgo($commentDetails->commentPostDate);
					echo "<div class=\"messageContainer\">";
					echo "<div class = \"usertime\" >";
						echo "<span class = \"glyphicon glyphicon-user pull-left\" style=\"font-size:.8em; color: #666; margin-top: 2px;\" ></span>";
						echo "<span style=\"font-size:.9em; color: #666; font-weight: bold;\" class = \"pull-left\" >&nbsp;$commentDetails->userName:  &nbsp;<i>says</i></span>";
						echo "<span style=\"font-size:.85em; color: #999;\" class = \"pull-right\">$messageTime</span>";
					echo "</div>";
					echo "<div class=\"chatmessage\"><p>--> $message</p></div>";
					echo "</div>";
					
					
			}
				
			}else {echo "<span style = \"font-weight: bold; color: #666;\"><p>No comments yet.</p></span>";}
		}//END readComments
						
		
	}//END IF
?>