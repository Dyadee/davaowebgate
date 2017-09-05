<?php ob_start(); ?>
<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require_once("_/components/includes/functions.php"); ?>
<?php require_once("_/components/includes/class/business.php"); ?>
<?php require_once("_/components/includes/class/item.php"); ?>
    <?php 
		if(isset($_POST['queryWebgate'])){
			if(isset($_POST['searchQuery']) && !empty($_POST['searchQuery']) && strlen($_POST['searchQuery'])>2){
				$searchQuery = trim($_POST['searchQuery']);				
					$title = "$searchQuery in Davao Region | Business Listings - Davao Webgate";				
			}else{
				$searchQuery = "";
				$title = "Business Listings in Davao Region - Davao Webgate";
			}
			
			if(isset($_POST['searchCategory']) || !empty($_POST['searchCategory']) || strlen($_POST['searchQuery']) != 0){
				$searchCategory = trim($_POST['searchCategory']);
			}
		}
	?>
	<?php include("_/components/includes/header.php");?>
    <?php include("_/components/includes/carousel.php");?>
    <section class="main col col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
      &nbsp;
       <?php include("_/components/includes/tabbed_options_query.php");?>
       <div class = "clearfix"></div>
<div class="col col-lg-3  col-md-3 col-sm-12 col-xs-12 pull-right">
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
					echo "<span style =\"color: #0086aa;\"><h4 class=\"media-heading\">".removeslashes($businessDetails->businessName)."</h4></span>";
					echo "<span style =\"color: #363636; font-size: .8em;\"><p>".substr($businessDetails->businessDescription, 0, 70)."...</p></span>";					
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
  </div><!--panel-body-->
  
</div><!--panel panel-info-->
</div><!--Latest Listings-->
<div class="col col-lg-9 col-md-9 col-sm-12 col-xs-12 pull-left">
<?php 
	//if $searchQuery && ($searchCategory == "Products" || $searchCategory == "Services")
	if ($searchCategory == "Products" || $searchCategory == "Services") {		
	
	$business = new Business();
	if(isset($searchQuery) && strlen($searchQuery)>2){
		$businessQuery_sanitized = $database->PrepSQL(htmlspecialchars($searchQuery));
		$searchCategory_sanitized = $database->PrepSQL(htmlspecialchars($searchCategory));
		$businessObject = Business::find_by_search_match($businessQuery_sanitized, $searchCategory_sanitized);
	
	 if(!empty($businessObject)){
	 $result_count = count($businessObject);
	 echo "<div class = \"alert alert-success\"><p>Your query for <b>\"".$businessQuery_sanitized."\"</b> in <b>".$searchCategory_sanitized."</b>  returned <b>$result_count</b> results.</p></div>";
	 foreach($businessObject as $object => $businessDetails){
					//PLACEHOLDER FOR LOGO
					//echo "<div class=\"col\">";
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
					echo"<div class =\"col col-lg-9 col-md-9 col-sm-9 col-xs-9 \">";
						echo "<div style = \"background: #226a6b; padding: 4px 10px\"><span style=\"color: #fff; font-size: 1em;\"><b>".removeslashes($businessDetails->businessName)."</b></span></div>";
						echo "<div style = \"background: #e6f2e8; font-family: 'Helvetica','Trebuchet MS', sans-serif; font-size: .85em; color: #666; padding: 5px 15px 15px;\">";
						echo"<table>";
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
						//echo"</div>";
						echo "&nbsp;";
						echo "<hr />";		
				
					
		}//END foreach
	}else {
		$message = "Sorry, your query for <b>\"".$businessQuery_sanitized."\" </b> in <b>".$searchCategory_sanitized."</b> returned <b>0</b> result.";		
		echo "<div class =\"alert alert-danger\" style=\"font-size: 1em;\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$message</div>";
	}//END if(!empty($businessObject))
	}else {
		$message =  "Sorry, you didn't enter anything on the search field.";
		echo "<div class =\"alert alert-danger\" style=\"font-size: 1em;\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$message</div>";
		
	}//END if(isset($_POST['searchquery']) && !empty($_POST['searchquery']))
}//end if $searchCategory

 	//if $searchQuery && ($searchCategory == "Marketplace")
	else if ($searchCategory == "Marketplace") {		
	$item = new Item();
	if(isset($searchQuery) && strlen($searchQuery)>2){
		$itemQuery_sanitized = $database->PrepSQL(htmlspecialchars($searchQuery));
		$searchCategory_sanitized = $database->PrepSQL(htmlspecialchars($searchCategory));
		$itemObject = Item::find_by_search_match($itemQuery_sanitized);

	if(!empty($itemObject)){
		$result_count = count($itemObject);
	echo "<div class = \"alert alert-success\"><p>Your query for <b>\"".$itemQuery_sanitized."\"</b> in <b>".$searchCategory_sanitized."</b>  returned <b>$result_count</b> results.</p></div>";
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
							if(!empty($result_files)){
								echo"<a class=\"thumbnail\" href=\"#".md5(hash('sha256', $itemDetails->itemID))."\" data-toggle =\"modal\" ><img src=\"$directory/$thumbnail[0]\"/></a>";
							}else {
								echo"<a class=\"thumbnail\" href=\"#\"><img src=\"images/webgate_logo_gray.png\"/></a>";
							}
						 //END FOR ITEM IMAGE USE					
					echo"</div>";// END PLACEHOLDER FOR ITEM IMAGE
					echo"<div class =\"col col-lg-9 col-md-9 col-sm-9 col-xs-9\">";
						echo "<div class = \"title_container\" style = \"background: #28858a; padding: 4px 10px\"><span style=\"color: #fff; font-size: 1em;\">";
						echo"<a href = \"itemDetailed.php?category=".urlencode($item->itemCategory)."&itemID=$itemDetails->itemID\" onClick = \"readComments($itemDetails->itemID);\"><b>$itemTitle</b></a></span></div>";
						echo "<div style = \"font-family: 'Helvetica','Trebuchet MS', sans-serif; font-size: .85em; color: #666; padding: 5px 10px;\">";
						echo"<table>";
						//echo "<tr><td width = '120'><b>Category:</b></td><td>$itemDetails->itemCategory</td></tr>";
						echo "<tr><td width = '120'><b>Price:</b></td><td><i><b>Php&nbsp;$itemDetails->itemPrice</b></i></td></tr>";
						echo "<tr><td width = '120'><b>Contact Info:</b></td><td>$itemDetails->itemContactInfo</td></tr>";
						
						date_default_timezone_set('Asia/Manila');						
										
						echo"</table><br />";
						$itemDescription = html_entity_decode($itemDetails->itemDescription);															
						echo "<b><i>Description:</i></b><br /><p>"; echo $itemDescription; echo"</p>";
						echo "<p><b>Tags : </b>$itemDetails->itemTags</p>";
						echo "<p><span style = \"color: #999; font-weight: bold;\">Posted in: &nbsp;&nbsp;&nbsp;</span></span><span style = \"color: #999;\">Marketplace &nbsp;|&nbsp; $itemDetails->itemCategory</span></p>";
						//echo "<br />";
						
						echo "<div><p class ="; if(empty($itemDetails->itemUpDate)){echo" \"pull-right\"";}else {echo" \"pull-left\"";}
						
						echo" style = \"font-size: .8em; color:#999;\">";
							$timestamp1 = date("l | j F Y | g:i A", $itemDetails->itemPostDate);
							echo "<b>Date Posted:</b>&nbsp;&nbsp;$timestamp1";
						echo "</p><p class = \"pull-right\" style = \"font-size: .8em; color:#999;\">"; 
							if(!empty($itemDetails->itemUpDate)){
								$timestamp2 = date("l | j F Y | g:i A", $itemDetails->itemUpDate);
								echo "<b>Date Updated:</b>&nbsp;&nbsp;$timestamp2";
						}
						echo "</p></div>";
						echo"</div>";			
											
					echo"</div>";				
				echo"</div>";
				echo "<div id = \"".md5(hash('sha256', $itemDetails->itemID))."\" class = \"modal fade\">";
						echo "<div class = \"modal-dialog\">";
							echo "<div class = \"modal-content\">";
							echo "<div class = \"modal-header\">";
									echo "<button type = \"button\" style = \"background-color: #ffffff;\" class = \"pull-right\" data-dismiss = \"modal\">&times;</button>";
								echo "<p class = \"modal-title\"><b>$itemTitle:</b>&nbsp;&nbsp;<i>Php&nbsp;$itemDetails->itemPrice</i></p>";
							echo "</div>";//modal header
							echo "<div class = \"modal-body\" align =\"center\" style = \"padding-bottom: 0; margin-bottom:0;\">";
									
									
									echo "<div id = \"imageResult_$itemDetails->itemID\" align =\"center\" ><img class = \"img-responsive\"  src=\"$directory/$fullsize[0]\"/></div>";
									$count = count($fullsize);
									// echo "count : $count<br />";
									// echo "itemID : $itemDetails->itemID<br />";
									echo "<table style = \"margin-top: 10px;\" class = \"\"><tr>";
									for ($i=0; $i < $count; $i++) { 
										// echo "itemID : $itemDetails->itemID :: index : $i<br />";
										// echo "$i";
										echo "<td style = \"padding: 0 5px;\"><a href=\"#\"><img id = \"$i\" class = \"pull-left thumbnail img-responsive\" src=\"$directory/$thumbnail[$i]\" onClick = \"getImages($itemDetails->itemID, $itemDetails->userID, $i); return false;\"/></a></td>";
									}
									echo "</tr></table>";
									//echo"</div>";
								echo "</div>";//modal-body
								echo "<footer class = \"modal-footer\">";
									echo "<p><span class=\"pull-left\"style = \"color: #999; font-size: .8em; font-weight: bold;\">Posted in:"." &nbsp; ".$itemDetails->itemCategory."</span>";
										date_default_timezone_set('Asia/Manila');						
										if(!empty($itemDetails->itemUpDate)){
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
		}//	END FOREACH
	}else {//END if(!empty($itemObject))
		$message = "Sorry, your query for <b>\"".$itemQuery_sanitized."\" </b> in <b>".$searchCategory_sanitized."</b> returned <b>0</b> result.";
		echo "<div class =\"alert alert-danger\" style=\"font-size: 1em;\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$message</div>";
				
	}
	}else {echo "<div class = \"alert alert-danger\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;Sorry, you didn't enter anything on the search field.</div>";}
}//end else if $searchCategory == "Marketplace"
else if (empty($searchCategory) && !empty($searchQuery)) {
	$message = "Sorry, you didn't choose a <em><b>category</b></em> to match your search for <em><b>\"".htmlspecialchars($searchQuery)."\"</b></em>.";
	echo "<div class = \"alert alert-danger\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$message</div>";
}
else if (empty($searchQuery) && !empty($searchCategory)) {
	echo "<div class = \"alert alert-danger\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;Sorry, you didn't enter anything on the search field.</div>";
}
else if (empty($searchQuery) && empty($searchCategory)) {
	$message = "Please type a <em><b>keyword</b></em> in the search field and choose a <em><b>category</b></em> from which you want to search for.";
	echo "<div class = \"alert alert-danger\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$message.</div>";
}
?>
</div>
 <div class = "clearfix"></div>
 <?php include("_/components/includes/featured_listing.php");?>
</section><!--main-->
<?php include("_/components/includes/footer.php");?>
<?php ob_end_flush();?>