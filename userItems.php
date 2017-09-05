<?php ob_start(); ?>
<?php require_once("_/components/includes/class/session.php"); ?>
<?php require_once("_/components/includes/functions.php"); ?>
<?php require_once("_/components/includes/class/user.php"); ?>
<?php require_once("_/components/includes/class/business.php"); ?>
<?php require_once("_/components/includes/class/item.php"); ?>
<?php require_once("_/components/includes/class/privateMessage.php"); ?>
<?php require_once("_/components/includes/privateMessageValidation.php"); ?>
<?php $session->confirm_logged_in(); ?>
<?php //INITIATE OBJECT
	$item = new Item();
	$userID = $_SESSION["userID"];
	$item->itemID = $_GET['iid'];
	$itemObject = Item::find_by_userItemID($userID, $item->itemID);
	if(!empty($itemObject)){
	
	foreach($itemObject as $object => $itemDetails){
				
				$t = hash("sha512", time());
				$uid = hash('sha512', $itemDetails->itemID);
				$q = hash('sha512', $itemDetails->userID);
				$_SESSION['itemTitle'] = $itemDetails->itemTitle;
				$itemTitle = removeslashes($itemDetails->itemTitle);				
					
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
							
						 //END FOR ITEM IMAGE USE
?> <!-- //INITIATE OBJECT END -->
<?php $title = $itemTitle.":	".$itemDetails->itemCategory." in Davao Region - Davao Webgate";?>
<?php include("_/components/includes/header.php");?>

<div class = "row">
	<div class = "col col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="panel-title"><b><?php echo "$itemTitle"; ?></b></h2>
			</div>
		  <div class="panel-body">
		   	<div id = "itemImages" style = "height: 730px;">
		   		<!--place item images here-->

	<?php
							echo "<div align =\"center\" style = \"padding-bottom: 0; margin-bottom:0;\">";							
									
									echo "<div style = \"display: table-cell; vertical-align: middle; height: 550px; width: 550px;\" id = \"imageResult_$itemDetails->itemID\" align =\"center\" >";
									echo"<img class = \"img-responsive\" src=\"$directory/$fullsize[0]\" />";
									echo"</div>";
									$count = count($fullsize);
									echo "<table style=\"margin-top: 10px;\"><tr>";
									for ($i=0; $i < $count; $i++) { 
											echo "<td style = \"padding: 0 5px;\"><a href=\"#\"><img id = \"$i\" class = \"pull-left thumbnail img-responsive\" src=\"$directory/$thumbnail[$i]\" onClick = \"getImages($itemDetails->itemID, $itemDetails->userID, $i); return false;\"/></a></td>";
									}
									echo "</tr></table>";
								echo "</div>";
		}//	END FOREACH
	}else {
		redirect_to("itemView.php");
		
	}
?>
		   	</div>
		  </div><!--panel body-->
		  
		</div><!--panel panel-info-->
	</div><!--col col-lg-6-->
	<div class = "col col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Item Details</h3>
			</div>
			<div class="panel-body">
			<div id = "seller_profile" style = "height: 270px;">
						<?php
							//echo"<div class =\"col col-lg-12\">";
							//echo "<div style = \"background: #28858a; padding: 4px 10px\"><span style=\"color: #fff; font-size: 1em;\"><b>$itemTitle</b></span></div>";
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
							echo "<br /><p><b>Tags : </b>$itemDetails->itemTags</p>";
							echo "<br />";
							echo"</div>";//div for table
							
							// echo"</div>";//div ending the column
						?>
			</div>
  		</div><!--panel body-->
  
		</div><!--panel panel-info-->
		<div class="panel panel-info">
			
		  <div class="panel-body">
		   	<div id = "privateMessageContainer" >
		   		<?php $itemCategory = urlencode($itemDetails->itemCategory); $itemID = $itemDetails->itemID; ?>
		   	<form id = "privateMessageForm" class="form-horizontal" role="form" action="<?php echo $_SERVER['PHP_SELF']; echo "?category=$itemCategory&itemID=$itemID";?>" method="post">
			
			<legend>Contact Seller in Private Message</legend>
		
				<?php 
					if(!empty($errors_sendPrivateMessage)){
						echo "<div class =\"alert alert-danger\" style=\"font-size: .85em;\" align=\"center\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$errMessage</div>";
					}else if(isset($successMessage)){
						echo "<div class =\"alert alert-success\" style=\"font-size: .85em;\" align=\"center\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$successMessage</div>";
						$messageSubject ="";
						$privateMessageContent = "";
					}else if(!isset($_SESSION['userID'])){
						$warningMessage = "You need to login to send private message.";
						echo "<div class =\"alert alert-warning\" style=\"font-size: .85em;\" align=\"center\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$warningMessage</div>";
						$messageSubject ="";
						$privateMessageContent = "";
					}
					
				?>
				<?php ?>
				<div class="form-group">
					<label for="messageSubject" class="col col-sm-2 control-label">Subject</label>
						<div class="col col-sm-10">
							<input type="text"  minlength="2" class="form-control input-sm" <?php if(!isset($_SESSION['userID'])){echo" disabled ";}else if(isset($_SESSION['userID']) && ($_SESSION['userID'] == $itemDetails->userID)){echo" disabled ";}?>id="messageSubject" name = "messageSubject" value="<?php if (isset($messageSubject)){echo "$messageSubject";}?>" placeholder="Subject of your Message">
							<?php if(isset($errMessageSubject)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errMessageSubject</div>";}?>
						</div>
				</div>			
				<div class="form-group">
					<label for="privateMessageContent" class="col col-sm-2 control-label">Message</label>
					<div class="col col-sm-10">
					  <textarea type="textarea" col = "10" rows = "10" class="form-control" id="privateMessageContent" name = "privateMessageContent" style="display: none;"><?php 
					  	if (isset($privateMessageContent)){
					  		echo $privateMessageContent;
						}
					  ?></textarea>
					  <div id="frameEdit" style = "width: 100%; height: 30px; background-color: #ccc; padding: 5px; ">
						  <input id ="ibold" type="button" class = "btn btn-xs btn-primary" value="B" />
						  <input id ="iunderline" type="button" class = "btn btn-xs btn-primary" value="U" />
						  <input id = "iitalic" type="button" class = "btn btn-xs btn-primary" value="I" />
						  <input id = "iunorderedlist" type="button" class = "btn btn-xs btn-primary" value="UL" />
						  <input id = "iorederedlist" type="button" class = "btn btn-xs btn-primary" value="OL" />
						  <input id = "iundo" type="button" class = "btn btn-xs btn-primary" value="undo" />
						  <input id = "irefresh" type="button" class = "btn btn-xs btn-primary" value="Clear" />		
					  </div>
					  <div class="clearfix"></div>
					  <div contenteditable="<?php if(!isset($_SESSION['userID'])){echo"false";}else if(isset($_SESSION['userID']) && ($_SESSION['userID'] == $itemDetails->userID)){echo "false";}else{echo "true";}?>" unselectable="off" name = "privateMessageContentFrame" id = "privateMessageContentFrame" style = "border: 1px solid #ccc; width: 100%; padding: 10px; height: 250px; font-family: "Arial, Helvetica, sans-serif"">
					  	<?php if (isset($privateMessageContent)){echo html_entity_decode($privateMessageContent);}?>
					  </div>
					  <?php if(isset($errprivateMessageContent)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errprivateMessageContent</div>";}?>
					</div>
			  </div><!--Item Description-->
			  <div class="form-group"> <!-- hidden fields -->
						<input type = "hidden" name = "privateMessagePostDate" value ="<?php echo time(); ?>"/>
						<input type = "hidden" name = "itemID" value ="<?php echo $itemDetails->itemID; ?>"/>
						<input type = "hidden" name = "toUserID" value ="<?php echo $itemDetails->userID; ?>"/>
						<input type = "hidden" name = "fromUserID" value ="<?php if (isset($_SESSION['userID'])) {
							$fromUserID = $_SESSION['userID'];						
							echo "$fromUserID";
						}else {
							echo "0";
						}
						 ?>"/>
						<?php 
							if (isset($_SESSION['userID'])) {
								$fromUserID = $_SESSION['userID'];
								$fromUserMailObject = User::find_by_id($fromUserID);
								if (!empty($fromUserMailObject)){
									//var_dump($fromUserMailObject);
									$fromUserDetails = get_object_vars($fromUserMailObject);
									//var_dump($fromUserDetails);
								}
							}else{ $fromUserID = "0";}
							
						?>
						<input type = "hidden" name = "fromUserMail" value ="<?php if (!empty($fromUserDetails)){echo $fromUserDetails['userMail']; } echo "";?>"/>
				</div><!-- END hidden fields -->
					<button name = "sendPrivateMessage" type = "submit" class = "btn btn-primary btn-md pull-right <?php if(!isset($_SESSION['userID'])){echo"disabled";}else if(isset($_SESSION['userID']) && ($_SESSION['userID'] == $itemDetails->userID)){echo "disabled";}?>" style = "margin-right:20px;">Send Private Message</button>			  	   	
				</div><!-- privateMessageContainer -->
				
				</form>		
		  </div><!--panel body-->
			  
		</div><!--panel panel-info-->		
	</div>
	
</div><!--row-->
<div class = "row">
	<div class = "col col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="panel panel-info">
			  <div class="panel-heading">
		<h3 class="panel-title" >Comments</h3>
		  </div>
		  <div id="chatContainer" class="panel-body">
		  	
		   	<div id = "comments">Loading Comments for <?php $itemID = $_GET['iid']; echo "itemID: $itemID<br />";?></div>
		  </div><!--panel body-->
		  
		</div><!--panel panel-info-->
		   	<div id = "commented" style = "height: 100px;">
		   		<textarea class = "commentEntry col col-lg-12 col-md-12 col-sm-12 col-xs-12"
		   		<?php if(isset($_SESSION['userID'])){echo "placeholder = \"Type your comment here and press 'Enter' key\">";} else{echo "placeholder = \"You need to login to add comment.\">";}?></textarea>
		   	</div>
		
	</div><!--col col-lg-6-->
	<div class = "col col-lg-3  col-md-3 col-sm-6 col-xs-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Similar Items</h3>
			</div>
			<div class="panel-body similarANDlatest" style = "height: 552px;">
						 <ul class="media-list">
						<?php //BEGIN SIMILAR ITEM QUERY 
						$similarItem = new Item();
						if(isset($_GET['category']) && isset($_GET['iid'])){							
							$similarItem->itemCategory = $_GET['category'];
							$itemID = $_GET['iid'];
							$similarItemObject = Item::find_by_similarItemCategory($similarItem->itemCategory, $itemID);
							if (!empty($similarItemObject)) {
								//var_dump($simlarItemObject);
								foreach ($similarItemObject as $object => $similarItemDetails) {
									echo"<li class=\"media\">";									
									$t = hash("sha512", time());
									$uid = hash('sha512', $similarItemDetails->itemID);
									$q = hash('sha512', $similarItemDetails->userID);
									$_SESSION['itemTitle'] = $similarItemDetails->itemTitle;
									$itemTitle = removeslashes($similarItemDetails->itemTitle);
									//echo"<div class = \"row\">";
										echo"<div class=\"col col-lg-6 col-md-6 col-sm-6 col-xs-6\">";//BEGIN PLACEHOLDER FOR ITEM IMAGE
											//BEGIN FOR ITEM IMAGE USE
												$hashedUserID = hash('sha256', $similarItemDetails->userID);
												$hashedItemID = hash('sha256', $similarItemDetails->itemID);				
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
													echo"<a class=\"thumbnail\" href=\"itemDetailed.php?category=".urlencode($similarItem->itemCategory)."&itemID=".$similarItemDetails->itemID."\"><img src=\"$directory/$thumbnail[0]\"/></a>";
												}else {
													echo"<a class=\"thumbnail\" href=\"#\"><img src=\"images/webgate_logo_gray.png\"/></a>";
												}
											 //END FOR ITEM IMAGE USE
											  echo"</div>";// END PLACEHOLDER FOR ITEM IMAGE	
											 echo "<div class=\"col col-lg-6 col-md-6 col-sm-6 col-xs-6\">";
												echo "<span style =\"color: #0086aa;\"><h4 class=\"media-heading\">".$itemTitle."</h4></span>";
												echo "<span style =\"color: #363636; font-size: .8em;\"><p><b>Php</b> ".$similarItemDetails->itemPrice."</p></span>";
												echo "<span style = \"color: #999; font-size: .8em;\"><p>".$similarItemDetails->itemCategory."</p></span>";	
												date_default_timezone_set('Asia/Manila');						
												$timestamp1 = date("j F Y | g:i A", $similarItemDetails->itemPostDate);
												echo "<span style = \"color: #999; font-size: .7em; margin-top: 0;\"><p>".$timestamp1."</p></span>";				
											echo "</div>";
												
										echo "</li>";
											
								}//END FOREACH
							}else{echo "<span style = \"color: #999; font-size: .9em;\"><p>&nbsp;&nbsp;&nbsp;No Similar Items exist in the Database</p></span>";}
								
						}								
					
					//END SIMILAR ITEM QUERY ?>
					 </ul><!-- class media-list -->
	
			</div><!--panel body-->		  
		</div><!--panel panel-info-->
	</div>
	<div class = "col col-lg-3 col-md-3 col-sm-6 col-xs-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Latest Items</h3>
			</div>
			<div class="panel-body similarANDlatest" style = "height: 552px;">
				
					 <ul class="media-list">
						<?php //BEGIN LATEST ITEM QUERY
						$latestItem = new Item();
						if(isset($_GET['category']) && isset($_GET['iid'])){							
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
										echo"<div class=\"col col-lg-6 col col-md-6 col-sm-6 col-xs-6\">";//BEGIN PLACEHOLDER FOR ITEM IMAGE
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
											 echo "<div class=\"col col-md-6 col-sm-6 col-xs-6\">";
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
	</div>
	
</div><!--row-->

<div class="clearfix"></div>
<div class="row well well-sm" style="color:#fef6cd;">
<section class="col col-lg-3  col-md-3 col-sm-6 col-xs-6" >
   <h4>Emergency Numbers</h4>
   <ul>
        	<li><a href="#">Medical: 911</a></li>
            <li><a href="#">Rescue: 911</a></li>
            <li><a href="#">Fire: (082) 227-5433</a></li>
            <li><a href="#">Police: (082) 224-13134</a></li>
   </ul>

</section>
<section class="col col-lg-3 col-md-3 col-sm-6 col-xs-6">
<h4>Legal Information</h4>
<ul>
        	<li><a href="#">About Us</a></li>
            <li><a href="privacy.php">Privacy Policy</a></li>
            <li><a href="terms.php">Terms &amp; Conditions</a></li>
            <li><a href="#">Donate</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>        

</section>
<section class="col col-lg-3 col-md-3 col-sm-6 col-xs-6">
<h4>Socialize</h4>
<ul>
        	<li><a href="#">Forums</a></li>
            <li><a href="#">Community</a></li>
            <li><a href="#">Bulletin Board</a></li>
            <li><a href="#">Classified Ads</a></li>
            <li><a href="#">FAQ</a></li>
        </ul>
</section>
<section class="col col-lg-3 col-md-3 col-sm-6 col-xs-6">
<h4>Share us:</h4>
        <div class="footerShare">
           <p>Facebook | Twitter | Linked In</p>
           
     <div class="footerCopyright">
         <p>Copyright &copy; 2013. Davao Webgate</p>
         <p>All Rights Reserved.</p>
      </div>
	  <!--<a href="http://www.proudlypinoy.org/" target="_top"><img src="http://www.proudlypinoy.org/proudlypinoysmallontrans.png" width="75" height="75" border="0" alt="Proudly Pinoy!"></a>-->

</section>
</div><!--footer-->
  </div><!--content-->
</section><!--container-->
      <script type="text/javascript" src="_/js/jquery-1.11.1.min.js"></script>
      <script type="text/javascript" src="_/js/jquery-ui-1.10.4.min.js"></script>     
      <script type="text/javascript" src="_/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="_/js/myscript.js"></script>     
      <?php echo "<script type=\"text/javascript\">"; ?>
			<?php echo "$(document).ready(function(){"; ?>
			<?php $itemID = $_GET['iid']; echo "var itemID = ".$itemID.';';?>
			
			function readComments(itemID){		
					$.post('processComment.php', {itemID: itemID, method: 'readComments'}, function(data){
					$("#comments").html(data);
			
				});
			}//END FUNCTION readComments
			
			function insertComment(itemID, comment){		
				if($.trim(comment).length != 0){
					$.post('processComment.php', {itemID: itemID, comment: comment, method: 'insertComment'}, function(){
						readComments(itemID);		
						$(".commentEntry").val('');
					});
					
				}	
					
			}//END FUNCTION insertComments
			
			$(".commentEntry").bind('keydown', function(e){
					if(e.keyCode === 13 && e.shiftKey === false){
						insertComment(itemID, $(this).val());
						e.preventDefault();
					}
				});
				
			function repeatCall(){
				readComments(itemID);
			}
			readComments(itemID);
			setInterval(repeatCall, 5000);
			<?php echo "});"; ?>
		<?php echo '</script>'; ?>

  </body>
</html>
<?php ob_end_flush();?>