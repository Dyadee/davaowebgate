<!-- This is your PHP script... myphpscript.php --> 
          
<?php 
$contentVar = $_POST['contentVar'];
if ($contentVar == "con1") {
    echo "My default content for this page element when the page initially loads";
} else if ($contentVar == "con2") {
    echo "This is content that I want to load when the second link or button is clicked";
} else if ($contentVar == "con3") {
    echo "Content for third click is now loaded. Any <strong>HTML</strong> or text you wish.";
}
?>

<!-- This is any HTML or PHP file you wish to use -->

<html>
<head>
<script type="text/javascript" src="jQuery-1.5.1.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
function swapContent(cv) {
    $("#myDiv").html('<img src="loader.gif"/>').show();
    var url = "myphpscript.php";
    $.post(url, {contentVar: cv} ,function(data) {
       $("#myDiv").html(data).show();
    });
}
//-->
</script>
<style type="text/css"> 
#myDiv{
    width:200px; height:150px; padding:12px; 
    border:#666 1px solid; background-color:#FAEEC5; 
    font-size:18px;
} 
</style> 
</head>
<body>
<a href="#" onClick="return false" onmousedown="javascript:swapContent('con1');">Content1</a>
<a href="#" onClick="return false" onmousedown="javascript:swapContent('con2');">Content2</a>
<a href="#" onClick="return false" onmousedown="javascript:swapContent('con3');">Content3</a>
<div id="myDiv">My default content for this page element when the page initially loads</div>
</body>
</html>