<?php ob_start();?>
<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require_once("_/components/includes/functions.php"); ?>
<?php require_once("_/components/includes/class/item.php"); ?>
<?php $session->confirm_logged_in(); ?>
<?php 

	$userID = $_SESSION['userID'];
	$hashedUserID = hash('sha256', $userID);
	if (isset($_GET['iid'])){
		$hashedItemID = hash('sha256', $_GET['iid']);
		$itemID = $_GET['iid'];
	}else {redirect_to("itemView.php");}
	$time = hash('sha256', time());
	$uid = hash('sha256', $_GET['iid']);
	$q = $hashedUserID;
	
	$item = new Item();
	$item->userID = $_SESSION['userID'];
	$item->itemID = $_GET['iid'];
	$itemObject = Item::find_by_itemID($item->userID, $item->itemID);
	if(!empty($itemObject)){
		foreach($itemObject as $object => $itemDetails){
			$itemTitle = removeslashes($itemDetails->itemTitle);
		}
	}else {redirect_to("itemView.php");}
	
	
	
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Davao Webgate Item Image Upload Form</title>

<link href="_/css/bootstrap.css" rel="stylesheet" media="screen">
<link href="style/style.css" rel="stylesheet" type="text/css">

</head>
<body>
<div id="upload-wrapper">
	<div align="center">
		<h3>Image Upload For Item: <?php echo "<b>$itemTitle</b>"; unset($itemTitle); ?></h3>
		<span class="">Image Type Allowed: .jpeg, .jpg, .png and .gif. | Maximum Size 2 MB</span>
		
		<form action="processImage.php?t=<?php echo urlencode("$time");?>&uid=<?php echo urlencode("$uid");?>&iid=<?php echo urlencode("$itemID");?>&q=<?php echo urlencode("$q");?>" onSubmit="return false" method="post" enctype="multipart/form-data" id="MyUploadForm">
			
			<input name="ImageFile" id="imageInput" type="file" />
							
				<div align = "center" style = "margin-top: 10px;">
					<button type="submit" id="SubmitButton" class="btn btn-success btn-sm"><span class = "glyphicon glyphicon-arrow-up"></span> Upload</button>&nbsp;&nbsp;&nbsp;
					<a href="itemView.php" class="btn btn-danger btn-sm"><span class = "glyphicon glyphicon-ban-circle"></span> Back</a>
				</div>
				
		</form>
		<div id="progressbox" class="progress progress-striped active"  style="display:none;" aria-valuemin="0" aria-valuemax="100" >
			<div id="progressbar" class="progress-bar"  role="progressbar"></div ><div id="statustxt">0%</div>
		</div>
		<div id="loading-img" align = "center" style="display:none; margin:0; padding:0;"><img src="images/ajax-loader.gif"  alt="Please Wait"/>&nbsp;&nbsp;Please wait until upload is verified...</div>
		<div id="output" ></div>
		
	</div>
</div>
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/jquery.form.min.js"></script>
<script type="text/javascript" src="js/imageUpload.js"></script>

</body>

</html>
