<?php ob_start(); ?>
<?php require("_/components/includes/class/session.php"); ?>
<?php require("_/components/includes/functions.php"); ?>
<?php require_once("_/components/includes/class/business.php"); ?>
<?php require_once("_/components/includes/class/item.php"); ?>
<?php require("_/components/includes/class/user.php"); ?>
<?php require("_/components/includes/userValidation.php");?>
<?php require("_/components/includes/header.php");?>
<div class = "row">
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 jumbotron pull-left">
	<h1>Signup Benefits</h1>
	<br />
	  <p><strong><em>Davao Webgate IS free!</em></strong> So don't waste a second to signup now and harness all the possible benefits of becoming a member. Get these benefits when you register today:</p>
	  <ol>
		<li>Enlist your business for free</li>
		<li>Hire new employees</li>
		<li>Describe your products or services</li>
		<li>Be part of featured listings</li>
	  </ol>
	  <p>Davao is continually expanding its business horizon. People around Region XI, even tourists &amp; foreigners, come to the city looking for products, services, entertainment, or leisure &amp; the need for a one stop online directory is needed to make transactions between individuals or businesses more convenient. This is what Davao Webgate is for.</p>
</div>
<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 pull-right" >
<form id = "userRegistration" class="form-horizontal" role="form" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" method="post">
	<legend>User Registration</legend>
<?php 
	if(isset($errMessage)){
		echo "<div class =\"alert alert-danger\" style=\"font-size: .85em;\" align=\"center\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$errMessage</div>";
	}		
?>
	
	<div class="panel panel-primary">
		<!-- Default panel contents -->
		<div class="panel-heading">Account Information</div>
		<div class="panel-body" style="font-size: .8em;">
			<div class="form-group">
				<label for="firstName" class="col-sm-4 control-label">First Name</label>
					<div class="col-sm-6">
						<input type="text"  minlength="2" class="form-control input-sm" id="firstName" name = "firstName" value="<?php if (isset($firstName)){echo "$firstName";}?>" placeholder="First Name">
						<?php if(isset($errfirstName)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errfirstName</div>";}?>
					</div>
			</div>
			<div class="form-group">
				<label for="middleName" class="col-sm-4 control-label">Middle Name</label>
					<div class="col-sm-6">
						<input type="text" minlength="2" class="form-control input-sm" id="middleName" name = "middleName" value="<?php if (isset($middleName)){echo "$middleName";}?>" placeholder="Middle Name">
					</div>
			</div>
			<div class="form-group">
				<label for="lastName" class="col-sm-4 control-label">Last Name</label>
					<div class="col-sm-6">
						<input type="text"  minlength="2" class="form-control input-sm" id="lastName" name = "lastName" value="<?php if (isset($lastName)){echo "$lastName";}?>" placeholder="Last Name">
						<?php if(isset($errlastName)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errlastName</div>";}?>
					</div>
			</div>
			<div class="form-group" >
				<label for="gender" class="col-sm-4 control-label">Gender</label>
				<div class="col-sm-6" style="font-size: 1.2em;">
					<label class="radio-inline">
						<input type="radio" id="gender1" name="gender" value="male" <?php if (isset($gender) && $gender == 'male'){echo "checked";}?>> Male
					</label>
					<label class="radio-inline">
						<input type="radio" id="gender2" name="gender" value="female" <?php if (isset($gender) && $gender == 'female'){echo "checked";}?>> Female
					</label>
					<?php if(isset($erruserGender)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$erruserGender</div>";}?>
				</div>
				
			</div>
			<div class="form-group">
				<label for="userPhone" class="col-sm-4 control-label">Phone</label>
					<div class="col-sm-6">
						<input type="tel"  class="form-control input-sm" id="userPhone" name = "userPhone" value="<?php if (isset($userPhone)){echo "$userPhone";}?>" placeholder="Mobile or Landline">
						<?php if(isset($erruserPhone)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$erruserPhone</div>";}?>
					</div>
			</div>
			<div class="form-group">
				<label for="userFax" class="col-sm-4 control-label">Fax</label>
					<div class="col-sm-6">
						<input type="tel" class="form-control input-sm" id="userFax" name = "userFax" value="<?php if (isset($userFax)){echo "$userFax";}?>" placeholder="Fax Number (optional)">
						<?php if(isset($erruserFax)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$erruserFax</div>";}?>
					</div>
			</div>
		</div><!--Panel Body-->
	</div><!-- Panel Account Information -->

	<div class="panel panel-primary">
	<!-- Default panel contents -->
		<div class="panel-heading">Login Information</div>
		<div class="panel-body" style="font-size: .8em;">
			<div class="form-group">
				<label for="userMail" class="col-sm-4 control-label">Email</label>
					<div class="col-sm-6">
						<input type="email"  class="form-control input-sm" id="userMail" name = "userMail" value="<?php if (isset($userMail)){echo "$userMail";}?>" placeholder="Email">
						<?php if(isset($erruserMail)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$erruserMail</div>";}?>
					</div>
			</div>
			<div class="form-group">
				<label for="inputPassword1" class="col-sm-4 control-label">Password</label>
					<div class="col-sm-6">
						<input type="password"  minlength="6" class="form-control input-sm" id="inputPassword1" name = "userPassword1" value="<?php if (isset($password_1)){echo "$password_1";}?>" placeholder="Password">
						<?php if(isset($errpassword_1)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errpassword_1</div>";}?>
					</div>
			</div>
			<div class="form-group">
				<label for="inputPassword2" class="col-sm-4 control-label">Confirm Password</label>
					<div class="col-sm-6">
						<input type="password"  minlength="6" class="form-control input-sm" id="inputPassword2" name = "userPassword2" value="<?php if (isset($password_2)){echo "$password_2";}?>" placeholder="Confirm Password">
						<?php if(isset($errpassword_2)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errpassword_2</div>";}?>
					</div>
			</div>
		</div>
	</div><!-- Panel Login Information -->
				<div align="center">
					 <?php
						  require_once('_/components/includes/recaptchalib.php');
						  $publickey = "6Lc5-_ISAAAAAIdkYXYt7nKHT87DfFt638oUsGuj "; // you got this from the signup page
						  echo recaptcha_get_html($publickey);
					?>

				</div>			

	<div class="form-group">
		<div  class = "col-sm-8 col-sm-offset-2">
			<div class="checkbox">
				<label for="agree">
					<input type = "hidden" name = "registerDate" value ="<?php echo time(); ?>"/>
					<input type="checkbox" id = "agree" name = "agree" > I have read the <a style="color:blue;"href="terms.php">Terms and Conditions</a>.					
				</label>
				
			</div>
			<?php if(isset($errAgree)){echo "<div class =\"text-danger\" style = \"margin-top: 2px; font-size:.85em;\">$errAgree</div>";}?>
		</div>
	</div>  
	<div class="form-group">
		<div align = "center">
			<button type="submit" class="btn btn-danger btn-sm" name = "registerUser" ><span class = "glyphicon glyphicon-ok"></span> Sign up</button>&nbsp;&nbsp;&nbsp;
			<a href="index.php" class="btn btn-info btn-sm"><span class = "glyphicon glyphicon-ban-circle"></span> Cancel</a>
		</div>
	</div>
</form>
</div>
</div>

<?php include("_/components/includes/footer.php");?>
<?php ob_end_flush();?>