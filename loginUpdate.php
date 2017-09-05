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
		<li><a href="#">View My Job Posts</a></li>
		<li><a href="itemView.php">View My Items</a></li>
		<li><a href="businessRegistration.php">Add a Business List</a></li>
		<li><a href="#">Post a Job</a></li>
		<li><a href="marketplacePost.php">Sell an Item</a></li>
		<li><a href="userUpdate.php">Edit Account</a></li>
		<li class = "active"><a href="loginUpdate.php">Change Login Information</a></li>
		<li><a href="logout.php">Logout</a></li>
	</ul>
</aside>
<section class="col col-lg-6 col-md-6 col-sm-6 col-xs-12">
<form class="form-horizontal" role="form" action="<?php echo $_SERVER['PHP_SELF'];?>"  method="post">
	<legend>Change Your Login Information</legend>
	<?php if(isset($errMessage)){
				unset($_SESSION['successUpdateLogin']);
				echo "<div class =\"alert alert-danger\" style=\"font-size: .85em;\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$errMessage</div>";
			
			}
			if(isset($_SESSION['successUpdateLogin'])){
				$successMessage = $_SESSION['successUpdateLogin'];
				echo "<div class =\"alert alert-success\" style=\"font-size: .85em;\"><span class = \"glyphicon glyphicon-check\"></span>&nbsp;&nbsp;&nbsp;$successMessage</div>";
				unset($_SESSION['successUpdateLogin']);
			}
	?>
	  <div class="panel panel-info">
  <!-- Default panel contents -->
  <div class="panel-heading">Login Information</div>
  <div class="panel-body">
			<div class="form-group">
				<label for="userMail" class="col-sm-4 control-label">Email</label>
					<div class="col-sm-6">
						<input type="email" class="form-control" id="userMail" name = "userMail" placeholder="Email" value="<?php echo $userDetails->userMail;?>">
						<?php if(isset($erruserMail)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$erruserMail</div>";}?>
					</div>
			</div>
			<div class="form-group">
				<label for="inputPassword1" class="col-sm-4 control-label">New Password</label>
					<div class="col-sm-6">
						<input type="password" class="form-control" id="inputPassword1" name = "userPassword1" placeholder="New Password">
						<?php if(isset($errpassword_1)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errpassword_1</div>";}?>
					</div>
			</div>
			<div class="form-group">
				<label for="inputPassword2" class="col-sm-4 control-label">Confirm Password</label>
					<div class="col-sm-6">
						<input type="password" class="form-control" id="inputPassword2" name = "userPassword2" placeholder="Confirm Password">
						<?php if(isset($errpassword_2)){echo "<div class =\"text-danger\" style = \"margin-top: 2px;\">$errpassword_2</div>";}?>
						<input type = "hidden" name = "registerUpDate" value ="<?php echo time(); ?>"/>
					</div>
			</div>
		</div>
</div><!-- Panel Account Information -->
&nbsp;
  <div class="form-group">
    <div align = "center">
      <button type="submit" class="btn btn-danger" name="updateLogin"><span class = "glyphicon glyphicon-floppy-save"></span> Save</button>&nbsp;&nbsp;&nbsp;
      <a href="member.php" class="btn btn-info"><span class = "glyphicon glyphicon-ban-circle"></span> Cancel</a>
    </div>
  </div>

</form>
</section>
 <div class = "clearfix"></div>
 &nbsp;
<?php include("_/components/includes/footer.php");?>
<?php ob_end_flush();?>