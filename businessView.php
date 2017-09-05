<?php ob_start(); ?>
<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require_once("_/components/includes/functions.php"); ?>
<?php require_once("_/components/includes/class/business.php"); ?>
<?php require_once("_/components/includes/class/item.php"); ?>
<?php require_once("_/components/includes/class/categories.php"); ?>
<?php require_once("_/components/includes/class/privateMessage.php"); ?>
<?php include("_/components/includes/header.php");?>
<?php $session->confirm_logged_in(); ?>

<aside class = "col-lg-3 col-md-3 col-sm-4 col-xs-12">
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
		<li class = "active"><a href="businessView.php">View My Business List</a></li>
		<li><a href="#">View My Job Posts</a></li>
		<li><a href="itemView.php">View My Items</a></li>
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
			if(isset($_SESSION['successbusinessRegistration'])){
				$successRegister = $_SESSION['successbusinessRegistration'];
				echo "<div class =\"alert alert-success\" style=\"font-size: .85em;\"><span class = \"glyphicon glyphicon-check\"></span>&nbsp;&nbsp;&nbsp;$successRegister</div>";								
				unset($_SESSION['successbusinessRegistration']);				
			}
?>
<?php 
	$business = new Business();
	$business->userID = $_SESSION['userID'];
	$businessObject = Business::find_by_userID($business->userID);
	if(!empty($businessObject)){
	
	foreach($businessObject as $object => $businessDetails){
				
				$t = hash("sha512", time());
				$uid = hash('sha512', $businessDetails->businessID);
				$q = hash('sha512', $businessDetails->userID);
				$_SESSION['businessName'] = $businessDetails->businessName;
				echo"<div class = \"row\">";
					echo"<div class=\"col col-lg-3 col-md-3 col-sm-3 col-xs-3\">";//PLACEHOLDER FOR LOGO
						//for logo use
							$hashedUserID = hash('sha256', $businessDetails->userID);
							$hashedBusinessID = hash('sha256', $businessDetails->businessID);				
							$directory = "uploads/$hashedUserID/Business/$hashedBusinessID";
							$files = scandir($directory);
							$excluded = array('.','..');
							$result_dir = array_diff($files, $excluded);
							if(!empty($result_dir)){
								echo"<a class=\"thumbnail\" href=\"#\"><img src=\"$directory/$result_dir[2]\"/></a>";
							}else {
								echo"<a class=\"thumbnail\" href=\"#\"><img src=\"images/webgate_logo_gray.png\"/></a>";
							}
						 //end for logo use		
						
					echo"</div>";
					echo"<div class =\"col col-lg-9 col-md-9 col-sm-9 col-xs-9\">";
						$businessName = removeslashes($businessDetails->businessName);
						echo "<div style = \"background: #28858a; padding: 4px 10px\"><span style=\"color: #fff; font-size: 1em;\"><b>$businessName</b></span></div>";
						echo "<div style = \"font-family: 'Helvetica','Trebuchet MS', sans-serif; font-size: .85em; color: #666; padding: 5px 10px;\">";
						echo"<table>";
						echo "<tr><td width = '120'><b>Category:</b></td><td>$businessDetails->businessCategory</td></tr>";
						echo "<tr><td><b>Type:</b></td><td>$businessDetails->businessType</td></tr>";
						echo "<tr><td><b>Address:</b></td><td>".$businessDetails->businessAddress.", ".$businessDetails->businessLocation."</td></tr>";
						$formatted_phone = preg_replace('/,\s/', '&nbsp;&nbsp;\&nbsp;&nbsp;', $businessDetails->businessPhone);
						echo "<tr><td><b>Contact Phone:</b></td><td>$formatted_phone</td></tr>";
						if(!empty($businessDetails->businessFax)){
							$formatted_fax = preg_replace('/,\s/', '&nbsp;&nbsp;\&nbsp;&nbsp;', $businessDetails->businessFax);
							echo "<tr><td><b>Business Fax:</b></td><td>$formatted_fax</td></tr>";
						}
						echo "<tr><td><b>Email:</b></td><td>$businessDetails->businessEmail</td></tr>";
						if(!empty($businessDetails->businessWebsite)){
							echo "<tr><td><b>website:</b></td><td><a class = \"weblink\" href=\"$businessDetails->businessWebsite\" target=\"_new\">$businessDetails->businessWebsite</a></td></tr>";
						}
						date_default_timezone_set('Asia/Manila');						
						$timestamp1 = date("l | j F Y | g:i A", $businessDetails->businessPostDate);
						echo "<tr><td><b>Date Posted:</b></td><td>$timestamp1</td></tr>";						
						if(!empty($businessDetails->businessUpDate)){
							$timestamp2 = date("l | j F Y | g:i A", $businessDetails->businessUpDate);
							echo "<tr><td><b>Date Updated:</b></td><td>$timestamp2</td></tr>";
						}					
						echo"</table><br />";
						$unclean_description = $businessDetails->businessDescription;
															
						echo "<b><i>Description:</i></b><br /><p>"; echo removeslashes($unclean_description)."</p>";
						echo "<p><b>Tags : </b>$businessDetails->businessTags</p>";
						echo "<br /><br />";
						echo"</div>";			
						echo"<div align=\"right\">";
						echo"<a href=\"businessUpdate.php?t=$t&uid=$uid&bid={$businessDetails->businessID}&q=$q\" class=\"btn btn-xs btn-success \"><span class = \"glyphicon glyphicon-edit\"></span> Edit</a>&nbsp;&nbsp;";
						if(!empty($result_dir)){
							echo"<a href=\"uploadLogo.php?t=$t&uid=$uid&bid={$businessDetails->businessID}&q=$q\"\" class=\"btn btn-xs btn-danger \"><span class = \"glyphicon glyphicon-camera\"></span> Change Logo</a>";
						}else {echo"<a href=\"uploadLogo.php?t=$t&uid=$uid&bid={$businessDetails->businessID}&q=$q\"\" class=\"btn btn-xs btn-danger \"><span class = \"glyphicon glyphicon-camera\"></span> Add Logo</a>";}
						echo "</div>";
					echo"</div>";
				echo"</div>";
				echo "<hr />";
		}
	}else {
		$message = "You do not have yet your business posted in Davao Webgate";
		echo "<div class =\"alert alert-success\" style=\"font-size: 1em;\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$message</div>";
		
	}
?>
</section>
 <div class = "clearfix"></div>
 &nbsp;
<?php include("_/components/includes/footer.php");?>
<?php ob_end_flush();?>