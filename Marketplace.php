<?php ob_start(); ?>
<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require_once("_/components/includes/functions.php"); ?>
<?php require_once("_/components/includes/class/business.php"); ?>
<?php require_once("_/components/includes/class/item.php"); ?>
<?php 
		if(isset($_GET['category'])){
			$itemCategory = $_GET['category'];
			$title = "$itemCategory in Davao Region - Davao Webgate";
		}else {redirect_to('index.php');}
		
	?>
	<?php include("_/components/includes/header.php");?>
    <?php include("_/components/includes/carousel.php");?>
    <section class="main col col-lg-12 col-md-12 col-sm-12 col-xs-12">
      &nbsp;
      <?php include("_/components/includes/tabbed_options_query.php");?>
        <div class = "clearfix"></div>
	   <div class = "row">
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
	$item->itemCategory = $_GET['category'];
	$itemObject = Item::find_by_itemCategory($item->itemCategory);
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
						echo "<tr><td width = '120'><b>Category:</b></td><td>$itemDetails->itemCategory</td></tr>";
						echo "<tr><td width = '120'><b>Price:</b></td><td><i><b>Php&nbsp;$itemDetails->itemPrice</b></i></td></tr>";
						echo "<tr><td width = '120'><b>Contact Info:</b></td><td>$itemDetails->itemContactInfo</td></tr>";
						
						date_default_timezone_set('Asia/Manila');						
										
						echo"</table><br />";
						$itemDescription = html_entity_decode($itemDetails->itemDescription);															
						echo "<b><i>Description:</i></b><br /><p>"; echo $itemDescription; echo"</p>";
						echo "<p><b>Tags : </b>$itemDetails->itemTags</p>";
						echo "<br />";
						
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
	}else {
		$message = "Sorry, there are no items posted in <b>$itemCategory</b> category.";
		echo "<div class =\"alert alert-danger\" style=\"font-size: 1em;\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$message</div>";
		
	}
?>
</section>
<section class = "col col-lg-4 col-md-4 col-sm-4  col-xs-12">
	<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Latest Items</h3>
			</div>
			<div class="panel-body similarANDlatest" style = "height: 552px;">
				
					 <ul class="media-list">
						<?php //BEGIN LATEST ITEM QUERY
						$latestItem = new Item();
						if(isset($_GET['category'])){							
							$latestItemObject = Item::find_by_latest(3);
							if (!empty($latestItemObject)) {
								//var_dump($simlarItemObject);
								foreach ($latestItemObject as $object => $latestItemDetails) {
									echo"<li class=\"media\">";									
									$t = hash("sha512", time());
									$uid = hash('sha512', $latestItemDetails->itemID);
									$q = hash('sha512', $latestItemDetails->userID);
									$_SESSION['itemTitle'] = $latestItemDetails->itemTitle;
									$itemTitle = removeslashes($latestItemDetails->itemTitle);
										echo"<div class=\"col col-lg-6 col-md-6 col-sm-6  col-xs-6\">";//BEGIN PLACEHOLDER FOR ITEM IMAGE
											//BEGIN FOR ITEM IMAGE USE
												$hashedUserID = hash('sha256', $latestItemDetails->userID);
												$hashedItemID = hash('sha256', $latestItemDetails->itemID);				
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
													echo"<a class=\"thumbnail\" href=\"itemDetailed.php?category=".urlencode($latestItemDetails->itemCategory)."&itemID=".$latestItemDetails->itemID."\"><img src=\"$directory/$thumbnail[0]\"/></a>";
												}else {
													echo"<a class=\"thumbnail\" href=\"#\"><img src=\"images/webgate_logo_gray.png\"/></a>";
												}
											 //END FOR ITEM IMAGE USE
											  echo"</div>";// END PLACEHOLDER FOR ITEM IMAGE	
											 echo "<div class=\"media-body\">";
												echo "<span style =\"color: #0086aa;\"><h5 class=\"media-heading\">".$itemTitle."</h5></span>";
												echo "<span style =\"color: #363636; font-size: .8em;\"><p><b>Php</b> ".$latestItemDetails->itemPrice."</p></span>";
												echo "<span style = \"color: #999; font-size: .8em;\"><p>".$latestItemDetails->itemCategory."</p></span>";
												date_default_timezone_set('Asia/Manila');						
												$timestamp1 = date("j F Y | g:i A", $latestItemDetails->itemPostDate);
												echo "<span style = \"color: #999; font-size: .7em; margin-top: 0;\"><p>".$timestamp1."</p></span>";					
											echo "</div>";
												
										echo "</li>";
											
								}//END FOREACH
							}else{echo "No latest Items exist in the Database";}
								
						}								
					
					//END LATEST ITEM QUERY ?>
					 </ul><!-- class media-list -->

			</div><!--panel body-->  
		</div><!--panel panel-info-->
</section>
</div>
<div class = "clearfix"></div>
&nbsp;
<?php include("_/components/includes/featured_listing.php");?>
</section><!--main-->

<?php include("_/components/includes/footer_marketplace.php");?>
<?php ob_end_flush();?>