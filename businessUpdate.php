<?php ob_start(); ?>
<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require_once("_/components/includes/functions.php"); ?>
<?php require_once("_/components/includes/class/business.php"); ?>
<?php require_once("_/components/includes/class/item.php"); ?>
<?php require_once("_/components/includes/class/privateMessage.php"); ?>
<?php include("_/components/includes/header.php");?>
<?php $session->confirm_logged_in(); ?>
<?php 
	$business = new Business();
	$business->userID = $_SESSION['userID'];
	if (isset($_GET['bid'])){
	$_SESSION['businessID'] = $_GET['bid'];
	$business->businessID = $_SESSION['businessID'];
	$businessDetails = Business::authenticate($business->businessID, $business->userID);
		if(!$businessDetails){
			redirect_to("businessView.php");
		}
	}
				$t = hash("sha512", time());
				$bid = $_SESSION['businessID'];
				$uid = hash('sha512', $_SESSION['businessID']);
				$q = hash('sha512', $_SESSION['userID']);
				//var_dump($businessDetails);
				
?>
<?php require_once("_/components/includes/businessValidation.php"); ?>
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
		<li class = "active"><a href="businessRegistration.php">Add a Business List</a></li>
		<li><a href="#">Post a Job</a></li>
		<li><a href="marketplacePost.php">Sell an Item</a></li>
		<li><a href="userUpdate.php">Edit Account</a></li>
		<li><a href="loginUpdate.php">Change Login Information</a></li>
		<li><a href="logout.php">Logout</a></li>
	</ul>
</aside>
<section class="col col-lg-8 col-md-8 col-sm-8 col-xs-12">
<form class="form-horizontal" role="form" action="<?php echo $_SERVER['PHP_SELF']; echo "?t=$t&uid=$uid&bid=$bid&q=$q"; ?>" enctype="multipart/form-data" method="post">
	<legend>Update Business Information</legend>
	<?php if(isset($errMessage)){
				unset($_SESSION['successbusinessUpdate']);
				echo "<div class =\"alert alert-danger\" style=\"font-size: .85em;\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$errMessage</div>";
			
			}
			if(isset($_SESSION['successbusinessUpdate'])){
				$successMessage = $_SESSION['successbusinessUpdate'];
				echo "<div class =\"alert alert-success\" style=\"font-size: .85em;\"><span class = \"glyphicon glyphicon-check\"></span>&nbsp;&nbsp;&nbsp;$successMessage</div>";
				unset($_SESSION['successbusinessUpdate']);
			}
	?>
	  <div class="panel panel-info">
  <!-- Default panel contents -->
  <div class="panel-heading">Business Information</div>
  <div class="panel-body">
  <div class="form-group">
    <label for="businessName" class="col-sm-3 control-label">Business Name</label>
    <div class="col-sm-8">
	<?php $businessName = removeslashes($businessDetails->businessName); ?>
      <input type="text" required class="form-control" id="businessName" name="businessName" placeholder="Business Name" value="<?php echo $businessName;?>">
	  <?php if(isset($errbusinessName)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessName</div>";}?>
    </div>
  </div><!--Business Name-->
	<div class="form-group">
		<label for="businessCategory" class="col-sm-3 control-label">Category</label>
		<div class="col-sm-8">
			<label for = "products" class="radio-inline">
				<input type="radio" id="products" name="businessCategory" value="Products" <?php if($businessDetails->businessCategory === 'Products'){echo "checked";}?>/> Products
			</label>
			<label for = "services" class="radio-inline">
				<input type="radio" id="services" name="businessCategory" value="Services" <?php if($businessDetails->businessCategory === 'Services'){echo "checked";}?>/> Services
			</label>
			<?php if(isset($errbusinessCategory)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessCategory</div>";}?>
		</div>
	</div><!--Business Category-->
 <div class="form-group">
    <label for="productORservice" class="col-sm-3 control-label">Business Type</label>
	<div class="col-sm-8" id="productORservice">
	<select class="form-control" >
		<option value="">-- Please select a category --</option>		
	</select>
	</div><!--option when neither of the radio buttons Products or Services is clicked-->
    <div class="col-sm-8" id="businessTypeProducts">
      <select class="form-control" name="businessTypeProducts" >
			<option value="">-- Type of Product --</option>	
			<?php
			$businessCategories = Business::select_categories('Products');
				foreach ($businessCategories as $fields=>$values){
					foreach($values as $field_key=>$value){
						if($field_key === 'businessType'){
							echo "<option value=\"$value\"";
							if($value === $businessDetails->businessType){echo "selected=\"selected\"";}
							echo ">$value</option>";
						}						
					}
				}
			?>
		
		</select>
		<?php if(isset($errbusinessTypeProducts)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessTypeProducts</div>";}?>
	</div>
	<div class="col-sm-8" id="businessTypeServices">
      <select class="form-control"  name="businessTypeServices">
				<option value="">-- Type of Service --</option>	
				<?php
				$businessCategories = Business::select_categories('Services');
				foreach ($businessCategories as $fields=>$values){
					foreach($values as $field_key=>$value){
						if($field_key === 'businessType'){
							echo "<option value=\"$value\"";
							if($value === $businessDetails->businessType){echo "selected=\"selected\"";}
							echo ">$value</option>";
						}						
					}
				}
		?>				
		</select>
		<?php if(isset($errbusinessTypeServices)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessTypeServices</div>";}?>
	</div>
 </div><!--Business Type-->
  <div class="form-group">
    <label for="businessAddress" class="col-sm-3 control-label">Business Address</label>
    <div class="col-sm-8">
      <input type="text" required class="form-control" id="businessAddress" name = "businessAddress" placeholder="Business Address" value="<?php echo $businessDetails->businessAddress;?>">
	  <?php if(isset($errbusinessAddress)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessAddress</div>";}?>
    </div>
  </div><!--Business Address-->
   <div class="form-group">
    <label for="productORservice" class="col-sm-3 control-label">Business Location</label>
  <div class="col-sm-8" id="businessLocation">
      <select class="form-control"  name="businessLocation">
			<optgroup label="DAVAO CITY">
				<option value="Davao City" <?php if($businessDetails->businessLocation === 'Davao City'){echo "selected=\"selected\"";}?> >Davao City</option>
			</optgroup>
			<optgroup label="COMPOSTELA VALLEY">
				<option  value="Compostela, Compostela Valley" <?php if($businessDetails->businessLocation === 'Compostela, Compostela Valley'){echo "selected=\"selected\"";}?> >Compostela, Compostela Valley</option>
				<option  value="Laak, Compostela Valley" <?php if($businessDetails->businessLocation === 'Laak, Compostela Valley'){echo "selected=\"selected\"";}?> >Laak, Compostela Valley</option>
				<option  value="Mabini, Compostela Valley" <?php if($businessDetails->businessLocation === 'Mabini, Compostela Valley'){echo "selected=\"selected\"";}?> >Mabini, Compostela Valley</option>
				<option value="Maco, Compostela Valley" <?php if($businessDetails->businessLocation === 'Maco, Compostela Valley'){echo "selected=\"selected\"";}?> >Maco, Compostela Valley</option>
				<option  value="Maragusan, Compostela Valley" <?php if($businessDetails->businessLocation === 'Maragusan, Compostela Valley'){echo "selected=\"selected\"";}?> >Maragusan, Compostela Valley</option>
				<option  value="Mawab, Compostela Valley" <?php if($businessDetails->businessLocation === 'Mawab, Compostela Valley'){echo "selected=\"selected\"";}?> >Mawab, Compostela Valley</option>
				<option  value="Monkayo, Compostela Valley" <?php if($businessDetails->businessLocation === 'Monkayo, Compostela Valley'){echo "selected=\"selected\"";}?> >Monkayo, Compostela Valley</option>
				<option  value="Montevista, Compostela Valley" <?php if($businessDetails->businessLocation === 'Montevista, Compostela Valley'){echo "selected=\"selected\"";}?> >Montevista, Compostela Valley</option>
				<option  value="Montevista, Compostela Valley" <?php if($businessDetails->businessLocation === 'Montevista, Compostela Valley'){echo "selected=\"selected\"";}?> >Nabunturan, Compostela Valley</option>
				<option  value="New Bataan, Compostela Valley" <?php if($businessDetails->businessLocation === 'New Bataan, Compostela Valley'){echo "selected=\"selected\"";}?> >New Bataan, Compostela Valley</option>
				<option  value="Pantukan, Compostela Valley" <?php if($businessDetails->businessLocation === 'Pantukan, Compostela Valley'){echo "selected=\"selected\"";}?> >Pantukan, Compostela Valley</option>
			</optgroup>
			<optgroup label="DAVAO DEL NORTE">
				<option  value="Asuncion, Davao del Norte" <?php if($businessDetails->businessLocation === "Asuncion, Davao del Norte"){echo "selected=\"selected\"";}?> >Asuncion, Davao del Norte</option>
				<option  value="Braulio E. Dujali, Davao del Norte" <?php if($businessDetails->businessLocation === "Braulio E. Dujali, Davao del Norte"){echo "selected=\"selected\"";}?> >Braulio E. Dujali, Davao del Norte</option>
				<option  value="Carmen, Davao del Norte" <?php if($businessDetails->businessLocation === "Carmen, Davao del Norte"){echo "selected=\"selected\"";}?> >Carmen, Davao del Norte</option>
				<option  value="Panabo City" <?php if($businessDetails->businessLocation === "Panabo City"){echo "selected=\"selected\"";}?> >Panabo City</option>
				<option  value="Tagum City" <?php if($businessDetails->businessLocation === "Tagum City"){echo "selected=\"selected\"";}?> >Tagum City</option>
				<option  value="Island Garden City of Samal" <?php if($businessDetails->businessLocation === "Island Garden City of Samal"){echo "selected=\"selected\"";}?> >Island Garden City of Samal</option>
				<option  value="Kapalong, Davao del Norte" <?php if($businessDetails->businessLocation === "Kapalong, Davao del Norte"){echo "selected=\"selected\"";}?> >Kapalong, Davao del Norte</option>
				<option value="New Corella, Davao del Norte" <?php if($businessDetails->businessLocation === "New Corella, Davao del Norte"){echo "selected=\"selected\"";}?> >New Corella, Davao del Norte</option>
				<option  value="San Isidro, Davao del Norte" <?php if($businessDetails->businessLocation === "San Isidro, Davao del Norte"){echo "selected=\"selected\"";}?> >San Isidro, Davao del Norte</option>
				<option  value="Santo Tomas, Davao del Norte" <?php if($businessDetails->businessLocation === "Santo Tomas, Davao del Norte"){echo "selected=\"selected\"";}?> >Santo Tomas, Davao del Norte</option>
				<option  value="Talaingod, Davao del Norte" <?php if($businessDetails->businessLocation === "Talaingod, Davao del Norte"){echo "selected=\"selected\"";}?> >Talaingod, Davao del Norte</option>
			</optgroup>
			<optgroup label="DAVAO DEL SUR">
				<option value="Bansalan, Davao del Sur" <?php if($businessDetails->businessLocation === "Bansalan, Davao del Sur"){echo "selected=\"selected\"";}?> >Bansalan, Davao del Sur</option>
				<option  value="Digos City" <?php if($businessDetails->businessLocation === "Digos City"){echo "selected=\"selected\"";}?> >Digos City</option>				
				<option  value="Don Marcelino, Davao del Sur" <?php if($businessDetails->businessLocation === "Don Marcelino, Davao del Sur"){echo "selected=\"selected\"";}?> >Don Marcelino, Davao del Sur</option>
				<option  value="Hagonoy, Davao del Sur" <?php if($businessDetails->businessLocation === "Hagonoy, Davao del Sur"){echo "selected=\"selected\"";}?> >Hagonoy, Davao del Sur</option>
				<option  value="Jose Abad Santos, Davao del Sur" <?php if($businessDetails->businessLocation === "Jose Abad Santos, Davao del Sur"){echo "selected=\"selected\"";}?> >Jose Abad Santos, Davao del Sur</option>
				<option  value="Kiblawan, Davao del Sur" <?php if($businessDetails->businessLocation === "Kiblawan, Davao del Sur"){echo "selected=\"selected\"";}?> >Kiblawan, Davao del Sur</option>
				<option  value="Magsaysay, Davao del Sur" <?php if($businessDetails->businessLocation === "Magsaysay, Davao del Sur"){echo "selected=\"selected\"";}?> >Magsaysay, Davao del Sur</option>
				<option  value="Malalag, Davao del Sur" <?php if($businessDetails->businessLocation === "Malalag, Davao del Sur"){echo "selected=\"selected\"";}?> >Malalag, Davao del Sur</option>
				<option  value="Malita, Davao del Sur" <?php if($businessDetails->businessLocation === "Malita, Davao del Sur"){echo "selected=\"selected\"";}?> >Malita, Davao del Sur</option>
				<option  value="Matanao, Davao del Sur" <?php if($businessDetails->businessLocation === "Matanao, Davao del Sur"){echo "selected=\"selected\"";}?> >Matanao, Davao del Sur</option>
				<option  value="Padada, Davao del Sur" <?php if($businessDetails->businessLocation === "Padada, Davao del Sur"){echo "selected=\"selected\"";}?> >Padada, Davao del Sur</option>
				<option  value="Santa Cruz, Davao del Sur" <?php if($businessDetails->businessLocation === "Santa Cruz, Davao del Sur"){echo "selected=\"selected\"";}?> >Santa Cruz, Davao del Sur</option>
				<option  value="Santa Maria, Davao del Sur" <?php if($businessDetails->businessLocation === "Santa Maria, Davao del Sur"){echo "selected=\"selected\"";}?> >Santa Maria, Davao del Sur</option>
				<option  value="Sarangani, Davao del Sur" <?php if($businessDetails->businessLocation === "Sarangani, Davao del Sur"){echo "selected=\"selected\"";}?> >Sarangani, Davao del Sur</option>
				<option  value="Sulop, Davao del Sur" <?php if($businessDetails->businessLocation === "Sulop, Davao del Sur"){echo "selected=\"selected\"";}?> >Sulop, Davao del Sur</option>
			</optgroup>
			<optgroup label="DAVAO ORIENTAL">
				<option value="Baganga, Davao Oriental" <?php if($businessDetails->businessLocation === "Baganga, Davao Oriental"){echo "selected=\"selected\"";}?> >Baganga, Davao Oriental</option>
				<option  value="Banaybanay, Davao Oriental" <?php if($businessDetails->businessLocation === "Banaybanay, Davao Oriental"){echo "selected=\"selected\"";}?> >Banaybanay, Davao Oriental</option>
				<option value="Boston, Davao Oriental" <?php if($businessDetails->businessLocation === "Boston, Davao Oriental"){echo "selected=\"selected\"";}?> >Boston, Davao Oriental</option>
				<option value="Caraga, Davao Oriental" <?php if($businessDetails->businessLocation === "Caraga, Davao Oriental"){echo "selected=\"selected\"";}?> >Caraga, Davao Oriental</option>
				<option value="Cateel, Davao Oriental" <?php if($businessDetails->businessLocation === "Cateel, Davao Oriental"){echo "selected=\"selected\"";}?> >Cateel, Davao Oriental</option>
				<option value="Mati City" <?php if($businessDetails->businessLocation === "Mati City"){echo "selected=\"selected\"";}?> >Mati City</option>
				<option value="Governor Generoso, Davao Oriental" <?php if($businessDetails->businessLocation === "Governor Generoso, Davao Oriental"){echo "selected=\"selected\"";}?> >Governor Generoso, Davao Oriental</option>
				<option value="Lupon, Davao Oriental" <?php if($businessDetails->businessLocation === "Lupon, Davao Oriental"){echo "selected=\"selected\"";}?> >Lupon, Davao Oriental</option>
				<option  value="Manay, Davao Oriental" <?php if($businessDetails->businessLocation === "Manay, Davao Oriental"){echo "selected=\"selected\"";}?> >Manay, Davao Oriental</option>
				<option value="San Isidro, Davao Oriental" <?php if($businessDetails->businessLocation === "San Isidro, Davao Oriental"){echo "selected=\"selected\"";}?> >San Isidro, Davao Oriental</option>
				<option value="Tarragona, Davao Oriental" <?php if($businessDetails->businessLocation === "Tarragona, Davao Oriental"){echo "selected=\"selected\"";}?> >Tarragona, Davao Oriental</option>
			</optgroup>
			<optgroup label="NEIGHBORING CITIES">
				<option value="Kidapawan City" <?php if($businessDetails->businessLocation === "Kidapawan City"){echo "selected=\"selected\"";}?> >Kidapawan City</option>
				<option  value="Cotabato City" <?php if($businessDetails->businessLocation === "Cotabato City"){echo "selected=\"selected\"";}?> >Cotabato City</option>
				<option value="General Santos City" <?php if($businessDetails->businessLocation === "General Santos City"){echo "selected=\"selected\"";}?> >General Santos City</option>
				
			</optgroup>
		</select>
		<?php if(isset($errbusinessLocation)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessLocation</div>";}?>
	</div>
</div><!--Business Location-->
  <div class="form-group">
    <label for="businessPhone" class="col-sm-3 control-label">Business Phone</label>
    <div class="col-sm-8">
      <input type="tel" required class="form-control" id="businessPhone" name = "businessPhone" placeholder="Mobile or Landline" value="<?php echo $businessDetails->businessPhone;?>">
	  <?php if(isset($errbusinessPhone)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessPhone</div>";}?>
    </div>
  </div><!--Business Phone-->
  <div class="form-group">
    <label for="businessFax" class="col-sm-3 control-label">Business Fax</label>
    <div class="col-sm-8">
      <input type="tel" class="form-control" id="businessFax"  name = "businessFax" placeholder="Fax Number" value="<?php echo $businessDetails->businessFax;?>">
	  <?php if(isset($errbusinessFax)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessFax</div>";}?>
    </div>
  </div><!--Business Fax-->
   <div class="form-group">
    <label for="businessEmail" class="col-sm-3 control-label">Business Email</label>
    <div class="col-sm-8">
      <input type="text" required class="form-control" id="businessEmail"  name = "businessEmail" placeholder="Business Email" value="<?php echo $businessDetails->businessEmail;?>">
	  <?php if(isset($errbusinessEmail)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessEmail</div>";}?>
    </div>
  </div>
  <div class="form-group">
    <label for="businessWebsite" class="col-sm-3 control-label">Business Website</label>
    <div class="col-sm-8">
      <input type="url" class="form-control" id="businessWebsite"  name = "businessWebsite" placeholder="http://www.yourbusinesswebsite.com" value="<?php echo $businessDetails->businessWebsite;?>">
    </div>
  </div><!--Business Website-->
  <div class="form-group">
    <label for="businessDescription" class="col-sm-3 control-label">Business Description</label>
    <div class="col-sm-8">

      <textarea type="textarea" required col = "10" rows = "10"class="form-control"  id="businessDescription" name = "businessDescription" ><?php 		
			
			$clean_description = removeslashes($businessDetails->businessDescription);
			echo "$clean_description";
			?></textarea>
	  <?php if(isset($errbusinessDescription)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessDescription</div>";}?>
    </div>
  </div><!--Business Description-->
  <div class="form-group">
    <label for="businessTags" class="col-sm-3 control-label">Business Tags <span class = "glyphicon glyphicon-question-sign"></label>
    <div class="col-sm-8">
      <input type="text" required class="form-control" id="businessTags" name = "businessTags" placeholder = "Keywords related to your business" value="<?php echo $businessDetails->businessTags;?>"></input>
	  <?php if(isset($errbusinessTags)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessTags</div>";}?>
    </div>
  </div><!--Business Tags-->
  </div>
</div><!-- Panel Business Information -->

 <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
      <div class="checkbox">
        <label for="businessAgree">
		<input type = "hidden" name = "businessUpDate" value ="<?php echo time(); ?>"/>
          <input type="checkbox" id = "businessAgree" name = "businessAgree" > I have read the <a href="terms.php">Terms and Conditions</a>
		  <?php if(isset($errbusinessAgree)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessAgree</div>";}?>
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div align = "center">
      <button type="submit" class="btn btn-danger" name= "updateBusiness"><span class = "glyphicon glyphicon-floppy-save"></span> Save</button>&nbsp;&nbsp;&nbsp;
      <a href="businessView.php" class="btn btn-info"><span class = "glyphicon glyphicon-ban-circle"></span> Cancel</a>
    </div>
  </div>

</form>
</section>
<?php include("_/components/includes/footer.php");?>
<?php ob_end_flush();?>