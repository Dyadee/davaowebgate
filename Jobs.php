<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require_once("_/components/includes/functions.php"); ?>
<?php require_once("_/components/includes/class/business.php"); ?>
<?php require_once("_/components/includes/class/item.php"); ?>
<?php $session->confirm_logged_in_index(); ?>
    <?php 
		if(isset($_GET['type'])){
			$item = $_GET['type'];
		}
		$title = "Search Job Opportunities: $item in Davao City - Davao Webgate";
	
	?>
	<?php include("_/components/includes/header.php");?>
    <?php include("_/components/includes/carousel.php");?>
    <section class="main col col-lg-12">
      &nbsp;
      <?php include("_/components/includes/tabbed_options_query.php");?>
 <div class = "clearfix"></div>
       &nbsp;
       <div class="col col-lg-6 col-md-6 col-sm-12 col-xs-12">
       <?php include("_/components/includes/featured_listing.php");?>
       </div>
       <div class="col col-lg-5 col-md-5 col-sm-12 col-xs-12">

  <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">Latest Items</h3>
      </div>
      <div class="panel-body similarANDlatest">
        
           <ul class="media-list">
            <?php //BEGIN LATEST ITEM QUERY
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
                    echo"<div class=\"col col-lg-6 col-md-6 col-sm-6  col-xs-6\">";//BEGIN PLACEHOLDER FOR ITEM IMAGE
                      //BEGIN FOR ITEM IMAGE USE
                        $hashedUserID = hash('sha256', $latestItemDetails->userID);
                        $hashedItemID = hash('sha256', $latestItemDetails->itemID);       
                        $directory = "uploads/$hashedUserID/Items/$hashedItemID";
                        $files = scandir($directory);
                        $excluded = array('.','..');
                        $result_files = array_diff($files, $excluded);
                        
                        $thumbnail = array();
                        $fullsize = array();
                          foreach ($result_files as $key => $value) {
                            $thumb = strpos($value, "thumb_");                
                            if($thumb===0){                 
                               $thumbnail[] = $value;
                               //echo "$value<br />";
                            }else if($thumb!==0){                 
                              $fullsize[] = $value;
                              //echo "$value<br />";              
                            }                     
                          }
                        if(!empty($result_files)){
                          echo"<a class=\"thumbnail\" href=\"itemDetailed.php?category=".urlencode($latestItemDetails->itemCategory)."&itemID=".$latestItemDetails->itemID."\"><img src=\"$directory/$thumbnail[0]\"/></a>";
                        }else {
                          echo"<a class=\"thumbnail\" href=\"#\"><img src=\"images/webgate_logo_gray.png\"/></a>";
                        }
                       //END FOR ITEM IMAGE USE
                        echo"</div>";// END PLACEHOLDER FOR ITEM IMAGE  
                       echo "<div class=\"media-body\">";
                        echo "<span style =\"color: #0086aa;\"><h5 class=\"media-heading\">".$itemTitle."</h5></span>";
                        echo "<span style =\"color: #363636; font-size: .8em;\"><p><b>Php</b> ".$latestItemDetails->itemPrice."</p></span>";
                        echo "<span style = \"color: #999; font-size: .8em;\"><p>".$latestItemDetails->itemCategory."</p></span>";
                        date_default_timezone_set('Asia/Manila');           
                        $timestamp1 = date("j F Y | g:i A", $latestItemDetails->itemPostDate);
                        echo "<span style = \"color: #999; font-size: .7em; margin-top: 0;\"><p>".$timestamp1."</p></span>";          
                      echo "</div>";
                        
                    echo "</li>";
                      
                }//END FOREACH
              }else{echo "No latest Items exist in the Database";}

          //END LATEST ITEM QUERY ?>
           </ul><!-- class media-list -->

      </div><!--panel body-->  
    </div><!--panel panel-info-->
       </div>
    </section><!--main-->
    <?php include("_/components/includes/footer_jobs.php");?>
