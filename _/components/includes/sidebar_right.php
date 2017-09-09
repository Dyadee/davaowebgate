<section class="sidebar col col-lg-3 col-md-3">
    &nbsp;
    <?php
    if (!isset($_SESSION['userID'])) {

        echo <<<'EOT'
 <div class="panel panel-primary"><!--Login Panel-->
	  <div class="panel-heading">
		<h3 class="panel-title">Login Information</h3>
	  </div>
	  <div class="panel-body">
		   <form role="form" action="login.php"  method="post">
			  <div class="form-group">
				<label for="userMail">Email address</label>
				<input type="email" class="form-control" id="loginUserMail" name = "userMail" placeholder="Enter email">
			  </div>
			  <div class="form-group">
				<label for="userPassword">Password</label>
				<input type="password" class="form-control" id="loginUserPassword" name = "userPassword" placeholder="Password">
			  </div>			  
			  <div class="form-group">
				<label>
				  <input type="checkbox" name = "remember"> Remember me
				</label>
			  </div>
			  <button type="submit" class="btn btn-success" name = "submit"><span class = "glyphicon glyphicon-log-in"></span> Login</button>
			</form>
		&nbsp;
		<section>Not yet a member? <a href="userRegistration.php" class="btn btn-warning btn-xs">Register</a></section>
	  </div>  
</div><!--Login Panel-->
EOT;
    } else {
        echo '<div class="panel panel-info">';
        echo '<div class="panel-heading">';
        echo '<h3 class="panel-title">Latest Items</h3>';
        echo '</div>';
        echo '<div class="panel-body similarANDlatest" style = "height: 552px;">';
        echo '<ul class="media-list">';
        //BEGIN LATEST ITEM QUERY
        $latestItem = new Item();
        $latestItemObject = Item::find_by_latest(3);
        if (!empty($latestItemObject)) {
            //var_dump($simlarItemObject);
            foreach ($latestItemObject as $object => $latestItemDetails) {
                echo"<li class=\"media\">";
                $t = hash("sha512", time());
                $uid = hash('sha512', $latestItemDetails->itemID);
                $q = hash('sha512', $latestItemDetails->userID);
                $_SESSION['itemTitle'] = $latestItemDetails->itemTitle;
                $itemTitle = removeslashes($latestItemDetails->itemTitle);
                echo"<div class=\"col col-lg-6 col-md-6 col-sm-6  col-xs-6\">"; //BEGIN PLACEHOLDER FOR ITEM IMAGE
                //BEGIN FOR ITEM IMAGE USE
                $hashedUserID = hash('sha256', $latestItemDetails->userID);
                $hashedItemID = hash('sha256', $latestItemDetails->itemID);
                $directory = "uploads/$hashedUserID/Items/$hashedItemID";
                $files = scandir($directory);
                $excluded = array('.', '..');
                $result_files = array_diff($files, $excluded);

                $thumbnail = array();
                $fullsize = array();
                foreach ($result_files as $key => $value) {
                    $thumb = strpos($value, "thumb_");
                    if ($thumb === 0) {
                        $thumbnail[] = $value;
                        //echo "$value<br />";
                    } else if ($thumb !== 0) {
                        $fullsize[] = $value;
                        //echo "$value<br />";							
                    }
                }
                if (!empty($result_files)) {
                    echo"<a class=\"thumbnail\" href=\"itemDetailed.php?category=" . urlencode($latestItemDetails->itemCategory) . "&itemID=" . $latestItemDetails->itemID . "\"><img src=\"$directory/$thumbnail[0]\"/></a>";
                } else {
                    echo"<a class=\"thumbnail\" href=\"#\"><img src=\"images/webgate_logo_gray.png\"/></a>";
                }
                //END FOR ITEM IMAGE USE
                echo"</div>"; // END PLACEHOLDER FOR ITEM IMAGE	
                echo "<div class=\"media-body\">";
                echo "<span style =\"color: #0086aa;\"><h5 class=\"media-heading\">" . $itemTitle . "</h5></span>";
                echo "<span style =\"color: #363636; font-size: .8em;\"><p><b>Php</b> " . $latestItemDetails->itemPrice . "</p></span>";
                echo "<span style = \"color: #999; font-size: .8em;\"><p>" . $latestItemDetails->itemCategory . "</p></span>";
                date_default_timezone_set('Asia/Manila');
                $timestamp1 = date("j F Y | g:i A", $latestItemDetails->itemPostDate);
                echo "<span style = \"color: #999; font-size: .7em; margin-top: 0;\"><p>" . $timestamp1 . "</p></span>";
                echo "</div>";

                echo "</li>";
            }//END FOREACH
        } else {
            echo "No latest Items exist in the Database";
        }



        //END LATEST ITEM QUERY
        echo"</ul>"; //<!-- class media-list
        echo "</div>"; //<!--panel body-->  
        echo "</div>"; //<!--panel panel-info-->
    }
    ?>

    <div class="panel panel-primary hidden-sm hidden-xs">
        <div class="panel-heading">
            <h3 class="panel-title">Available Jobs</h3>
        </div>
        <div class="panel-body">
            <div style="border-style: none;border-width: 0;border-color: #FFFFFF;width: 100%;height: 440px;overflow: auto;"><div id="newsblock97282976" style="word-wrap: break-word; padding: 5px; background-color: #FFFFFF;">
                    <!-- DO NOT ALTER, REMOVE, OR IN ANY WAY TRY TO HIDE THE FOLLOWING TAG OR ITS CONTENTS OR BLASTCASTA WILL NOT FUNCTION PROPERLY. --><div align="center" style="font-size: 8pt;"><br /><a href="http://www.blastcasta.com/" style="text-decoration: none; color: #00BECD;" target="_top"><b>News Widgets &amp; Tickers</b><br />Powered by BlastCasta</a></div>
                </div></div>

            <script id="scrnewsblock97282976" type="text/javascript"></script>
            <script type="text/javascript"> /* <![CDATA[ */
                setTimeout('document.getElementById(\'scrnewsblock97282976\').src = (document.location.protocol == \'https:\' ? \'https\' : \'http\') + \'://www.poweringnews.com/newsjavascript.aspx?feedurl=http%3A//job-search.jobstreet.com.ph/philippines/job-rss.php%3Farea%3D1%26option%3D1%26state%3DSM%26job-source%3D1%252C64%26classified%3D1%26job-posted%3D0%26src%3D5%26pg%3D1%26sort%3D1%26order%3D0%26srcr%3D5&maxitems=-1&showfeedtitle=0&showtitle=1&showdate=1&showsummary=1&showauthor=0&showactionsbox=0&showrsslink=0&showcopyright=1&opennewwindow=0&inheritstyles=0&bgcolor=%23FFFFFF&titlefontsize=10&summaryfontsize=8&fontfamily=Arial%2CHelvetica&titlecolor=%2300BECD&summarycolor=%23000000&sepstyle=dashed&sepcolor=%23F7BA00&objectid=newsblock97282976\'', 500);
                /* ]]> */</script>

        </div>
    </div><!--panel 2-->
</section><!--sidebar-->