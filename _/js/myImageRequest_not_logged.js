function getImages(itemID, userID, index){
		var spinner = '<image src="images/ajax-loading_big.gif" width = "100" height = "100" />';
		var Item = "#imageResult_"+itemID;
	$.post('imageRequest_not_logged.php', {itemID: itemID, userID: userID, imageRequest: index}, function(output){

		$(Item).html(spinner).show();
		$(Item).html(output).fadeIn();
		// output.preventDefault();
	});
}


