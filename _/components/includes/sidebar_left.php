<section class="sidebar col col-lg-3 col-md-3 col-sm-12">
      &nbsp;
	<div class="panel panel-info hidden-sm hidden-xs">
		<div class="panel-heading">
			<h3 class="panel-title">Latest News</h3>
		</div>
	<div class="panel-body">
		<div style="border-style: none;border-width: 0;border-color: #FFFFFF;width: 100%;height: 440px;overflow: auto;">
			<div id="newsblock36294041" style="word-wrap: break-word; padding: 5px; background-color: #FFFFFF;">
				<!-- DO NOT ALTER, REMOVE, OR IN ANY WAY TRY TO HIDE THE FOLLOWING TAG OR ITS CONTENTS OR BLASTCASTA WILL NOT FUNCTION PROPERLY. -->
				<div align="center" style="font-size: 8pt;"><br /><a href="http://www.blastcasta.com/" style="text-decoration: none; color: #0086aa;" target="_top">
					<b>News Widgets &amp; Tickers</b><br />Powered by BlastCasta</a>
				</div>
			</div>
		</div>
		<script id="scrnewsblock36294041" type="text/javascript"></script>
		<script type="text/javascript"> /* <![CDATA[ */ 
		setTimeout('document.getElementById(\'scrnewsblock36294041\').src = (document.location.protocol == \'https:\' ? \'https\' : \'http\') + \'://www.poweringnews.com/newsjavascript.aspx?feedurl=http%3A//www.mindanews.com/feed/&maxitems=-1&showfeedtitle=0&showtitle=1&showdate=1&showsummary=1&showauthor=0&showactionsbox=0&showrsslink=0&showcopyright=1&opennewwindow=0&inheritstyles=0&bgcolor=%23FFFFFF&titlefontsize=9&summaryfontsize=8&fontfamily=Trebuchet%20MS&titlecolor=%230086aa&summarycolor=%23363636&sepstyle=none&sepcolor=%23FFC428&objectid=newsblock36294041\'', 500);
		/* ]]> */ </script>
	</div><!--panel left 1-->
	</div><!--Something with the parent div-->

 <div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Latest Listings</h3>
  </div>
  <div class="panel-body">
   <ul class="media-list">
		<?php
			$business = new Business();
			$businessObject = Business::find_by_latest(4);
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
										echo"<a class=\"thumbnail pull-left\" href=\"#\"><img class=\"media-object\" style = \"width: 100px; height: 100px;\" src=\"$directory/$result_dir[2]\"/></a>";
									}else {
										echo"<a class=\"thumbnail pull-left\" href=\"#\"><img class=\"media-object\" src=\"images/thumbnail_holder_sm.gif\"/></a>";
									}					
					//END PLACEHOLDER FOR LOGO
					
						echo "<div class=\"media-body\">";
							echo "<span style =\"color: #0086aa;\"><h4 class=\"media-heading\">".$businessDetails->businessName."</h4></span>";
							echo "<span style =\"color: #363636; font-size: .8em;\"><p>".substr($businessDetails->businessDescription, 0, 70)."...</p></span>";					
						echo "</div>";
							date_default_timezone_set('Asia/Manila');						
							$timestamp1 = date("D | j F Y | g:i A", $businessDetails->businessPostDate);
							echo "<span class=\"pull-right\" style = \"color: #999; font-size: .7em; margin-top: 0;\"><p><b>Date Posted:</b>"." &nbsp; ".$timestamp1."</p></span>";
					echo "</li>";
					//echo"<hr />";
				}//END FOREACH
			 }//END IF
		?>
   </ul><!-- media list -->
  </div><!-- panel-body for latest item -->
  
</div><!--panel left 2-->
</section><!--sidebar-left-->