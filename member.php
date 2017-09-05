<?php ob_start(); ?>
<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require_once("_/components/includes/functions.php"); ?>
<?php require_once("_/components/includes/class/business.php"); ?>
<?php require_once("_/components/includes/class/item.php"); ?>
<?php require_once("_/components/includes/class/privateMessage.php"); ?>
<?php include("_/components/includes/header.php");?>
<?php $session->confirm_logged_in(); ?>
<aside class = "col-lg-3 col-md-3 col-sm-4 col-xs-12">
	<h4>What would you like to do?</h4>
	<ul class = "nav nav-pills nav-stacked">
		<li class = "active"><a href="member.php">My Account Manager</a></li>
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
		<li><a href="loginUpdate.php">Change Login Information</a></li>
		<li><a href="logout.php">Logout</a></li>
	</ul>
</aside>
	<article class = "col-lg-9 col-md-9 col-sm-8 col-xs-12 jumbotron">
		<h1>Account Manager</h1>
			<p>This is your account settings.</p>
			<p>It is here that you can manage all your posts in Agila Directory. You can add, edit or update, view, or delete your posts. Just be careful with your clicks though, as accidentally deleting your post cannot be undone.</p>
			<h4>Feel free to harness Davao Webgate's power!</h4>
			<p>Other than being a directory of business listings of Davao City, Davao WEbgate is directory of fun and enjoyment. Now let Davao Webgate fly to your friends to tell the good news! Share Davao Webgate to your friends and family on facebook, twitter, or in any other way to have them experience the same excitement you got!</p>
			<p>Start managing your account now by clicking any of the links available over to the left side of this page.</p>
			<h2 align = "center">MABUHAY ANG DABAWENYOS!</h2>
	</article>
<?php include("_/components/includes/footer.php");?>
<?php ob_end_flush();?>