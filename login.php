<?php ob_start(); ?>
<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require_once("_/components/includes/class/user.php");?> <!--Initializes the object $database-->
<?php require_once("_/components/includes/class/database.php");?> <!--Initializes the object $database-->
<?php require_once("_/components/includes/functions.php"); ?>
<?php require_once("_/components/includes/class/business.php"); ?>
<?php require_once("_/components/includes/class/item.php"); ?>
<?php $session->confirm_logged_in_index();?>
<?php $title = "Davao City Premiere Online Directory - Davao Webgate";?>
<?php include("_/components/includes/header.php");?>

<?php
if (isset($_POST['submit']) || isset($_GET['done'])){	
	if(isset($_POST['userMail']) && isset($_POST['userPassword'])){
			$userMail = trim($database->PrepSQL($_POST['userMail']));
			$userPassword = trim($database->PrepSQL($_POST['userPassword']));
			$hashedPassword = hash('sha256', $userPassword);
			
			//ASSIGN THE VALUES TO THE CLASS USER PROPERTY	
			$user = new User();
			$user->userMail = $userMail;
			$user->hashedPassword = $hashedPassword;
			
			//INITIATE DATABASE QUERY IF USER EXIST			
			$userDetails = User::authenticate($user->userMail, $user->hashedPassword); //$userDetails is an OBJECT not an ARRAY
			if(!empty($userDetails)){
				$_SESSION['userID'] = $userDetails->userID;
				redirect_to('member.php');
				//echo var_dump($userDetails);
			}else {$errMessage = "Sorry, access denied! You entered an invalid information. Please try again.";}	

	}
}
?>
<div class = "row">
<div class="col-lg-6 jumbotron pull-left">
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
<div class="col-lg-5 pull-right">
<form class="form-horizontal" role="form" action="login.php?done=1" method="post">
<legend>Access Davao Webgate</legend>
<?php 
			if(isset($errMessage)){
				echo "<div class =\"alert alert-danger\" style=\"font-size: .85em;\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$errMessage</div>";
			}

			else if(isset($_SESSION['successRegistration'])){
				$successRegister = $_SESSION['successRegistration'];
				echo "<div class =\"alert alert-success\" style=\"font-size: .85em;\"><span class = \"glyphicon glyphicon-check\"></span>&nbsp;&nbsp;&nbsp;$successRegister</div>";								
				unset($_SESSION['successRegistration']);				
			}
			
			
?>
	<div class="panel panel-primary">
		<!-- Default panel contents -->
		<div class="panel-heading">Login Information</div>
		<div class="panel-body">
			<div class="form-group">
				<label for="userMail" class="col-sm-4 control-label">Email</label>
				<div class="col-sm-6">
					<input type="email" class="form-control" id="loginUserMail" name = "userMail" placeholder="Email">
				</div>
			</div>
			<div class="form-group">
				<label for="userPassword" class="col-sm-4 control-label">Password</label>
				<div class="col-sm-6">
					<input type="password" class="form-control" id="loginUserPassword" name = "userPassword" placeholder="Password">
				</div>
			</div>
			<div class="form-group">
		<div align = "center">
			<button type="submit" class="btn btn-success" name = "submit" ><span class = "glyphicon glyphicon-log-in"></span> Login</button>&nbsp;&nbsp;&nbsp;
			<a href="index.php" class="btn btn-danger"><span class = "glyphicon glyphicon-ban-circle"></span> Cancel</a>
		</div>
	</div>
	</div><!-- Panel Body -->		
	</div><!-- Panel Login Information -->	
</form>
<div align = "center">Not yet a member? <a href="userRegistration.php" class="btn btn-primary btn-xs">Register</a></div>
</div>
</div>
<?php include("_/components/includes/footer.php");?>
<?php ob_end_flush();?>