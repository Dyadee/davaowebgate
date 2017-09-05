<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Featured Listings</h3>
  </div>
  <div class="panel-body">
   <ul class="media-list">
<?php
	$business = new Business();
	$businessObject = Business::find_by_featured();
	 if(!empty($businessObject)){
		foreach($businessObject as $object => $businessDetails){
			
			echo"<li class=\"media\">";
			//PLACEHOLDER FOR LOGO
					//for logo use
							$hashedUserID = hash('sha256', $businessDetails->userID);
							$hashedBusinessID = hash('sha256', $businessDetails->businessID);				
							$directory = "uploads/$hashedUserID/Business/$hashedBusinessID";
							$files = scandir($directory);
							$excluded = array('.','..');
							$result_dir = array_diff($files, $excluded);
							if(!empty($result_dir)){
								echo"<a class=\"thumbnail pull-left\" style = \"width: 150px\" href=\"#\"><img class=\"media-object\" src=\"$directory/$result_dir[2]\"/></a>";
							}else {
								echo"<a class=\"thumbnail pull-left\" href=\"#\"><img class=\"media-object\" src=\"images/thumbnail_holder_sm.gif\"/></a>";
							}					
			//END PLACEHOLDER FOR LOGO
			
				echo "<div class=\"media-body\">";
					
						echo "<span style =\"color: #0086aa;\"><h4 class=\"media-heading\">".$businessDetails->businessName."</h4></span>";
						echo "<div style = \" font-family: 'Helvetica','Trebuchet MS', sans-serif; font-size: .8em; color: #666; \">";
						echo"<table>";
						echo "<tr><td width = '100'><b>Address:</b></td><td>$businessDetails->businessAddress, $businessDetails->businessLocation</td></tr>";
						$formatted_phone = preg_replace('/,\s/', '&nbsp;&nbsp;\&nbsp;&nbsp;', $businessDetails->businessPhone);
						echo "<tr><td><b>Contact Phone:</b></td><td>$formatted_phone</td></tr>";
						if(!empty($businessDetails->businessFax)){
							$formatted_fax = preg_replace('/,\s/', '&nbsp;&nbsp;\&nbsp;&nbsp;', $businessDetails->businessFax);
							echo "<tr><td><b>Business Fax:</b></td><td>$formatted_fax</td></tr>";
						}
						echo "<tr><td><b>Email:</b></td><td>$businessDetails->businessEmail</td></tr>";
						if(!empty($businessDetails->businessWebsite)){
							echo "<tr><td><b>website:</b></td><td><a class = \"weblink\" href=\"$businessDetails->businessWebsite\" target=\"_new\">$businessDetails->businessWebsite</a></td></tr>";
						}										
						echo"</table>&nbsp";
						echo "<span style =\"color: #333; font-size: 1em;\"><p>".substr($businessDetails->businessDescription, 0, 250)."...</p></span>";
						echo "</div>";							
						
				echo "</div>";
				echo"<div class = \"clearfix\"></div>";
				echo "<p><span class=\"pull-left\"style = \"color: #999; font-size: .8em; font-weight: bold;\">Posted in:"." &nbsp; "  .$businessDetails->businessCategory." &nbsp;|&nbsp; ".$businessDetails->businessType."</span>";
					date_default_timezone_set('Asia/Manila');						
					$timestamp1 = date("D | j F Y | g:i A", $businessDetails->businessPostDate);
					echo "<span class=\"pull-right\" style = \"color: #999; font-size: .7em; margin-top: 0;\"><b>Date Posted:</b>"." &nbsp; ".$timestamp1."</p></span>";	
				
			echo "</li>";
			echo"<hr />";
		}
	 }else{
		echo "<li class=\"media\">";
			 echo "<a class=\"thumbnail pull-left\" href=\"#\"><img class=\"media-object\" src=\"images/webgate_logo_dark_sm.png\"></img></a>";
				echo "<div class=\"media-body\">";
					echo "<span style =\"color: #0086aa; font-weight: bold; font-size: 1.5 em\"><h4 class=\"media-heading\"><span style =\"color: #0086aa; font-weight: bold; font-size: 1.5 em\">Your Business Is Featured Here!</h4></span>";
					echo "<span style =\"color: #333; font-size: .9em;\"><p>Webgate is a great place to get your business known anywhere in Davao region or the whole world. So, want your company featured here for a month or more? Contact: administrator@davaowebgate.com</p></span>";
					echo "<span class=\"pull-right\" style = \"color: #999; font-size: .9em; margin-top: 0;\"><p>Avail now! We only have limited slots.</p></span>";
				echo "</div>";
			echo "</li>";
	 
	 }
?>
   </ul>
  </div>
  
</div><!--panel left 2-->