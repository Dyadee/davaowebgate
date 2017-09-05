
<!DOCTYPE HTML >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<!-- <link href="../_/css/bootstrap.css" rel="stylesheet" media="screen"> -->
<link href="styles/itemImageUpload.css" rel="stylesheet" type="text/css" />
<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->

</head>
<body>
<body>
<div id="uploaderform">
	<div align="center">
		<h3>Image Upload For Item: </h3>
		<span class="">Image Type Allowed: .jpeg, .jpg, .png and .gif. | Maximum Size 2 MB</span>
		<form action="itemImageUploadProcess.php" method="post" enctype="multipart/form-data" name="UploadForm" id="UploadForm">
		    <h1>Multi image file upload with PHP and jQuery</h1>
		    <p>Each recommended image file size must be less than 1MB!</p>
		    
		    <label>Files
		    <span class="small"><a href="#" id="AddMoreFileBox">Add More Files</a></span>
		    </label>
		    <div id="AddFileInputBox"><input id="fileInputBox" style="margin-bottom: 5px;" type="file"  name="file[]"/></div>
		    <div class="sep_s"></div>
		   
		    <button type="submit" class="button" id="SubmitButton">Upload</button>
		    
		    <div id="progressbox"><div id="progressbar"></div ><div id="statustxt">0%</div ></div>
		</form>
	


	</div>
</div><!--  uploaderform -->

<div id="uploadResults">
	<div align="center" style="margin:20px;"><a href="#" id="ShowForm">Toggle Form</a></div>
    <div id="output"></div>
</div>
<script type="text/javascript" src="js/jquery-1.10.2.min.js" ></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/myMultipleUploads.js"></script>
</body>
</html>
