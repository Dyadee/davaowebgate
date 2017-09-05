<?php ob_start(); ?>
<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require_once("_/components/includes/functions.php"); ?>
<?php require_once("_/components/includes/class/business.php"); ?>
<?php require_once("_/components/includes/class/item.php"); ?>
<?php require_once("_/components/includes/class/privateMessage.php"); ?>
<?php include("_/components/includes/header.php");?>
<?php $session->confirm_logged_in(); ?>
<aside class = "col-lg-3 col-md-3 col-sm-3 col-xs-12">
	<h4>What would you like to do?</h4>
	<ul class = "nav nav-pills nav-stacked">
		<li><a href="member.php">My Account Manager</a></li>
		<li><a href="myPrivateMessages.php">My Private Messages <?php $privateMessages = new PrivateMessage();
				$privateMessages->toUserID = $_SESSION['userID'];
				$privateMessageObject = PrivateMessage::find_by_receiver($privateMessages->toUserID);
				if (!empty($privateMessageObject)) {
					$counted_messages = (int)count($privateMessageObject);
				}else {$counted_messages = '0';}				 
				echo "($counted_messages)";
				?></a></li>
		<li><a href="businessView.php">View My Business List</a></li>
		<li><a href="#jade" data-toggle = "modal">View My Job Posts</a></li>
		<li class = "active"><a href="itemView.php">View My Items</a></li>
		<li><a href="businessRegistration.php">Add a Business List</a></li>
		<li><a href="#">Post a Job</a></li>
		<li><a href="marketplacePost.php">Sell an Item</a></li>
		<li><a href="userUpdate.php">Edit Account</a></li>
		<li><a href="loginUpdate.php">Change Login Information</a></li>
		<li><a href="logout.php">Logout</a></li>
	</ul>
</aside>
<section class="col col-lg-8 col-md-8 col-sm-8 col-xs-12">
<?php
			if(isset($_SESSION['successItemPost'])){
				$successItemPost = $_SESSION['successItemPost'];
				echo "<div class =\"alert alert-success\" style=\"font-size: .85em;\"><span class = \"glyphicon glyphicon-check\"></span>&nbsp;&nbsp;&nbsp;$successItemPost</div>";								
				unset($_SESSION['successItemPost']);				
			}
?>
<?php 
	$item = new Item();
	$item->userID = $_SESSION['userID'];
	$itemObject = Item::find_by_userID($item->userID);
	if(!empty($itemObject)){
	
	foreach($itemObject as $object => $itemDetails){
				
				$t = hash("sha512", time());
				$uid = hash('sha512', $itemDetails->itemID);
				$q = hash('sha512', $itemDetails->userID);
				$_SESSION['itemTitle'] = $itemDetails->itemTitle;
				$itemTitle = removeslashes($itemDetails->itemTitle);
				echo"<div class = \"row\">";
					echo"<div class=\"col col-lg-3 col-md-3 col-sm-3 col-xs-3\">";//BEGIN PLACEHOLDER FOR ITEM IMAGE
						//BEGIN FOR ITEM IMAGE USE
							$hashedUserID = hash('sha256', $itemDetails->userID);
							$hashedItemID = hash('sha256', $itemDetails->itemID);				
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
								// global $fullsize;
								// var_dump($fullsize);
								// var_dump($thumbnail);
									

							if(!empty($result_files)){
								echo"<a class=\"thumbnail\" href=\"#".md5(hash('sha256', $itemDetails->itemID))."\" data-toggle =\"modal\" ><img src=\"$directory/$thumbnail[0]\"/></a>";
							}else {
								echo"<a class=\"thumbnail\" href=\"#\"><img src=\"images/webgate_logo_gray.png\"/></a>";
							}
						 //END FOR ITEM IMAGE USE					
					echo"</div>";// END PLACEHOLDER FOR ITEM IMAGE
					echo"<div class =\"col col-lg-9 col-md-9 col-sm-9 col-xs-9\">";
						echo "<div class = \"title_container\" style = \"background: #28858a; padding: 4px 10px\"><span style=\"color: #fff; font-size: 1em;\">";
						echo"<a href = \"userItems.php?category=".urlencode($itemDetails->itemCategory)."&t=$t&uid=$uid&iid=$itemDetails->itemID&q=$q\" onClick = \"readComments($itemDetails->itemID);\"><b>$itemTitle</b></a></span></div>";
						echo "<div style = \"font-family: 'Helvetica','Trebuchet MS', sans-serif; font-size: .85em; color: #666; padding: 5px 10px;\">";
						echo"<table>";
						echo "<tr><td width = '120'><b>Category:</b></td><td>$itemDetails->itemCategory</td></tr>";
						echo "<tr><td width = '120'><b>Price:</b></td><td><i><b>Php&nbsp;$itemDetails->itemPrice</b></i></td></tr>";
						echo "<tr><td width = '120'><b>Contact Info:</b></td><td>$itemDetails->itemContactInfo</td></tr>";
						date_default_timezone_set('Asia/Manila');						
						$timestamp1 = date("l | j F Y | g:i A", $itemDetails->itemPostDate);
						echo "<tr><td><b>Date Posted:</b></td><td>$timestamp1</td></tr>";						
						if(!empty($itemDetails->itemUpDate)){
							$timestamp2 = date("l | j F Y | g:i A", $itemDetails->itemUpDate);
							echo "<tr><td><b>Date Updated:</b></td><td>$timestamp2</td></tr>";
						}					
						echo"</table><br />";
						$itemDescription = html_entity_decode($itemDetails->itemDescription);															
						echo "<b><i>Description:</i></b><br /><p>"; echo $itemDescription; echo"</p>";
						echo "<p><b>Tags : </b>$itemDetails->itemTags</p>";
						echo "<br /><br />";
						echo"</div>";			
						echo"<div align=\"right\">";
						echo"<a href=\"itemUpdate.php?t=$t&uid=$uid&iid={$itemDetails->itemID}&q=$q\" class=\"btn btn-xs btn-success \"><span class = \"glyphicon glyphicon-edit\"></span> Edit</a>&nbsp;&nbsp;";
						if(!empty($result_files)){
							echo"<a href=\"itemImageUpload.php?t=$t&uid=$uid&iid={$itemDetails->itemID}&q=$q\"\" class=\"btn btn-xs btn-danger \"><span class = \"glyphicon glyphicon-camera\"></span> Change Item Image</a>";
						}else {echo"<a href=\"itemImageUpload.php?t=$t&uid=$uid&iid={$itemDetails->itemID}&q=$q\"\" class=\"btn btn-xs btn-danger \"><span class = \"glyphicon glyphicon-camera\"></span> Add Item Image</a>";}
						echo "</div>";					
					echo"</div>";				
				echo"</div>";
				echo "<div id = \"".md5(hash('sha256', $itemDetails->itemID))."\" class = \"modal fade\">";
						echo "<div class = \"modal-dialog\">";
							echo "<div class = \"modal-content\">";
							echo "<div class = \"modal-header\">";
									echo "<button type = \"button\" style = \"background-color: #ffffff;\" class = \"pull-right\" data-dismiss = \"modal\">&times;</button>";
								echo "<p class = \"modal-title\"><b>$itemTitle:</b>&nbsp;&nbsp;Php&nbsp;$itemDetails->itemPrice</p>";
							echo "</div>";
								echo "<div class = \"modal-body\" align =\"center\" style = \"padding-bottom: 0; margin-bottom:0; \">";
									
									
									echo "<div id = \"imageResult_$itemDetails->itemID\" align =\"center\" ><img  class = \"img-responsive\"  src=\"$directory/$fullsize[0]\"/></div>";
									$count = count($fullsize);
									// echo "count : $count<br />";
									// echo "itemID : $itemDetails->itemID<br />";
									echo "<table style = \"margin-top: 10px;\"><tr>";
									for ($i=0; $i < $count; $i++) { 
									
										echo "<td style = \"padding: 0 5px;\"><a href=\"#\"><img id = \"$i\" class = \"pull-left thumbnail img-responsive\" src=\"$directory/$thumbnail[$i]\" onClick = \"getImage($itemDetails->itemID, $i); return false;\"/></a></td>";
									}
									echo "</tr></table>";
									//echo"</div>";
								echo "</div>";//modal-body
								echo "<footer class = \"modal-footer\">";
									echo "<p><span class=\"pull-left\"style = \"color: #999; font-size: .8em; font-weight: bold;\">Posted in:"." &nbsp; ".$itemDetails->itemCategory."</span>";
										date_default_timezone_set('Asia/Manila');						
										if(($itemDetails->itemUpDate != NULL) || !empty($itemDetails->itemUpDate)){
											$timestamp = date("D | j F Y | g:i A", $itemDetails->itemUpDate);
											echo "<span class=\"pull-right\" style = \"color: #999; font-size: .7em; margin-top: 0;\"><b>Date Updated:</b>"." &nbsp; ".$timestamp."</p></span>";	
										}else {
											$timestamp = date("D | j F Y | g:i A", $itemDetails->itemPostDate);
											echo "<span class=\"pull-right\" style = \"color: #999; font-size: .7em; margin-top: 0;\"><b>Date Posted:</b>"." &nbsp; ".$timestamp1."</p></span>";	
										}
										
								echo "</footer>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "<hr />";
		}//END FOR EACH
	}else {
		$message = "You do not have yet any item posted in Davao Webgate";
		echo "<div class =\"alert alert-success\" style=\"font-size: 1em;\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$message</div>";
		
	}
?>
</section>
 <div class = "clearfix"></div>
 &nbsp;
<?php include("_/components/includes/footer.php");?>
<?php ob_end_flush();?>