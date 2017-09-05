<?php ob_start();?>
<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->

<?php $session->confirm_logged_in(); ?>
<?php 
	$userID = $_SESSION['userID'];
	$hashedUserID = hash('sha256', $userID);
	if (isset($_GET['iid'])){
		$hashedItemID = hash('sha256', $_GET['iid']);
		$itemID = $_GET['iid'];
	}	
	$time = hash('sha256', time());
	$uid = hash('sha256', $_GET['iid']);
	$q = $hashedUserID;

		 // echo "userID: $userID <br/>";
		 // echo "itemID: $itemID <br/>";
		 // echo "hashedUserID: $hashedUserID <br/>";
		 // echo "hashedItemID: $hashedItemID <br/>";
?>
<noscript>
<div align="center"><a href="index.php">Go Back To Upload Form</a></div><!-- If javascript is disabled -->
</noscript>
<?php
//If you face any errors, increase values of "post_max_size", "upload_max_filesize" and "memory_limit" as required in php.ini
if(isset($_POST))
{
 ############ Edit settings ##############
$ThumbSquareSize 		= 150; //Thumbnail will be 100x100
$BigImageMaxSize 		= 550; //Image Maximum height or width
$ThumbPrefix			= "thumb_"; //Normal thumb Prefix
$DestinationDirectory	= "uploads//$hashedUserID/Items/$hashedItemID/"; //Upload Directory ends with / (slash)
$Quality 				= 80;
##########################################
//ini_set('memory_limit', '-1'); // maximum memory!
//check if this is an ajax request
	if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		die();
	}

foreach($_FILES as $file)
{
// some information about image we need later.
$ImageName 		= $file['name'];
$ImageSize 		= $file['size'];
$TempSrc	 	= $file['tmp_name'];
$ImageType	 	= $file['type'];



if (is_array($ImageName)) 
{
	$c = count($ImageName);
	
	// echo  '<ul>';
	if(isset($ImageName) || is_uploaded_file($TempSrc)) {

			//BEGIN DELETING ANY FORMER UPLOADED LOGOS
			$directory = "uploads/$hashedUserID/Items/$hashedItemID/";
				if(file_exists($directory)){					
					$directories = scandir($directory);
					$excluded = array('.','..');
					$result_dir = array_diff($directories, $excluded);
						if(!empty($result_dir)){
						foreach(glob($directory.'*.*') as $file){unlink($file);}
					}
				}
		//END DELETING ANY FORMER UPLOADED LOGOS

	}
	for ($i=0; $i < $c; $i++)
	{
		$processImage			= true;	
		$RandomNumber			= rand(0, 9999999999);  // We need same random name for both files.
		
		if(!isset($ImageName[$i]) || !is_uploaded_file($TempSrc[$i]))
		{
			echo '<div class="error">Error occurred while trying to process <strong>'.$ImageName[$i].'</strong>, may be file too big!</div>'; //output error
		}
		else
		{
			
	

			//Validate file + create image from uploaded file.
			switch(strtolower($ImageType[$i]))
			{
				case 'image/png':
					$CreatedImage = imagecreatefrompng($TempSrc[$i]);
					break;
				case 'image/gif':
					$CreatedImage = imagecreatefromgif($TempSrc[$i]);
					break;
				case 'image/jpeg':
				case 'image/pjpeg':
					$CreatedImage = imagecreatefromjpeg($TempSrc[$i]);
					break;
				default:
					$processImage = false; //image format is not supported!
			}
			//get Image Size
			list($CurWidth,$CurHeight)=getimagesize($TempSrc[$i]);

			//Get file extension from Image name, this will be re-added after random name
			$ImageExt = substr($ImageName[$i], strrpos($ImageName[$i], '.'));
			$ImageExt = str_replace('.','',$ImageExt);
	
			//Construct a new image name (with random number added) for our new image.
			$timeUploded = time();
			$fileName = "davao_"."u".$userID."b".$itemID."_webgate_".$timeUploded.$RandomNumber.".".$ImageExt;
			$NewImageName = $fileName;

			//$NewImageName = $RandomNumber.'.'.$ImageExt;


			//Set the Destination Image path with Random Name
			$thumb_DestRandImageName 	= $DestinationDirectory.$ThumbPrefix.$NewImageName; //Thumb name
			$DestRandImageName 			= $DestinationDirectory.$NewImageName; //Name for Big Image

			//Resize image to our Specified Size by calling resizeImage function.
			if($processImage && resizeImage($CurWidth,$CurHeight,$BigImageMaxSize,$DestRandImageName,$CreatedImage,$Quality,$ImageType[$i]))
			{
				//Create a square Thumbnail right after, this time we are using cropImage() function
				if(!resizeImage($CurWidth,$CurHeight,$ThumbSquareSize,$thumb_DestRandImageName,$CreatedImage,$Quality,$ImageType[$i]))
					{
						echo 'Error Creating thumbnail';
					}
					/*
					At this point we have succesfully resized and created thumbnail image
					We can render image to user's browser or store information in the database
					For demo, we are going to output results on browser.
					*/
					
					//Get New Image Size
					list($ResizedWidth,$ResizedHeight)=getimagesize($DestRandImageName);

					// echo "<div style = \"margin-top: 20px;\"class = \"alert alert-success\">Congratulations! The following image/s successfully uploaded!</div>";
					// echo '<table class = "table" width="100%" border="0" cellpadding="4" cellspacing="0">';
					
					// echo '<tr><td align="center"><img src="'.$DestinationDirectory.$ThumbPrefix.$NewImageName.'" alt="Thumbnail" width="'.$ThumbSquareSize.'"></td></tr>';
				
					// echo '<tr><td align="center"><img src="'.$DestinationDirectory.$NewImageName.'" alt="Resized Image" height="'.$ResizedHeight.'" width="'.$ResizedWidth.'"></td>';
					// echo '</tr>';
					// echo '</table>';
					/*
					// Insert info into database table!
					mysql_query("INSERT INTO myImageTable (ImageName, ThumbName, ImgPath)
					VALUES ($DestRandImageName, $thumb_DestRandImageName, 'uploads/')");
					*/

			}else{
				echo '<div class="alert alert-danger">Error occurred while trying to process <strong>'.$ImageName[$i].'</strong>! Please check if file is supported</div>'; //output error
			}
			
		}

		
	} //END for
	// echo '</ul>';
	} //END IS_ARRAY
}	//END FOREACH
					//BEGIN FOR ITEM IMAGE USE
			echo "<div align=\"center\">";
			echo "<div style = \"margin-top: 20px;\"class = \"alert alert-success\">Congratulations! The following image/s successfully uploaded!</div>";
							$directory = "uploads/$hashedUserID/Items/$hashedItemID";
							$files = scandir($directory);
							$excluded = array('.','..');
							$result_files = array_diff($files, $excluded);
							$thumbnail = array();
							$fullsize = array();
								foreach ($result_files as $key => $value) {
									$thumb = strpos($value, "thumb_");								
									if($thumb===0){									
										 $thumbnail[] = $value;
										
									}else if($thumb!==0){									
										$fullsize[] = $value;
															
									}											
								}
							
						 //END FOR ITEM IMAGE USE		

									$count = count($thumbnail);
									echo "<table style = \"margin-top: 10px;\"><tr>";
									for ($i=0; $i < $count; $i++) { 
										// echo "itemID : $itemDetails->itemID :: index : $i<br />";
										// echo "userID : $itemDetails->userID :: index : $i<br />";
										// echo "$i";
										echo "<td style = \"padding: 0 5px;\"><img class = \"pull-left thumbnail img-responsive\" src=\"$directory/$thumbnail[$i]\"/></td>";
									}
									echo "</tr></table>";
			echo "</div>";

}	//END $_POST
// THIS FUNCTION WILL PROPORTIONALLY RESIZE IMAGE
function resizeImage($CurWidth,$CurHeight,$MaxSize,$DestFolder,$SrcImage,$Quality,$ImageType)
{
	//Check Image size is not 0
	if($CurWidth <= 0 || $CurHeight <= 0) 
	{
		return false;
	}
	
	//Construct a proportional size of new image
	$ImageScale      	= min($MaxSize/$CurWidth, $MaxSize/$CurHeight); 
	$NewWidth  			= ceil($ImageScale*$CurWidth);
	$NewHeight 			= ceil($ImageScale*$CurHeight);
	
	if($CurWidth < $NewWidth || $CurHeight < $NewHeight)
	{
		$NewWidth = $CurWidth;
		$NewHeight = $CurHeight;
	}
	$NewCanves 	= imagecreatetruecolor($NewWidth, $NewHeight);
	// Resize Image
	if(imagecopyresampled($NewCanves, $SrcImage,0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight))
	{
		switch(strtolower($ImageType))
		{
			case 'image/png':
				imagepng($NewCanves,$DestFolder);
				break;
			case 'image/gif':
				imagegif($NewCanves,$DestFolder);
				break;			
			case 'image/jpeg':
			case 'image/pjpeg':
				imagejpeg($NewCanves,$DestFolder,$Quality);
				break;
			default:
				return false;
		}
	if(is_resource($NewCanves)) { 
      imagedestroy($NewCanves); 
    } 
	return true;
	}

}

//THIS FUNCTION CORPS IMAGE TO CREATE EXACT SQUARE IMAGES, NO MATTER WHAT ITS ORIGINAL SIZE!
function cropImage($CurWidth,$CurHeight,$iSize,$DestFolder,$SrcImage,$Quality,$ImageType)
{	 
	//Check Image size is not 0
	if($CurWidth <= 0 || $CurHeight <= 0) 
	{
		return false;
	}
	
	//abeautifulsite.net has excellent article about "Cropping an Image to Make Square"
	//http://www.abeautifulsite.net/blog/2009/08/cropping-an-image-to-make-square-thumbnails-in-php/
	if($CurWidth>$CurHeight)
	{
		$y_offset = 0;
		$x_offset = ($CurWidth - $CurHeight) / 2;
		$square_size 	= $CurWidth - ($x_offset * 2);
	}else{
		$x_offset = 0;
		$y_offset = ($CurHeight - $CurWidth) / 2;
		$square_size = $CurHeight - ($y_offset * 2);
	}
	
	$NewCanves 	= imagecreatetruecolor($iSize, $iSize);	
	if(imagecopyresampled($NewCanves, $SrcImage,0, 0, $x_offset, $y_offset, $iSize, $iSize, $square_size, $square_size))
	{
		switch(strtolower($ImageType))
		{
			case 'image/png':
				imagepng($NewCanves,$DestFolder);
				break;
			case 'image/gif':
				imagegif($NewCanves,$DestFolder);
				break;			
			case 'image/jpeg':
			case 'image/pjpeg':
				imagejpeg($NewCanves,$DestFolder,$Quality);
				break;
			default:
				return false;
		}
	if(is_resource($NewCanves)) { 
      imagedestroy($NewCanves); 
    } 
	return true;

	}
	  
}
?>