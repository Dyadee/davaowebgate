
<!DOCTYPE html>
<html>
  <head>
    <title><?php 
				if (isset($title)){echo $title;}
				else echo "Davao City Premiere Online Directory - Davao Webgate";
			?></title>
  <meta charset = "utf-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name = "keywords" content = "davao city, davao hotels, davao hotel, davao directory, davao directory, davao, webgate, directory, directory, davao city, eagle, buy, sell, jobs, job, post, postings, kadayawan, festival, festival, kadayawan, internet directory, products, services, philippines, filipino">
	<meta name = "description" content = "Davao Webgate is an online directory of businesses or institutions who either sell products or offer services within Davao City. It is the most comprehensive, user friendly, free online directory of Davao available around.Davao Webgate IS free! You don't need the hassle of paying in order for your business to get online. All you need to do is Sign Up & let Davao Webgate post your business on the list.">
	   
     <link rel="stylesheet" type="text/css" href="_/css/ui-lightness/jquery-ui-1.10.4.css" >
    <link href="_/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="_/css/mystyles.css" rel="stylesheet" media="screen">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">    
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-536dbef37bdde115"></script>
   
    <!--[if lt IE 9]>
      <script src="_js/html5shiv.js"></script>
      <script src="_/js/respond.js"></script>      
    <![endif]-->
   </head>
  <body id="home">
    
<section class="container">
  <div class="content row">
<div class="row">
	<div class="col-lg-12">
		<header class="clearfix">
			<section id="branding" style="background-color:#bb4b3a">
				<a href="index.php"><img src="images/webgate_logo.png" alt="Davao Webgate Logo"></a>
				<img class="pull-right hidden-xs" src="images/online_directory.png" alt="Davao Webgate tagline">
				
			</section><!--branding-->
		</header><!--header-->
	</div><!--col-lg-12-->
</div><!--crow-->
<nav class="navbar navbar-default" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="index.php"><span style = "font-size: .9em;">Davao Webgate</span></a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    
    <form class="navbar-form navbar-right" role="search" action = "search.php" method = "post">
      <div class="form-group">
        <input type="text" class="form-control" name = "searchQuery" placeholder="I am Looking for..."> in category
        <select class="form-control" name="searchCategory">
          <option value="">--SELECT--</option>
          <option value="Products">Products : Business List</option>
          <option value="Services">Services : Business List</option>
          <option value="Marketplace">Marketplace</option>
        </select>
      </div>
      <button name = "queryWebgate" type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-search"></span> Search</button>
    </form>
    <ul class="nav navbar-nav navbar-left">
        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categories<b class="caret"></b></a>
        <ul class="dropdown-menu">        	 
        	<?php 
        		$businessType = Business::find_by_randomProduct();
				if(!empty($businessType)){
					$businessType_array = get_object_vars($businessType[0]);
					$businessTypeProduct = $businessType_array['businessType'];
					$product = urlencode($businessTypeProduct);
				}				
			?>     	
          <li><a href="Products.php?type=<?php echo "$product";?>">Products - <em>Business Listings</em></a></li>
          <?php 
        		$businessType = Business::find_by_randomService();
				if(!empty($businessType)){
					$businessType_array = get_object_vars($businessType[0]);
					$businessTypeService = $businessType_array['businessType'];
					$service = urlencode($businessTypeService);
				}				
			?>          
          <li><a href="Services.php?type=<?php echo "$service";?>">Services - <em>Business Listings</em></a></li>
          <?php 
        		$itemRandomCategory = Item::find_by_randomItemCategory();
				if(!empty($itemRandomCategory)){
					$itemCategory_array = get_object_vars($itemRandomCategory[0]);
					$itemRandomType = $itemCategory_array['itemCategory'];
					$itemRandom = urlencode($itemRandomType);
				}				
			?> 
          <li><a href="Marketplace.php?category=<?php echo "$itemRandom";?>">Marketplace</a></li>
          <li><a href="#">Job Finder <span style="font-size: .8em;"><b><em>(soon!)</em></b></span></a></li>
        </ul>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-left">
        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Actions<b class="caret"></b></a>
        <ul class="dropdown-menu">
        	<li><a href="member.php"><span class="glyphicon glyphicon-user" style="font-size: .9em;"></span>  My Account</a></li>
        	<li class="divider"></li>
          <li><a href="businessRegistration.php">Add my Business</a></li>          
          <li><a href="Marketplace.php?category=<?php echo "$itemRandom";?>">Buy Items</a></li>
          <li><a href="marketplacePost.php">Sell an Item</a></li>
          <li><a href="#">Find a Job <span style="font-size: .8em;"><b><em>(soon!)</em></b></span></a></li>
          <?php if(isset($_SESSION['userID'])){
          
	          	echo '<li class="divider"></li>';
	          	echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>';
          	
          }?>
          
        </ul>
      </li>
    </ul>
    <ul class="nav navbar-nav">
       <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-list"></span> Articles <b class="caret"></b></a>
        <ul class="dropdown-menu">
        	<li><a href="#">About Davao</a></li>
          <li><a href="#">Kadayawan Festival</a></li>
          <li><a href="#">Durian Fruit</a></li>
          <li><a href="#">Waling-waling</a></li>               
          <li class="divider"></li>
          <li><a href="#">Tourist Spots</a></li>
        </ul>
      </li>
    </ul>
  </div><!-- /.navbar-collapse -->

</nav>