<?php ob_start(); ?>
<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require_once("_/components/includes/functions.php"); ?>
<?php require_once("_/components/includes/class/business.php"); ?>
<?php require_once("_/components/includes/class/item.php"); ?>
<?php require_once("_/components/includes/class/privateMessage.php"); ?>
<?php include("_/components/includes/header.php");?>
<?php $session->confirm_logged_in(); ?>
<?php 	
	if (isset($_SESSION['userID'])){
		$business = new Business();
		$business->userID = $_SESSION['userID'];
	}
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
<form id = "businessForm" class="form-horizontal" role="form" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" method="post">
	<legend>Business Registration</legend>
	<?php 
		
	if(isset($errMessage)){
		echo "<div class =\"alert alert-danger\" style=\"font-size: .85em;\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$errMessage</div>";
	}		
	?>
	  <div class="panel panel-info">
  <!-- Default panel contents -->
  <div class="panel-heading">Business Information</div>
  <div class="panel-body">
  <div class="form-group">
    <label for="businessName" class="col-sm-3 control-label">Business Name</label>
    <div class="col-sm-8">
      <input type="text"  class="form-control" id="businessName" name="businessName" value="<?php if (isset($businessName)){echo "$businessName";}?>" placeholder="Business Name">
	  <?php if(isset($errbusinessName)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessName</div>";}?>
    </div>
  </div><!--Business Name-->
	<div class="form-group">
		<label for="businessCategory" class="col-sm-3 control-label">Category</label>
		<div class="col-sm-8">
			<label for = "products" class="radio-inline">
				<input type="radio" id="products" name="businessCategory" value="Products" <?php if (isset($businessCategory) && $businessCategory == 'Products'){echo " checked";}?>/> Products
			</label>
			<label for = "services" class="radio-inline">
				<input type="radio" id="services" name="businessCategory" value="Services" <?php if (isset($businessCategory) && $businessCategory == 'Services'){echo " checked";}?>/> Services
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
							if (isset($businessTypeProducts)){
								$businessType = $businessTypeProducts;
								if($value === $businessType){echo "selected=\"selected\"";}
							}							
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
							if (isset($businessTypeServices)){
								$businessType = $businessTypeServices;
								if($value === $businessType){echo "selected=\"selected\"";}
							}								
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
      <input type="text"  class="form-control" id="businessAddress" name = "businessAddress" value="<?php if (isset($businessAddress)){echo "$businessAddress";}?>" placeholder="Business Address">
	  <?php if(isset($errbusinessAddress)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessAddress</div>";}?>
    </div>
  </div><!--Business Address-->
   <div class="form-group">
    <label for="productORservice" class="col-sm-3 control-label">Business Location</label>
  <div class="col-sm-8" id="businessLocation">
      <select class="form-control"  name="businessLocation">
			<optgroup label="DAVAO CITY">
				<option value="Davao City">Davao City</option>
			</optgroup>
			<optgroup label="COMPOSTELA VALLEY">
				<option  value="Compostela, Compostela Valley">Compostela, Compostela Valley</option>
				<option  value="Laak, Compostela Valley">Laak, Compostela Valley</option>
				<option  value="Mabini, Compostela Valley">Mabini, Compostela Valley</option>
				<option value="Maco, Compostela Valley">Maco, Compostela Valley</option>
				<option  value="Maragusan, Compostela Valley">Maragusan, Compostela Valley</option>
				<option  value="Mawab, Compostela Valley">Mawab, Compostela Valley</option>
				<option  value="Monkayo, Compostela Valley">Monkayo, Compostela Valley</option>
				<option  value="Montevista, Compostela Valley">Montevista, Compostela Valley</option>
				<option  value="Nabunturan, Compostela Valley">Nabunturan, Compostela Valley</option>
				<option  value="New Bataan, Compostela Valley">New Bataan, Compostela Valley</option>
				<option  value="Pantukan, Compostela Valley">Pantukan, Compostela Valley</option>
			</optgroup>
			<optgroup label="DAVAO DEL NORTE">
				<option  value="Asuncion, Davao del Norte">Asuncion, Davao del Norte</option>
				<option  value="Braulio E. Dujali, Davao del Norte">Braulio E. Dujali, Davao del Norte</option>
				<option  value="Carmen, Davao del Norte">Carmen, Davao del Norte</option>
				<option  value="Panabo City">Panabo City</option>
				<option  value="Tagum City">Tagum City</option>
				<option  value="Island Garden City of Samal">Island Garden City of Samal</option>
				<option  value="Kapalong, Davao del Norte">Kapalong, Davao del Norte</option>
				<option value="New Corella, Davao del Norte">New Corella, Davao del Norte</option>
				<option  value="San Isidro, Davao del Norte">San Isidro, Davao del Norte</option>
				<option  value="Santo Tomas, Davao del Norte">Santo Tomas, Davao del Norte</option>
				<option  value="Talaingod, Davao del Norte">Talaingod, Davao del Norte</option>
			</optgroup>
			<optgroup label="DAVAO DEL SUR">
				<option value="Bansalan, Davao del Sur">Bansalan, Davao del Sur</option>
				<option  value="Digos City">Digos City</option>				
				<option  value="Don Marcelino, Davao del Sur">Don Marcelino, Davao del Sur</option>
				<option  value="Hagonoy, Davao del Sur">Hagonoy, Davao del Sur</option>
				<option  value="Jose Abad Santos, Davao del Sur">Jose Abad Santos, Davao del Sur</option>
				<option  value="Kiblawan, Davao del Sur">Kiblawan, Davao del Sur</option>
				<option  value="Magsaysay, Davao del Sur">Magsaysay, Davao del Sur</option>
				<option  value="Malalag, Davao del Sur">Malalag, Davao del Sur</option>
				<option  value="Malita, Davao del Sur">Malita, Davao del Sur</option>
				<option  value="Matanao, Davao del Sur">Matanao, Davao del Sur</option>
				<option  value="Padada, Davao del Sur">Padada, Davao del Sur</option>
				<option  value="Santa Cruz, Davao del Sur">Santa Cruz, Davao del Sur</option>
				<option  value="Santa Maria, Davao del Sur">Santa Maria, Davao del Sur</option>
				<option  value="Sarangani, Davao del Sur">Sarangani, Davao del Sur</option>
				<option  value="Sulop, Davao del Sur">Sulop, Davao del Sur</option>
			</optgroup>
			<optgroup label="DAVAO ORIENTAL">
				<option value="Baganga, Davao Oriental">Baganga, Davao Oriental</option>
				<option  value="Banaybanay, Davao Oriental">Banaybanay, Davao Oriental</option>
				<option value="Boston, Davao Oriental">Boston, Davao Oriental</option>
				<option value="Caraga, Davao Oriental">Caraga, Davao Oriental</option>
				<option value="Cateel, Davao Oriental">Cateel, Davao Oriental</option>
				<option value="Mati City">Mati City</option>
				<option value="Governor Generoso, Davao Oriental">Governor Generoso, Davao Oriental</option>
				<option value="Lupon, Davao Oriental">Lupon, Davao Oriental</option>
				<option  value="Manay, Davao Oriental">Manay, Davao Oriental</option>
				<option value="San Isidro, Davao Oriental">San Isidro, Davao Oriental</option>
				<option value="Tarragona, Davao Oriental">Tarragona, Davao Oriental</option>
			</optgroup>
			<optgroup label="NEIGHBORING CITIES">
				<option value="Cagayan de Oro City">Cagayan de Oro City</option>
				<option value="Kidapawan City">Kidapawan City</option>
				<option  value="Cotabato City">Cotabato City</option>
				<option value="General Santos City">General Santos City</option>
				
			</optgroup>
		</select>
		<?php if(isset($errbusinessLocation)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessLocation</div>";}?>
	</div>
</div><!--Business Location-->
  <div class="form-group">
    <label for="businessPhone" class="col-sm-3 control-label">Business Phone</label>
    <div class="col-sm-8">
      <input type="tel"  class="form-control" id="businessPhone" name = "businessPhone" value="<?php if (isset($businessPhone)){echo "$businessPhone";}?>" placeholder="Mobile or Landline (up to 3 phone numbers only, comma separated)">
	  <?php if(isset($errbusinessPhone)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessPhone</div>";}?>
    </div>
  </div><!--Business Phone-->
  <div class="form-group">
    <label for="businessFax" class="col-sm-3 control-label">Business Fax</label>
    <div class="col-sm-8">
      <input type="tel" class="form-control" id="businessFax"  name = "businessFax" value="<?php if (isset($businessFax)){echo "$businessFax";}?>" placeholder="Fax Number">
	  <?php if(isset($errbusinessFax)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessFax</div>";}?>
    </div>
  </div><!--Business Fax-->
   <div class="form-group">
    <label for="businessEmail" class="col-sm-3 control-label">Business Email</label>
    <div class="col-sm-8">
      <input type="text"  class="form-control" id="businessEmail"  name = "businessEmail" value="<?php if (isset($businessEmail)){echo "$businessEmail";}?>" placeholder="Business Email">
	  <?php if(isset($errbusinessEmail)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessEmail</div>";}?>
    </div>
  </div>
  <div class="form-group">
    <label for="businessWebsite" class="col-sm-3 control-label">Business Website</label>
    <div class="col-sm-8">
      <input type="url" class="form-control" id="businessWebsite"  name = "businessWebsite" value="<?php if (isset($businessWebsite)){echo "$businessWebsite";}?>" placeholder="http://www.yourbusinesswebsite.com">
    </div>
  </div><!--Business Website-->
  <div class="form-group">
    <label for="businessDescription" class="col-sm-3 control-label">Business Description</label>
    <div class="col-sm-8">
      <textarea type="textarea"  col = "10" rows = "10"class="form-control" id = "businessDescription" name = "businessDescription" ><?php if (isset($businessDescription)){echo "$businessDescription";}?></textarea>
	  <?php if(isset($errbusinessDescription)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessDescription</div>";}?>
    </div>
  </div><!--Business Description-->
  <div class="form-group">
    <label for="businessTags" class="col-sm-3 control-label">Business Tags <span class = "glyphicon glyphicon-question-sign"></label>
    <div class="col-sm-8">
      <input type="text"  class="form-control" id="businessTags" name = "businessTags" value="<?php if (isset($businessTags)){echo "$businessTags";}?>" placeholder = "Keywords related to your business"></input>
	  <?php if(isset($errbusinessTags)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessTags</div>";}?>
    </div>
  </div><!--Business Tags-->
  </div>
</div><!-- Panel Business Information -->

 <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
      <div class="checkbox">
        <label for="businessAgree">
		<input type = "hidden" name = "businessPostDate" value ="<?php echo time(); ?>"/>
          <input type="checkbox" id = "businessAgree" name = "businessAgree" > I have read the <a href="terms.php">Terms and Conditions</a>
		  <?php if(isset($errbusinessAgree)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errbusinessAgree</div>";}?>
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div align = "center">
      <button type="submit" class="btn btn-danger" name= "registerBusiness"><span class = "glyphicon glyphicon-ok"></span> Register</button>&nbsp;&nbsp;&nbsp;
      <a href="member.php" class="btn btn-info"><span class = "glyphicon glyphicon-ban-circle"></span> Cancel</a>
    </div>
  </div>

</form>
</section>
 <div class = "clearfix"></div>
<?php include("_/components/includes/footer.php");?>
<?php ob_end_flush();?>