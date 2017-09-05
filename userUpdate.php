<?php ob_start(); ?>
<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require_once("_/components/includes/functions.php"); ?>
<?php require_once("_/components/includes/class/business.php"); ?>
<?php require_once("_/components/includes/class/item.php"); ?>
<?php require_once("_/components/includes/class/user.php"); ?>
<?php require_once("_/components/includes/class/privateMessage.php"); ?>
<?php include("_/components/includes/header.php");?>
<?php $session->confirm_logged_in(); ?>
<?php 
	$user = new User();
	$user->userID = $_SESSION['userID'];
	$userDetails = User::find_by_id($user->userID);
?>
<?php include("_/components/includes/userValidation.php");?>
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
		<li><a href="myPrivateMessages.php">My Private Messages <?php $privateMessages = new PrivateMessage();
				$privateMessages->toUserID = $_SESSION['userID'];
				$privateMessageObject = PrivateMessage::find_by_receiver($privateMessages->toUserID);
				if (!empty($privateMessageObject)) {
					$counted_messages = (int)count($privateMessageObject);
				}else {$counted_messages = '0';}				 
				echo "($counted_messages)";
				?></a></li>
		<li><a href="#">View My Job Posts</a></li>
		<li><a href="itemView.php">View My Items</a></li>
		<li><a href="businessRegistration.php">Add a Business List</a></li>
		<li><a href="#">Post a Job</a></li>
		<li><a href="marketplacePost.php">Sell an Item</a></li>
		<li class = "active"><a href="userUpdate.php">Edit Account</a></li>
		<li><a href="loginUpdate.php">Change Login Information</a></li>
		<li><a href="logout.php">Logout</a></li>
	</ul>
</aside>
<section class="col col-lg-6 col-md-6 col-sm-6 col-xs-12">
<form class="form-horizontal" role="form" action="<?php echo $_SERVER['PHP_SELF'];?>"  method="post">
	<legend>Edit Your Account</legend>
	<?php if(isset($errMessage)){
				unset($_SESSION['successUpdate']);
				echo "<div class =\"alert alert-danger\" style=\"font-size: .85em;\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$errMessage</div>";
			
			}
			if(isset($_SESSION['successUpdate'])){
				$successMessage = $_SESSION['successUpdate'];
				echo "<div class =\"alert alert-success\" style=\"font-size: .85em;\"><span class = \"glyphicon glyphicon-check\"></span>&nbsp;&nbsp;&nbsp;$successMessage</div>";
				unset($_SESSION['successUpdate']);
			}
	?>
	  <div class="panel panel-info">
  <!-- Default panel contents -->
  <div class="panel-heading">Account Information</div>
  <div class="panel-body">
  <div class="form-group">
    <input type = "hidden" name = "userID" value ="<?php echo $user->userID; ?>"/>
	<label for="firstName" class="col-sm-3 control-label">First Name</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" value="<?php echo $userDetails->firstName;?>">
	  <?php if(isset($errfirstName)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errfirstName</div>";}?>
    </div>
  </div>
  <div class="form-group">
    <label for="middleName" class="col-sm-3 control-label">Middle Name</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="middleName" name="middleName" placeholder="Middle Name" value="<?php echo $userDetails->middleName;?>">
    </div>
  </div>
  <div class="form-group">
    <label for="lastName" class="col-sm-3 control-label">Last Name</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo $userDetails->lastName;?>">
	  <?php if(isset($errlastName)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errlastName</div>";}?>
    </div>
  </div>
  <div class="form-group">
  	<label for="gender" class="col-sm-3 control-label">Gender</label>
    <div class="col-sm-8">
    <label class="radio-inline">
  <input type="radio" id="inlineRadio1" name="gender" value="male" <?php if($userDetails->gender == "male") {echo " checked = \"checked\"";} ?>> Male
</label>
<label class="radio-inline">
  <input type="radio" id="inlineRadio2" name="gender" value="female" <?php if($userDetails->gender == "female") {echo " checked = \"checked\"";} ?>> Female
</label>
<?php if(isset($erruserGender)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$erruserGender</div>";}?>
  </div>
</div>
  <div class="form-group">
    <label for="userPhone" class="col-sm-3 control-label">Phone</label>
    <div class="col-sm-8">
      <input type="tel" class="form-control" id="userPhone" name="userPhone" placeholder="Mobile or Landline" value="<?php echo $userDetails->userPhone;?>">
	  <?php if(isset($erruserPhone)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$erruserPhone</div>";}?>
    </div>
  </div>
  <div class="form-group">
    <label for="userFax" class="col-sm-3 control-label">Fax</label>
    <div class="col-sm-8">
      <input type="tel" class="form-control" id="userFax" name="userFax" placeholder="Fax Number" value="<?php echo $userDetails->userFax;?>">
	  <?php if(isset($erruserFax)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$erruserFax</div>";}?>
		<input type = "hidden" name = "registerUpDate" value ="<?php echo time(); ?>"/>
	</div>
  </div>
  </div>
</div><!-- Panel Account Information -->
&nbsp;
  <div class="form-group">
    <div align = "center">
      <button type="submit" class="btn btn-danger" name="updateUser"><span class = "glyphicon glyphicon-floppy-save"></span> Save</button>&nbsp;&nbsp;&nbsp;
      <a href="member.php" class="btn btn-info"><span class = "glyphicon glyphicon-ban-circle"></span> Cancel</a>
    </div>
  </div>

</form>
</section>
 <div class = "clearfix"></div>
 &nbsp;
<?php include("_/components/includes/footer.php");?>
<?php ob_end_flush();?>