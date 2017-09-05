
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
	$itemObject = Item::find_by_itemID($item->itemID);
	if(!empty($itemObject)){
		foreach($itemObject as $object => $itemDetails){
			$itemTitle = removeslashes($itemDetails->itemTitle);
		}
	}else {redirect_to("itemView.php");}
	
	
	
?>
<!DOCTYPE HTML >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link href="_/css/bootstrap.css" rel="stylesheet" media="screen">
<link href="style/itemImageUpload.css" rel="stylesheet" type="text/css" />

<!-- <link href="style/style.css" rel="stylesheet" type="text/css" /> -->

</head>
<body>
<body>
<div id="upload-wrapper">
<div id="uploaderform">
	<div align="center">
		<h3>Image Upload For Item: <?php echo "<b>$itemTitle</b>"; unset($itemTitle); ?></h3>
		<span class="">Image Type Allowed: .jpeg, .jpg, .png and .gif. | Maximum Size 2 MB</span>
		<form action="itemImageUploadProcess.php?t=<?php echo urlencode("$time");?>&uid=<?php echo urlencode("$uid");?>&iid=<?php echo urlencode("$itemID");?>&q=<?php echo urlencode("$q");?>" method="post" enctype="multipart/form-data" name="UploadForm" id="UploadForm">
		    <p>Each recommended image file size must be less than 2MB!</p>
		    
		  <!--   <label>Files
		    <span class="small"><a href="#" id="AddMoreFileBox">Add More Files</a></span>
		    </label> -->
		    <div id="AddFileInputBox">
		    	<div id="AddFileInput">
		    		<input id="fileInputBox" class = "pull-left" style="margin: 5px 10px;" type="file"  name="file[]"/><a href="#" id="AddMoreFileBox" class = "pull-left" style="margin: 10px 0;"><span  class = "glyphicon glyphicon-plus"></span></a>
		    	</div>
		    </div>
		    <!-- <div class="sep_s"></div> -->
		   
		    <!-- <button type="submit" class="button" id="SubmitButton">Upload</button> -->
		    <div class="clearfix"></div>
		    <div align = "center" style = "margin-top: 10px;">
					<button type="submit" id="SubmitButton" class="btn btn-success btn-sm"><span class = "glyphicon glyphicon-arrow-up"></span> Upload</button>&nbsp;&nbsp;&nbsp;
					<a href="itemView.php" class="btn btn-danger btn-sm"><span class = "glyphicon glyphicon-ban-circle"></span> Back</a>
				</div>
		    
		    <!-- <div id="progressbox" ><div id="progressbar" ></div ><div id="statustxt">0%</div ></div> -->
		    <div id="progressbox" class="progress progress-striped active"  style="display:none;" aria-valuemin="0" aria-valuemax="100" >
				<div id="progressbar" class="progress-bar"  role="progressbar" ></div ><div id="statustxt">0%</div>
			</div>
		</form>
	


	</div>
</div><!--  uploaderform -->
</div>
<div id="uploadResults">
	<!-- <div align="center" style="margin:20px;"><a href="#" id="ShowForm">Toggle Form</a></div> -->
	<div id="loading-img" align = "center" style="display:none; margin:0; padding:0;"><img src="images/ajax-loader.gif"  alt="Please Wait"/>&nbsp;&nbsp;Please wait until upload is verified...</div>
    <div id="output"></div>
</div>
<script type="text/javascript" src="_/js/jquery-1.10.2.min.js" ></script>
<script type="text/javascript" src="_/js/jquery.form.js"></script>
<script type="text/javascript" src="_/js/myMultipleUploads.js"></script>
</body>
</html>
