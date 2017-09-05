<?php ob_start(); ?>
<?php
	if(isset($_POST['itemID']) && isset($_POST['imageRequest']) && isset($_POST['userID'])){
		$itemID = $_POST['itemID'];
		$userID = $_POST['userID'];
		$imageRequest = $_POST['imageRequest'];//index
		


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
		
		// if($imageRequest==0){

		// 	$index=0;
		// 	echo "<img class = \"img-responsive\" src=\"$directory/$fullsize[0]\"/>";


		// }

		// if($imageRequest==1){

		// 	$index=1;
		// 	echo "<img class = \"img-responsive\" src=\"$directory/$fullsize[1]\"/>";
		// }

		// if($imageRequest==2){

		// 	$index=2;
		// 	echo "<img class = \"img-responsive\" src=\"$directory/$fullsize[2]\"/>";
		// }
	}
?>