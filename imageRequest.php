<?php ob_start(); ?>
<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require_once("_/components/includes/functions.php"); ?>
<?php $session->confirm_logged_in(); ?>

<?php
	if(isset($_POST['itemID']) && isset($_POST['imageRequest'])){
		
		$userID = $_SESSION['userID'];
		$imageRequest = $_POST['imageRequest'];//index
		$itemID = $_POST['itemID'];


						//BEGIN FOR ITEM IMAGE USE
							$hashedUserID = hash('sha256', $userID);
							$hashedItemID = hash('sha256', $itemID);				
							$directory = "uploads/$hashedUserID/Items/$hashedItemID";
							$files = scandir($directory);
							$excluded = array('.','..');
							$result_files = array_diff($files, $excluded);
							//var_dump($result_files);
							$thumbnail = array();
							$fullsize = array();
								foreach ($result_files as $key => $value) {
									$thumb = strpos($value, "thumb_");								
									if($thumb===0){									
										 $thumbnail[] = $value;
										 //echo "$value<br />";
									}else if($thumb!==0){									
										$fullsize[] = $value;
										//echo "$value<br />";							
									}											
								}


		for($i = 0; $i < count($fullsize); $i++){

			if ($imageRequest == $i) {
				echo "<img class = \"img-responsive\" src=\"$directory/$fullsize[$i]\"/>";
			}
		}
		
		
	}
?>