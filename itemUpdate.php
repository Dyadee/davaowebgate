<?php ob_start(); ?>
<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require_once("_/components/includes/functions.php"); ?>
<?php require_once("_/components/includes/class/business.php"); ?>
<?php require_once("_/components/includes/class/item.php"); ?>
<?php require_once("_/components/includes/class/privateMessage.php"); ?>
<?php include("_/components/includes/header.php");?>
<?php $session->confirm_logged_in(); ?>
<?php 
	$item = new Item();
	$item->userID = $_SESSION['userID'];
	if (isset($_GET['iid'])){
	$_SESSION['itemID'] = $_GET['iid'];
	$item->itemID = $_SESSION['itemID'];
	$itemDetails = Item::authenticate($item->itemID, $item->userID);
		if(!$itemDetails){
			redirect_to("itemView.php");
		}
	}
				$t = hash("sha512", time());
				$iid = $_SESSION['itemID'];
				$uid = hash('sha512', $_SESSION['itemID']);
				$q = hash('sha512', $_SESSION['userID']);
				//var_dump($itemDetails);
				
?>
<?php require_once("_/components/includes/itemValidation.php"); ?>
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
		<li><a href="#">View My Job Posts</a></li>
		<li><a href="itemView.php">View My Items</a></li>
		<li><a href="businessRegistration.php">Add a Business List</a></li>
		<li><a href="#">Post a Job</a></li>
		<li class = "active"><a href="marketplacePost.php">Sell an Item</a></li>
		<li><a href="userUpdate.php">Edit Account</a></li>
		<li><a href="loginUpdate.php">Change Login Information</a></li>
		<li><a href="logout.php">Logout</a></li>
	</ul>
</aside>
<section class="col col-lg-8 col-md-8 col-sm-8 col-xs-12">
<form class="form-horizontal" role="form" action="<?php echo $_SERVER['PHP_SELF']; echo "?t=$t&uid=$uid&iid=$iid&q=$q";?>" enctype="multipart/form-data" method="post">
		<legend>Update your Item in the Marketplace</legend>
		<?php if(isset($errMessage)){
				unset($_SESSION['successitemUpdate']);
				echo "<div class =\"alert alert-danger\" style=\"font-size: .85em;\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$errMessage</div>";
			
			}
			if(isset($_SESSION['successitemUpdate'])){
				$successMessage = $_SESSION['successitemUpdate'];
				echo "<div class =\"alert alert-success\" style=\"font-size: .85em;\"><span class = \"glyphicon glyphicon-check\"></span>&nbsp;&nbsp;&nbsp;$successMessage</div>";
				unset($_SESSION['successitemUpdate']);
			}
	?>
		  <div class="panel panel-info">
	  <!-- Default panel contents -->
	  <div class="panel-heading">Item Information</div>
		  <div class="panel-body">
		  <div class="form-group">
			<label for="itemTitle" class="col-sm-3 control-label">Item Title</label>
			<div class="col-sm-8">
			<?php $itemTitle = removeslashes($itemDetails->itemTitle);?>
			  <input type="text" class="form-control" id="itemTitle" name = "itemTitle" value="<?php {echo "$itemTitle";}?>" placeholder="Item name here">
			  <?php if(isset($erritemTitle)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$erritemTitle</div>";}?>
			</div>
		  </div><!-- Item Title -->

		 <div class="form-group">
			<label for="itemCategory" class="col-sm-3 control-label">Item Category</label>
			<div class="col-sm-8">
			  <select class="form-control" id="itemCategory" name = "itemCategory">
				<option value = "">-- Select Item Category --</option>			
						  <option value = "Airsoft" <?php if($itemDetails->itemCategory === 'Airsoft'){echo "selected=\"selected\"";}?> >Airsoft</option>
						  <option value="Appliance" <?php if($itemDetails->itemCategory === 'Appliance'){echo "selected=\"selected\"";}?> >Appliance</option>
						  <option value="Arts & Crafts" <?php if($itemDetails->itemCategory === 'Arts & Crafts'){echo "selected=\"selected\"";}?> >Arts &amp; Crafts</option>
						  <option value="Auto Parts" <?php if($itemDetails->itemCategory === 'Auto Parts'){echo "selected=\"selected\"";}?> >Auto Parts</option>
						  <option value="Books" <?php if($itemDetails->itemCategory === 'Books'){echo "selected=\"selected\"";}?> >Books</option>
						  <option value="Cars & Vehicles" <?php if($itemDetails->itemCategory === 'Cars & Vehicles'){echo "selected=\"selected\"";}?> >Cars &amp; Vehicles</option>
						  <option value="Cellphones" <?php if($itemDetails->itemCategory === 'Cellphones'){echo "selected=\"selected\"";}?> >Cellphones</option>
						  <option value="Clothing & Fashion" <?php if($itemDetails->itemCategory === 'Clothing & Fashion'){echo "selected=\"selected\"";}?> >Clothing &amp; Fashion</option>
						  <option value="Computer Parts" <?php if($itemDetails->itemCategory === 'Computer Parts'){echo "selected=\"selected\"";}?> >Computer Parts</option>
						  <option value="Computers" <?php if($itemDetails->itemCategory === 'Computers'){echo "selected=\"selected\"";}?> >Computers</option>
						  <option value="Cosmetics/Beauty" <?php if($itemDetails->itemCategory === 'Cosmetics/Beauty'){echo "selected=\"selected\"";}?> >Cosmetics/Beauty</option>
						  <option value="Electrical" <?php if($itemDetails->itemCategory === 'Electrical'){echo "selected=\"selected\"";}?> >Electrical</option>
						  <option value="Electronics" <?php if($itemDetails->itemCategory === 'Electronics'){echo "selected=\"selected\"";}?> >Electronics</option>
						  <option value="Embroidery" <?php if($itemDetails->itemCategory === 'Embroidery'){echo "selected=\"selected\"";}?> >Embroidery</option>
						  <option value="Farming Supplies" <?php if($itemDetails->itemCategory === 'Farming Supplies'){echo "selected=\"selected\"";}?> >Farming Supplies</option>
						  <option value="Fire Extinguisher" <?php if($itemDetails->itemCategory === 'Fire Extinguisher'){echo "selected=\"selected\"";}?> >Fire Extinguisher</option>
						  <option value="Fitness & Health" <?php if($itemDetails->itemCategory === 'Fitness & Health'){echo "selected=\"selected\"";}?> >Fitness &amp; Health</option>
						  <option value="Foods & Beverage" <?php if($itemDetails->itemCategory === 'Foods & Beverage'){echo "selected=\"selected\"";}?> >Foods &amp; Beverage</option>
						  <option value="Furnitures" <?php if($itemDetails->itemCategory === 'Furnitures'){echo "selected=\"selected\"";}?> >Furnitures</option>
						  <option value="Gadgets" <?php if($itemDetails->itemCategory === 'Gadgets'){echo "selected=\"selected\"";}?> >Gadgets</option>
						  <option value="Game Consoles" <?php if($itemDetails->itemCategory === 'Game Consoles'){echo "selected=\"selected\"";}?> >Game Consoles</option>
						  <option value="Glass & Aluminum" <?php if($itemDetails->itemCategory === 'Glass & Aluminum'){echo "selected=\"selected\"";}?> >Glass &amp; Aluminum</option>
						  <option value="Hardware" <?php if($itemDetails->itemCategory === 'Hardware'){echo "selected=\"selected\"";}?> >Hardware</option>
						  <option value="Health Products" <?php if($itemDetails->itemCategory === 'Health Products'){echo "selected=\"selected\"";}?> >Health Products</option>
						  <option value="Home Interiors" <?php if($itemDetails->itemCategory === 'Home Interiors'){echo "selected=\"selected\"";}?> >Home Interiors</option>
						  <option value="House & Lot" <?php if($itemDetails->itemCategory === 'House & Lot'){echo "selected=\"selected\"";}?> >House &amp; Lot</option>
						  <option value="Imported Products" <?php if($itemDetails->itemCategory === 'Imported Products'){echo "selected=\"selected\"";}?> >Imported Products</option>
						  <option value="Jewelry" <?php if($itemDetails->itemCategory === 'Jewelry'){echo "selected=\"selected\"";}?> >Jewelry</option>
						  <option value="Kids Toys" <?php if($itemDetails->itemCategory === "Kids Toys"){echo "selected=\"selected\"";}?> >Kids Toys</option>
						  <option value="Laptops/Netbooks" <?php if($itemDetails->itemCategory === 'Laptops/Netbooks'){echo "selected=\"selected\"";}?> >Laptops/Netbooks</option>
						  <option value="Lighting & Fixtures" <?php if($itemDetails->itemCategory === 'Lighting & Fixtures'){echo "selected=\"selected\"";}?> >Lighting &amp; Fixtures</option>
						  <option value="Medical Supplies" <?php if($itemDetails->itemCategory === 'Medical Supplies'){echo "selected=\"selected\"";}?> >Medical Supplies</option>
						  <option value="Motorcycle & Parts" <?php if($itemDetails->itemCategory === 'Motorcycle & Parts'){echo "selected=\"selected\"";}?> >Motorcycle &amp; Parts</option>
						  <option value="Musical" <?php if($itemDetails->itemCategory === 'Musical'){echo "selected=\"selected\"";}?> >Musical</option>					  
						  <option value="Outdoor Gear" <?php if($itemDetails->itemCategory === 'Outdoor Gear'){echo "selected=\"selected\"";}?> >Outdoor Gear</option>
						  <option value="Paintings" <?php if($itemDetails->itemCategory === 'Paintings'){echo "selected=\"selected\"";}?> >Paintings</option>
						  <option value="Paints" <?php if($itemDetails->itemCategory === 'Paints'){echo "selected=\"selected\"";}?> >Paints</option>
						  <option value="Perfumes" <?php if($itemDetails->itemCategory === 'Perfumes'){echo "selected=\"selected\"";}?> >Perfumes</option>
						  <option value="Pet Accessories" <?php if($itemDetails->itemCategory === 'Pet Accessories'){echo "selected=\"selected\"";}?> >Pet Accessories</option>
						  <option value="Pet Care" <?php if($itemDetails->itemCategory === 'Pet Care'){echo "selected=\"selected\"";}?> >Pet Care</option>
						  <option value="Real Estate" <?php if($itemDetails->itemCategory === 'Real Estate'){echo "selected=\"selected\"";}?> >Real Estate</option>
						  <option value="RTW" <?php if($itemDetails->itemCategory === 'RTW'){echo "selected=\"selected\"";}?> >RTW</option>
						  <option value="School Supplies" <?php if($itemDetails->itemCategory === 'School Supplies'){echo "selected=\"selected\"";}?> >School Supplies</option>
						  <option value="Sports Gear" <?php if($itemDetails->itemCategory === 'Sports Gear'){echo "selected=\"selected\"";}?> >Sports Gear</option>
						  <option value="Vet Products" <?php if($itemDetails->itemCategory === 'Vet Products'){echo "selected=\"selected\"";}?> >Vet Products</option>
						  <option value="Watch" <?php if($itemDetails->itemCategory === 'Watch'){echo "selected=\"selected\"";}?> >Watch</option>
						  <option value="Wines & Spirits" <?php if($itemDetails->itemCategory === 'Wines & Spirits'){echo "selected=\"selected\"";}?> >Wines &amp; Spirits</option>
						  <option value="Others" <?php if($itemDetails->itemCategory === 'Others'){echo "selected=\"selected\"";}?> >Others</option>						  
				</select>
				<?php if(isset($erritemCategory)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$erritemCategory</div>";}?>
			</div>
		 </div><!--Item Category-->
		 
		  <div class="form-group">
			<label for="itemPrice" class="col-sm-3 control-label">Item Price</label>
			<div class="col-sm-8">
				<div class = "input-group">
			<span class = "input-group-addon">Php</span>
			  <input type="text" class="form-control" id="itemPrice" name = "itemPrice" value="<?php echo "$itemDetails->itemPrice";?>" placeholder="What it cost">
			  </div>
			  <?php if(isset($erritemPrice)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$erritemPrice</div>";}?>
			</div>
		  </div><!--Item Price-->
		  
		  <div class="form-group">
			<label for="itemContactInfo" class="col-sm-3 control-label">Contact Info</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" id="itemContactInfo" name = "itemContactInfo"  value="<?php echo "$itemDetails->itemContactInfo";?>" placeholder="How buyers can contact you">
			  <?php if(isset($erritemContactInfo)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$erritemContactInfo</div>";}?>
			</div>
		  </div><!-- Item Contact Info-->
		  <div class="form-group">
			<label for="itemDescription" class="col-sm-3 control-label">Item Description</label>
			<div class="col-sm-8">
			<?php $itemDescription = $itemDetails->itemDescription;?>
			  <textarea type="textarea" col = "10" rows = "10"class="form-control" id="itemDescription" name = "itemDescription" style = "display: none;"><?php echo "$itemDescription";?></textarea>
			   <div id="frameEdit" style = "width: 100%; height: 30px; background-color: #ccc; padding: 5px; ">
			  <input id ="bold" type="button" class = "btn btn-xs btn-primary" value="B" />
			  <input id ="underline" type="button" class = "btn btn-xs btn-primary" value="U" />
			  <input id = "italic" type="button" class = "btn btn-xs btn-primary" value="I" />
			  <input id = "unorderedlist" type="button" class = "btn btn-xs btn-primary" value="UL" />
			  <input id = "orederedlist" type="button" class = "btn btn-xs btn-primary" value="OL" />
			  <input id = "undo" type="button" class = "btn btn-xs btn-primary" value="undo" />
			   <input id = "refresh" type="button" class = "btn btn-xs btn-primary" value="Clear" />		
			  </div>
			  <div class="clearfix"></div>
			  <div contenteditable="true" unselectable="off" name = "itemFrameDescription" id = "itemFrameDescription" style = "border: 1px solid #ccc; width: 100%; padding: 10px; height: 250px; font-family: "Arial, Helvetica, sans-serif"">
			  	<?php if (isset($itemDescription)){echo html_entity_decode($itemDescription);}?>
			  </div>
			  <?php if(isset($erritemDescription)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$erritemDescription</div>";}?>
			</div>
		  </div><!--Item Requirements-->
		 &nbsp;
		  <div class="form-group">
			<label for="itemTags" class="col-sm-3 control-label">Item Tags <span class = "glyphicon glyphicon-question-sign"></span></label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" id="itemTags" name = "itemTags"  value="<?php echo "$itemDetails->itemTags";?>" placeholder= "Keywords related to your post"></input>
			  <?php if(isset($erritemTags)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$erritemTags</div>";}?>
			</div>
		  </div><!--Item Tags-->
		  </div><!--Panel Body-->
	</div><!-- Panel Item Information -->

	 <div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
		  <div class="checkbox">
			<label for = "itemAgree">
				<input type = "hidden" name = "itemUpDate" value ="<?php echo time(); ?>"/>
				<input type="checkbox" id = "itemAgree" name = "itemAgree" > I have read the <a href="terms.php">Terms and Conditions</a>
				<?php if(isset($erritemAgree)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$erritemAgree</div>";}?>
			</label>
		  </div><!--Checkbox-->
		</div>
	  </div>
	  <div class="form-group">
		<div align = "center">
		  <button type="submit" class="btn btn-danger" name= "itemUpdate"><span class = "glyphicon glyphicon-ok"></span> Update this Item</button>&nbsp;&nbsp;&nbsp;
		  <a href="itemView.php" class="btn btn-info"><span class = "glyphicon glyphicon-ban-circle"></span> Cancel</a>
		</div>
	  </div>

</form>
</section>
<?php include("_/components/includes/footer.php");?>
<?php ob_end_flush();?>