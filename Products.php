<?php ob_start(); ?>
<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require_once("_/components/includes/functions.php"); ?>
<?php require_once("_/components/includes/class/business.php"); ?>
<?php require_once("_/components/includes/class/item.php"); ?>
<?php //$session->confirm_logged_in_index(); ?>
    <?php 
		if(isset($_GET['type'])){
			$businessType = $_GET['type'];
			$title = "$businessType in Davao City | Davao Region Business Listings Offering Products - Davao Webgate";
		}else {redirect_to('index.php');}
	?>
	<?php include("_/components/includes/header.php");?>
    <?php include("_/components/includes/carousel.php");?>    
    <section class="main col col-lg-12">
		&nbsp;
<?php include("_/components/includes/tabbed_options_query.php");?>
 <div class = "clearfix"></div>
<?php echo"<div class=\"col col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-right\">";?>
	<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Latest Listings</h3>
  </div>
  <div class="panel-body">
   <ul class="media-list">
<?php
	$business = new Business();
	$businessObject = Business::find_by_latest(4);
	 if(!empty($businessObject)){
		foreach($businessObject as $object => $businessDetails){
			
			echo"<li class=\"media\">";
			//PLACEHOLDER FOR LOGO
					//for logo use
							$hashedUserID = hash('sha256', $businessDetails->userID);
							$hashedBusinessID = hash('sha256', $businessDetails->businessID);				
							$directory = "uploads/$hashedUserID/Business/$hashedBusinessID";
							$files = scandir($directory);
							$excluded = array('.','..');
							$result_dir = array_diff($files, $excluded);
							if(!empty($result_dir)){
								echo"<a class=\"thumbnail pull-left\" href=\"#\"><img class=\"media-object\" style = \"width: 100px; height: 100px;\" src=\"$directory/$result_dir[2]\"/></a>";
							}else {
								echo"<a class=\"thumbnail pull-left\" href=\"#\"><img class=\"media-object\" src=\"images/thumbnail_holder_sm.gif\"/></a>";
							}					
			//END PLACEHOLDER FOR LOGO
			
				echo "<div class=\"media-body\">";
					echo "<span style =\"color: #0086aa;\"><h4 class=\"media-heading\">".$businessDetails->businessName."</h4></span>";
					echo "<span style =\"color: #363636; font-size: .8em;\"><p>".substr($businessDetails->businessDescription, 0, 150)."...</p></span>";					
				echo "</div>";
					date_default_timezone_set('Asia/Manila');						
					$timestamp1 = date("D | j F Y | g:i A", $businessDetails->businessPostDate);
					echo "<span class=\"pull-left\" style = \"color: #999; font-size: .7em; margin-top: 0;\"><p><b>Date Posted:</b>"." &nbsp; ".$timestamp1."</p></span>";
			echo "</li>";
			//echo"<hr />";
		}
	 }
?>
   </ul>
  </div>
  
</div><!--panel left 2-->
</div>
<div class="col col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-left">
 <?php 
	$business = new Business();
	$business->businessType = $businessType = $_GET['type'];
	$businessObject = Business::find_by_businessType($business->businessType);
	 if(!empty($businessObject)){
	 foreach($businessObject as $object => $businessDetails){

					//PLACEHOLDER FOR LOGO
					
					echo"<div class=\"col col-lg-3 col-md-3 col-sm-3 col-xs-3 \">";
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
								echo"<a class=\"thumbnail\" href=\"#\"><img src=\"images/thumbnail_holder.gif\"/></a>";
							}						
					echo"</div>";
					//END PLACEHOLDER FOR LOGO
					echo"<div class =\"col col-lg-9 col-md-9 col-sm-9 col-xs-9\">";
						echo "<div style = \"background: #28858a; padding: 4px 10px\"><span style=\"color: #fff; font-size: 1em;\"><b>".removeslashes($businessDetails->businessName)."</b></span></div>";
						echo "<div style = \"background: #e6f2e8; font-family: 'Helvetica','Trebuchet MS', sans-serif; font-size: .85em; color: #666; padding: 5px 15px 15px;\">";
						echo"<table class=\"table-responsive\">";
						// echo "<tr><td width = '120'><b>Category:</b></td><td>$businessDetails->businessCategory</td></tr>";
						// echo "<tr><td><b>Type:</b></td><td>$businessDetails->businessType</td></tr>";
						echo "<tr><td width = '120'><b>Address:</b></td><td>$businessDetails->businessAddress, $businessDetails->businessLocation</td></tr>";
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
						// date_default_timezone_set('Asia/Manila');						
						// $timestamp1 = date("l | j F Y | g:i A", $businessDetails->businessPostDate);
						// echo "<tr><td><b>Date Posted:</b></td><td>$timestamp1</td></tr>";						
						// if(!empty($businessDetails->businessUpDate)){
							// $timestamp2 = date("l | j F Y | g:i A", $businessDetails->businessUpDate);
							// echo "<tr><td><b>Date Updated:</b></td><td>$timestamp2</td></tr>";
						// }						
						echo"</table><br />";
						$unclean_description = $businessDetails->businessDescription;
															
						echo "<b><i>Description:</i></b><br />"; echo "<p>".removeslashes($unclean_description)."</p>";
						echo "<p><b>Tags : </b>$businessDetails->businessTags</p>";
						echo "<p><span style = \"color: #999; font-weight: bold;\">Posted in: &nbsp;&nbsp;&nbsp;</span></span><span style = \"color: #999;\">$businessDetails->businessCategory &nbsp;|&nbsp; $businessDetails->businessType</span></p>";
						echo "</div>";							
						echo"</div>";						
						echo "&nbsp;";
						echo "<hr />";
		}
	}else {
		$message = "Sorry, there is still no business listed in <b>Products - ".$business->businessType." </b>category.";
		echo "<div class =\"alert alert-danger\" style=\"font-size: 1em;\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$message</div>";
	}
 ?>
 </div>
<div class = "clearfix"></div>
<?php include("_/components/includes/featured_listing.php");?>
</section><!--main-->

<?php include("_/components/includes/footer.php");?>
<?php ob_end_flush();?>