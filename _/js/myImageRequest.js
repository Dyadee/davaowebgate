function getImage(itemID, index){
	var spinner = '<image src="images/ajax-loading_big.gif" width = "100" height = "100" />';
	var Item = "#imageResult_"+itemID;
	$.post('imageRequest.php', {itemID: itemID, imageRequest: index}, function(output){
		
		$(Item).html(spinner).show();
		$(Item).html(output).fadeIn();
		output.preventDefault();

	});
}
