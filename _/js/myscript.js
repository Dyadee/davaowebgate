	$(document).ready(function(){
		//BEGIN SHOWING/HIDING OPTIONS FOR PRODUCTS OR SERVICES
		$('#productORservice').show();
		$('#businessTypeProducts').hide();
		$('#businessTypeServices').hide();
		
		if($('input#products').attr("checked")){
   	        $('#productORservice').hide();
			$('#businessTypeProducts').show();
			$('#businessTypeServices').hide();
		}
		if($('input#services').attr("checked")){
   	        $('#productORservice').hide();
			$('#businessTypeProducts').hide();
			$('#businessTypeServices').show();
		}
		
		$("#products").click(function(){
			$('#productORservice').hide();
			$('#businessTypeProducts').show();
			$('#businessTypeServices').hide();
		});
		$("#services").click(function(){
			$('#productORservice').hide();
			$('#businessTypeProducts').hide();
			$('#businessTypeServices').show();
		});		
		
		//END SHOWING/HIDING OPTIONS FOR PRODUCTS OR SERVICES
		
		//TABS AND CAROUSEL
		 $(function () {
            $('.nav-tabs a:first').tab('show');
        });
        $('#myCarousel').carousel({
			interval: 4500
		});
		//END TABS AND CAROUSEL
		
		//BEGIN JQUERY VALIDATION FOR USER REGISTRATION AND USER UPDATES
		$("#firstName").blur(function(){
			if($("#firstName").val()==''|| $("#firstName").val().length < 3){
				$("#firstName+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please provide your first name</div>');
			}else {
				$("#firstName+div.text-danger").remove();
			}
		});
		$("#lastName").blur(function(){
			if($("#lastName").val()==''|| $("#lastName").val().length < 3){
				$("#lastName+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please provide your last name</div>');
			}else {
				$("#lastName+div.text-danger").remove();
			}
		});
		$("#userPhone").blur(function(){
			if($("#userPhone").val()==''){
				$("#userPhone+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please provide a phone number</div>');
			}else if($("#userPhone").val()!=''){
				$("#userPhone+div.text-danger").remove();
				var regexPhone = /^((\(?\d{3}\)?[-\.\s]?\d{3}[-\.\s]?\d{4}\,?\s?)+?|([0-9]{3}-[0-9]{4}\,?\s?)+?|([0-9]{11}\,?\s?)+?|([0-9]{4}-[0-9]{7}\,?\s?)+?)+?$/;
				//var regexPhone_1 = /(^\(?\d{3}\)?[-\.\s]?\d{3}[-\.\s]?\d{4}\,?\s?)+/; //(xxx) xxx-xxxx || xxx-xxx-xxxx ||(xxx)-xxx-xxxx
				// var regexPhone_2 = /(^[0-9]{3}-[0-9]{4}\,?\s?)+/; // xxx-xxxx
				// var regexPhone_3 = /(^[0-9]{11}\,?\s?)+/; // xxxxxxxxxxx
				// var regexPhone_4 = /(^[0-9]{4}-[0-9]{7}\,?\s?)+/; //xxxx-xxxxxxx
				var userPhone = $("#userPhone").val();
				
				if (!regexPhone.test(userPhone)){
					$("#userPhone+div.text-danger").remove();
					$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Invalid Phone Number</div>');
				}
				else {$("#userPhone+div.text-danger").remove();}				
				
			}else {
				$("#userPhone+div.text-danger").remove();
			}
		});
		$("#userFax").blur(function(){
			if($("#userFax").val()!=''){
				$("#userFax+div.text-danger").remove();
				var regexFax = /^((\(?\d{3}\)?[-\.\s]?\d{3}[-\.\s]?\d{4}\,?\s?)+?|([0-9]{3}-[0-9]{4}\,?\s?)+?|([0-9]{11}\,?\s?)+?|([0-9]{4}-[0-9]{7}\,?\s?)+?)+?$/;
				//var regexPhone_1 = /(^\(?\d{3}\)?[-\.\s]?\d{3}[-\.\s]?\d{4}\,?\s?)+/; //(xxx) xxx-xxxx || xxx-xxx-xxxx ||(xxx)-xxx-xxxx
				// var regexPhone_2 = /(^[0-9]{3}-[0-9]{4}\,?\s?)+/; // xxx-xxxx
				// var regexPhone_3 = /(^[0-9]{11}\,?\s?)+/; // xxxxxxxxxxx
				// var regexPhone_4 = /(^[0-9]{4}-[0-9]{7}\,?\s?)+/; //xxxx-xxxxxxx
				var userFax = $("#userFax").val();				
				if (!regexFax.test(userFax)){
					$("#userFax+div.text-danger").remove();
					$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Invalid Fax Number</div>');
				}
				else {$("#userFax+div.text-danger").remove();}				
				
			}else {
				$("#userFax+div.text-danger").remove();
			}
		});
		$("#userMail").blur(function(){
			if($("#userMail").val()==''){
				$("#userMail+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please provide your email address</div>');
			}else if ($("#userMail").val()!='') {
				$("#userMail+div.text-danger").remove();
				var regexMail = /^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+([;.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/;
				var email = $("#userMail").val();				
				if (!regexMail.test(email)){
					$("#userMail+div.text-danger").remove();
					$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Invalid Email Address</div>');
				}else {$("#userMail+div.text-danger").remove();}
				
			}else {$("#userMail+div.text-danger").remove();}
			
		});
		$("#loginUserMail").blur(function(){
			if($("#loginUserMail").val()==''){
				$("#loginUserMail+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Email address required</div>');
			}else if ($("#loginUserMail").val()!='') {
				$("#loginUserMail+div.text-danger").remove();
				var regexMail = /^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+([;.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/;
				var email = $("#loginUserMail").val();				
				if (!regexMail.test(email)){
					$("#loginUserMail+div.text-danger").remove();
					$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Invalid Email Address</div>');
				}else {$("#loginUserMail+div.text-danger").remove();}
				
			}else {$("#loginUserMail+div.text-danger").remove();}
			
		});
		$("#loginUserPassword").blur(function(){
			if($("#loginUserPassword").val()==''){
				$("#loginUserPassword+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please provide your password</div>');
			}else {
				$("#loginUserPassword+div.text-danger").remove();
			}
		});
		$("#inputPassword1").blur(function(){
			if($("#inputPassword1").val()=='' || $("#inputPassword1").val().length < 6){
				$("#inputPassword1+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Password must be at least 6 characters</div>');
			}else {
				$("#inputPassword1+div.text-danger").remove();
			}
		});
		$("#inputPassword2").blur(function(){
			if($("#inputPassword1").val()!='' && $("#inputPassword2").val()===''){
				$("#inputPassword2+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please retype password</div>');
			}
			else if($("#inputPassword2").val() !== $("#inputPassword1").val()) {
				$("#inputPassword2+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Passwords must match</div>');
			}
			else {$("#inputPassword2+div.text-danger").remove();}
		});
		//END JQUERY VALIDATION FOR USER REGISTRATION AND USER UPDATES
		
		//BEGIN JQUERY VALIDATION FOR BUSINESS REGISTRATION AND BUSINESS UPDATES
		$("#businessName").blur(function(){
			if($("#businessName").val()==''|| $("#businessName").val().length < 3){
				$("#businessName+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please provide the name of your business.</div>');
			}else {
				$("#businessName+div.text-danger").remove();
			}
		});
		$("#businessAddress").blur(function(){
			if($("#businessAddress").val()==''|| $("#businessAddress").val().length < 3){
				$("#businessAddress+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please provide an address for your business.</div>');
			}else {
				$("#businessAddress+div.text-danger").remove();
			}
		});
		$("#businessPhone").blur(function(){
			if($("#businessPhone").val()==''){
				$("#businessPhone+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please provide a phone number</div>');
			}else if($("#businessPhone").val()!=''){
				$("#businessPhone+div.text-danger").remove();
				var regexPhone = /^((\(?\d{3}\)?[-\.\s]?\d{3}[-\.\s]?\d{4}\,?\s?)+?|([0-9]{3}-[0-9]{4}\,?\s?)+?|([0-9]{11}\,?\s?)+?|([0-9]{4}-[0-9]{7}\,?\s?)+?)+?$/;
				var businessPhone = $("#businessPhone").val();				
				if (!regexPhone.test(businessPhone)){
					$("#businessPhone+div.text-danger").remove();
					$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Invalid Phone Number</div>');
				}
				else {$("#businessPhone+div.text-danger").remove();}				
				
			}else {
				$("#businessPhone+div.text-danger").remove();
			}
		});
		$("#businessFax").blur(function(){
			if($("#businessFax").val()!=''){
				$("#businessFax+div.text-danger").remove();
				var regexFax = /^((\(?\d{3}\)?[-\.\s]?\d{3}[-\.\s]?\d{4}\,?\s?)+?|([0-9]{3}-[0-9]{4}\,?\s?)+?|([0-9]{11}\,?\s?)+?|([0-9]{4}-[0-9]{7}\,?\s?)+?)+?$/;
				var businessFax = $("#businessFax").val();				
				if (!regexFax.test(businessFax)){
					$("#businessFax+div.text-danger").remove();
					$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Invalid Fax Number</div>');
				}
				else {$("#businessFax+div.text-danger").remove();}				
				
			}else {
				$("#businessFax+div.text-danger").remove();
			}
		});
		$("#businessEmail").blur(function(){
			if($("#businessEmail").val()==''){
				$("#businessEmail+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please provide your business email address</div>');
			}else if ($("#businessEmail").val()!='') {
				$("#businessEmail+div.text-danger").remove();
				var regexMail = /^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+([;.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/;
				var email = $("#businessEmail").val();				
				if (!regexMail.test(email)){
					$("#businessEmail+div.text-danger").remove();
					$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please supply a valid email address.</div>');
				}else {$("#businessEmail+div.text-danger").remove();}
				
			}else {$("#businessEmail+div.text-danger").remove();}
			
		});
		$("#businessDescription").blur(function(){
			if($("#businessDescription").val()==''|| $("#businessDescription").val().length < 3){
				$("#businessDescription+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please provide a short description of your business.</div>');
			}else {
				$("#businessDescription+div.text-danger").remove();
			}
		});
		$("#businessTags").blur(function(){
			if($("#businessTags").val()==''|| $("#businessTags").val().length < 3){
				$("#businessTags+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Don\'t leave this empty. It will help users find your business.</div>');
			}else {
				$("#businessTags+div.text-danger").remove();
			}
		});
		//END JQUERY VALIDATION FOR BUSINESS REGISTRATION AND BUSINESS UPDATES
	
		//BEGIN JQUERY VALIDATION FOR ITEM POSTING
		$("#itemTitle").blur(function(){
			if($("#itemTitle").val()==''|| $("#itemTitle").val().length < 3){
				$("#itemTitle+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please provide the name of your item.</div>');
			}else {
				$("#itemTitle+div.text-danger").remove();
			}
		});
		
		$("#itemPrice").blur(function(){
			if($("#itemPrice").val()==''){
				$("#itemPrice").parent().next().remove();
				$(this).parent().after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please provide a price tag</div>');
			}else if($("#itemPrice").val()!=''){
				$("#itemPrice").parent().next().remove();
				var regexPrice = /^(\d{1,3}\,)*(\d{1,3})?(\.\d{2})?$/;
				var itemPrice = $("#itemPrice").val();				
				if (!regexPrice.test(itemPrice)){
					$("#itemPrice").parent().next().remove();
					$(this).parent().after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Invalid Price</div>');
				}
				else {$("#itemPrice").parent().next().remove();}				
				
			}else {
				$("#itemPrice").parent().next().remove();
			}
		});
		
		$("#itemContactInfo").blur(function(){
			if($("#itemContactInfo").val()==''|| $("#itemContactInfo").val().length < 3){
				$("#itemContactInfo+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please provide your contact info.</div>');
			}else {
				$("#itemContactInfo+div.text-danger").remove();
			}
		});
		
		$("#itemDescription").blur(function(){
			if($("#itemDescription").val()==''|| $("#itemDescription").val().length < 3){
				$("#itemDescription+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please provide a description.</div>');
			}else {
				$("#itemDescription+div.text-danger").remove();
			}
		});
		
		$("#itemTags").blur(function(){
			if($("#itemTags").val()==''|| $("#itemTags").val().length < 3){
				$("#itemTags+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Don\'t leave this empty. It will help users find your item.</div>');
			}else {
				$("#itemTags+div.text-danger").remove();
			}
		});
		//END JQUERY VALIDATION FOR ITEM POSTING
		$("#tabs").tabs({collapsible:true}, { hide: { effect: "fade", duration: 200 } }, { show: { effect: "fade", duration: 200 } }, { heightStyle: "contents" });
		$("#tabContents").click(function(){
			$("this").hide();
		});
		
		$(function(){
			 $('#itemFrameDescription').focus();
			 $('#bold').click(function(){document.execCommand('bold', false, null);	$('#itemFrameDescription').focus();	$("#itemDescription").val($("#itemFrameDescription").html().trim());return false;});
			 $('#italic').click(function(){document.execCommand('italic', false, null);$('#itemFrameDescription').focus();$("#itemDescription").val($("#itemFrameDescription").html().trim());return false;});
			 $('#underline').click(function(){document.execCommand('underline', false, null);$('#itemFrameDescription').focus();$("#itemDescription").val($("#itemFrameDescription").html().trim());return false;});
			 $('#unorderedlist').click(function(){document.execCommand('InsertUnorderedList', false, null);$('#itemFrameDescription').focus();$("#itemDescription").val($("#itemFrameDescription").html().trim());return false;});
			 $('#orederedlist').click(function(){document.execCommand('InsertOrderedList', false, null);$('#itemFrameDescription').focus();$("#itemDescription").val($("#itemFrameDescription").html().trim());return false;});
			 $('#undo').click(function(){document.execCommand('Undo', false, null);$('#itemFrameDescription').focus();$("#itemDescription").val($("#itemFrameDescription").html().trim());return false;});
			 $('#refresh').click(function(){$('#itemFrameDescription').focus();			 
			 	$("#itemDescription").val("");
			 	$("#itemFrameDescription").empty();
			 	return false;
			 });
		}); 
		
		$("#itemFrameDescription").keyup(function(){
			$("#itemDescription").val($("#itemFrameDescription").html().trim());
			return false;			
		});
		
		//BEGIN JQUERY VALIDATION FOR Private Message
		$("#MessageSubject").blur(function(){
			if($("#MessageSubject").val()==''|| $("#MessageSubject").val().length < 3){
				$("#MessageSubject+div.text-danger").remove();
				$(this).after('<div class =\"text-danger\" style = \"margin-top: 2px;\">* Please provide a subject for your message.</div>');
			}else {
				$("#MessageSubject+div.text-danger").remove();
			}
		});
		//END JQUERY VALIDATION FOR Private Message
		$(function(){
			 $('#privateMessageContentFrame').focus();
			 $('#ibold').click(function(){document.execCommand('bold', false, null);	$('#privateMessageContentFrame').focus();	$("#privateMessageContent").val($("#privateMessageContentFrame").html().trim());return false;});
			 $('#iitalic').click(function(){document.execCommand('italic', false, null);$('#privateMessageContentFrame').focus();$("#privateMessageContent").val($("#privateMessageContentFrame").html().trim());return false;});
			 $('#iunderline').click(function(){document.execCommand('underline', false, null);$('#privateMessageContentFrame').focus();$("#privateMessageContent").val($("#privateMessageContentFrame").html().trim());return false;});
			 $('#iunorderedlist').click(function(){document.execCommand('InsertUnorderedList', false, null);$('#privateMessageContentFrame').focus();$("#privateMessageContent").val($("#privateMessageContentFrame").html().trim());return false;});
			 $('#iorederedlist').click(function(){document.execCommand('InsertOrderedList', false, null);$('#privateMessageContentFrame').focus();$("#privateMessageContent").val($("#privateMessageContentFrame").html().trim());return false;});
			 $('#iundo').click(function(){document.execCommand('Undo', false, null);$('#privateMessageContentFrame').focus();$("#privateMessageContent").val($("#privateMessageContentFrame").html().trim());return false;});
			 $('#irefresh').click(function(){$('#privateMessageContentFrame').focus();			 
			 	$("#itemDescription").val("");
			 	$("#privateMessageContentFrame").empty();
			 	return false;
			 });
		}); 
		
		$("#privateMessageContentFrame").keyup(function(){
			$("#privateMessageContent").val($("#privateMessageContentFrame").html().trim());
			return false;			
		});
		
	
	});//END document.ready(function(){});
	
	function getImage(itemID, index){ //when logged in
			var spinner = '<image src="images/ajax-loading_big.gif" width = "100" height = "100" />';
			var Item = "#imageResult_"+itemID;
			$.post('imageRequest.php', {itemID: itemID, imageRequest: index}, function(output){
				
				$(Item).html(spinner).show();
				$(Item).html(output).fadeIn();
				//output.preventDefault();
		
			});
		}
		
	function getImages(itemID, userID, index){ //when not logged in
				var spinner = '<image src="images/ajax-loading_big.gif" width = "100" height = "100" />';
				var Item = "#imageResult_"+itemID;
			$.post('imageRequest_not_logged.php', {itemID: itemID, userID: userID, imageRequest: index}, function(output){
		
				$(Item).html(spinner).show();
				$(Item).html(output).fadeIn();
				
			});
		}

	
		
		

    
