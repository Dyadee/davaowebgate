<?php require_once("_/components/includes/class/session.php"); ?> <!--Initializes the object $session-->
<?php require_once("_/components/includes/functions.php"); ?>
<?php include("_/components/includes/header.php");?>
<?php $session->confirm_logged_in(); ?>
<aside class = "col-lg-3">
	<h4>What would you like to do?</h4>
	<ul class = "nav nav-pills nav-stacked">
		<li><a href="member.php">My Account Manager</a></li>
		<li><a href="businessView.php">View My Business List</a></li>
		<li><a href="#">View My Job Posts</a></li>
		<li><a href="itemView.php">View My Items</a></li>
		<li><a href="businessRegistration.php">Add a Business List</a></li>
		<li class = "active"><a href="#">Post a Job</a></li>
		<li><a href="marketplacePost.php">Sell an Item</a></li>
		<li><a href="userUpdate.php">Edit Account</a></li>
		<li><a href="loginUpdate.php">Change Login Information</a></li>
		<li><a href="logout.php">Logout</a></li>
	</ul>
</aside>
<section class="col col-lg-8">
<form class="form-horizontal" role="form" action="businessRegistration.php?done=1" enctype="multipart/form-data" method="post">
	<legend>Enlist a new Job Post</legend>
	  <div class="panel panel-info">
  <!-- Default panel contents -->
  <div class="panel-heading">Job Information</div>
  <div class="panel-body">
  <div class="form-group">
    <label for="jobTitle" class="col-sm-3 control-label">Job Title</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="jobTitle" placeholder="Job Title">
    </div>
  </div><!--Job title-->

 <div class="form-group">
    <label for="jobCategory" class="col-sm-3 control-label">Job Category</label>
    <div class="col-sm-8">
      <select class="form-control" id="jobCategory">
		<option>-- Select Job Category --</option>
			<option>Accountants</option>
			<option>Administrative/HR</option>
			<option>Advertising</option>
			<option>Architect</option>
			<option>Armed Forces</option>
			<option>Arts</option>
			<option>Audit & Taxation</option>
			<option>Automotive</option>
			<option>Aviation</option>
			<option>Banking/Financial</option>
			<option>Biotechnology</option>
			<option>Chemistry</option>
			<option>Construction</option>
			<option>Consultant</option>
			<option>Contract/Freelance</option>
			<option>Customer Service</option>
			<option>Design</option>
			<option>Education</option>
			<option>Instructor</option>
			<option>Insurance</option>
			<option>Interior Designer</option>
			<option>IT Professional</option>
			<option>Journalist</option>
			<option>Law/Legal Service</option>
			<option>Logistics</option>
			<option>Maintenance</option>
			<option>Management</option>
			<option>Manufacturing</option>
			<option>Media/Comm</option>
			<option>Medical</option>
			<option>Merchandising</option>
			<option>NGOs</option>
			<option>Nurse</option>
			<option>Office Assistant</option>
			<option>Others/Misc</option>
			<option>Personal Care</option>
			<option>Pharmacy</option>
			<option>Process Control</option>
			<option>Professor</option>
			<option>Public Relations</option>
			<option>Publishing</option>
			<option>Purchasing</option>
			<option>Quality Control</option>
			<option>Quantity Survey</option>
			<option>Real Estate</option>
			<option>Research</option>
			<option>Sales/Marketing</option>
			<option>Science & Tech</option>
			<option>Sciences</option>
			<option>Secretarial</option>
			<option>Skilled Labor</option>
			<option>Social Services</option>
			<option>Supervisor</option>
			<option>TeleMarketing</option>
			<option>Tourism</option>
			<option>Training & Dev</option>
			<option>Welder</option>
		</select>
	</div>
 </div><!--Job Category-->
  <div class="form-group">
    <label for="jobDescription" class="col-sm-3 control-label">Job Description</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="jobDescription" placeholder="Job Description">
    </div>
  </div><!--Job Description-->
  
  <div class="form-group">
    <label for="jobQualification" class="col-sm-3 control-label">Qualification</label>
    <div class="col-sm-8">
      <textarea type="textarea" col = "10" rows = "10"class="form-control" id="jobQualification"></textarea>
    </div>
  </div><!--Job Qualification-->
  <div class="form-group">
    <label for="jobRequirements" class="col-sm-3 control-label">Requirements</label>
    <div class="col-sm-8">
      <textarea type="textarea" col = "10" rows = "10"class="form-control" id="jobRequirements"></textarea>
    </div>
  </div><!--Job Requirements-->
  <div class="form-group">
    <label for="companyInfo" class="col-sm-3 control-label">Company Info</label>
    <div class="col-sm-8">
      <textarea type="textarea" col = "10" rows = "10"class="form-control" id="companyInfo"></textarea>
    </div>
  </div><!--Company Information-->
  <div class="form-group">
    <label for="jobTags" class="col-sm-3 control-label">Job Tags <span class = "glyphicon glyphicon-question-sign"></span></label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="jobTags" placeholder= "Keywords related to your job post"></input>
    </div>
  </div><!--Job Tags-->
  </div>
</div><!-- Panel Business Information -->

 <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
      <div class="checkbox">
        <label>
          <input type="checkbox"> I have read the <a href="terms.php">Terms and Conditions</a>.
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div align = "center">
      <button type="submit" class="btn btn-danger"><span class = "glyphicon glyphicon-ok"></span> Post this Job</button>&nbsp;&nbsp;&nbsp;
      <a href="member.php" class="btn btn-info"><span class = "glyphicon glyphicon-ban-circle"></span> Cancel</a>
    </div>
  </div>

</form>
</section>


<?php include("_/components/includes/footer.php");?>