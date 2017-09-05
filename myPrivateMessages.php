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
		<li><a href="member.php">My Account Manager</a></li>
		<li class="active"><a href="myPrivateMessages.php">My Private Messages <?php $privateMessages = new PrivateMessage();
				$privateMessages->toUserID = $_SESSION['userID'];
				$privateMessageObject = PrivateMessage::find_by_receiver($privateMessages->toUserID);
				if (!empty($privateMessageObject)) {
					$counted_messages = (int)count($privateMessageObject);
				}else {$counted_messages = '0';}				 
				echo "($counted_messages)";
				?></a></li>
		<li><a href="businessView.php">View My Business List</a></li>
		<li><a href="#jade" data-toggle = "modal">View My Job Posts</a></li>
		<li><a href="itemView.php">View My Items</a></li>
		<li><a href="businessRegistration.php">Add a Business List</a></li>
		<li><a href="#">Post a Job</a></li>
		<li><a href="marketplacePost.php">Sell an Item</a></li>
		<li><a href="userUpdate.php">Edit Account</a></li>
		<li><a href="loginUpdate.php">Change Login Information</a></li>
		<li><a href="logout.php">Logout</a></li>
	</ul>
</aside>
<section class="col col-lg-9  col-md-9 col-sm-8 col-xs-12">

<?php 
	$privateMessage = new PrivateMessage();
	$privateMessage->toUserID = $_SESSION['userID'];
	$privateMessageObject = PrivateMessage::find_by_receiver($privateMessage->toUserID);
	if(!empty($privateMessageObject)){
		//you have messages
		
		$counted_messages = (int)count($privateMessageObject);
		$message = "You have <b>($counted_messages)</b> private messages.";
		echo "<div class =\"alert alert-success\" style=\"font-size: 1em;\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$message</div>";
		echo "<table class = \"table table-responsive table-striped table-hover\">";
			echo "<thead>";
				echo "<tr>";
					echo "<th>Subject</th>";
					echo "<th>Item Title</th>";
					echo "<th>From</th>";
					echo "<th>Message</th>";
					echo "<th>Received On</th>";
				echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
	
		foreach ($privateMessageObject as $object => $privateMessageDetails) {
			$fromUserMail = "$privateMessageDetails->fromUserMail";
			$messageSubject = "$privateMessageDetails->messageSubject";
			$messageContent = html_entity_decode($privateMessageDetails->privateMessage);
			date_default_timezone_set('Asia/Manila');
			$messageReceived = date("D | j F Y | g:i A", $privateMessageDetails->privateMessagePostDate);
					
			$itemID = "$privateMessageDetails->itemID";
			//var_dump($privateMessageDetails);
			$item = new Item();
			$item->itemID = (int)$itemID;
			$itemObjects = Item::find_by_itemID($item->itemID);
			if (!empty($itemObjects)) {
				foreach ($itemObjects as $itemObject => $itemDetails) {
					$itemTitle = $itemDetails->itemTitle;
			
					echo "<tr>";
					echo "<td><span style = \"color: #999; font-size: .9em;\"><b>$messageSubject</b></span></td>";					
					echo "<td><span style = \"color: #666; font-size: .9em;\">".removeslashes($itemTitle)."</span></td> ";
					echo "<td><span style = \"color: #666; font-size: .95em;\">$fromUserMail</span></td>";
					echo "<td><a href = \"#".$itemID."\" data-toggle = \"modal\" class=\"btn btn-warning btn-xs\">read</a></td>";
					echo "<td><span style = \"color: #999; font-size: .8em;\">$messageReceived</span></td>";
					echo "</tr>";
					echo "<div class=\"modal fade\" id=\"$itemID\">";?><!-- temporary out of php mode-->
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Subject: <?php echo "$messageSubject";?></h4>
								</div><!-- modal-header -->
								<div class="modal-body">
									<p><b>Item:</b> <?php echo removeslashes($itemTitle);?></p>
									<p><b>From:</b> <?php echo "$fromUserMail";?></p>
									<p><b>Message:</b><?php echo "<p>$messageContent</p>";?></p>
								</div><!-- modal-body -->
								<div class="modal-footer">
									<!-- <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Reply</button>
									<button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Delete</button> -->
									<button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Close</button>
								</div><!-- modal-footer -->
							</div><!-- modal-content -->	
						</div><!-- modal-dialog -->	
					</div><!-- modal-fade -->		
				<?php //return back to php mode
				}//end foreach
						
			}//end itemObjects
				
		}//end foreach
		echo "</tbody>";
		echo "</table>";
		//var_dump($privateMessageObject);
		
		// echo "<div class = \"clearfix\"></div>";
	}else {
		$message = "You do not have yet any private messages";
		echo "<div class =\"alert alert-success\" style=\"font-size: 1em;\"><span class = \"glyphicon glyphicon-exclamation-sign\"></span>&nbsp;&nbsp;&nbsp;$message</div>";
		
	}
?>
</section>
 <div class = "clearfix"></div>
 &nbsp;
<?php include("_/components/includes/footer.php");?>
<?php ob_end_flush();?>