<?php ob_start(); ?>
<?php require("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require("_/components/includes/functions.php"); ?>
<?php require("_/components/includes/class/business.php"); ?>
<?php require("_/components/includes/class/item.php"); ?>
<?php //$session->confirm_logged_in_index();?>
<?php $title = "Davao City Premiere Online Directory - Davao Webgate";?>
<?php include("_/components/includes/header.php");?>
<?php include("_/components/includes/carousel.php");?>

	<?php include("_/components/includes/sidebar_left.php");?>

<section class="main col col-lg-6 col-md-6">
		&nbsp;
	<?php include("_/components/includes/tabbed_options.php");?>
	<!-- AddThis Button BEGIN -->
	<div class="addthis_toolbox addthis_default_style">
		<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
		<a class="addthis_button_tweet"></a>
		<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
		<a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal" pi:pinit:url="http://www.addthis.com/features/pinterest" pi:pinit:media="http://www.addthis.com/cms-content/images/features/pinterest-lg.png"></a>
		<a class="addthis_button_linkedin_counter"></a>
		<a class="addthis_counter addthis_pill_style"></a>
	</div>
	<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-536dbef37bdde115"></script>
	<!-- AddThis Button END -->
	&nbsp;
	<?php include("_/components/includes/featured_listing.php");?>
</section><!--main-->

<?php include("_/components/includes/sidebar_right.php");?>
<?php include("_/components/includes/sponsors.php");?>
<?php include("_/components/includes/footer.php");?>
<?php ob_end_flush();?>
