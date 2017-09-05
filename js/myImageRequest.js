function getImage(itemID, index){

	$.post('imageRequest.php', {itemID: itemID, imageRequest: index}, function(output){

		var Item = "#imageResult_"+itemID;
		$(Item).html('<image src="images/ajax-loading_big.gif" width = "100" height = "100" />').show();
		$(Item).html(output).fadeIn();

	});

	
	// var itemID = itemID;
	// var imageRequest = index;
	// var spinner = '<image src="images/ajax-loading_big.gif" width = "100" height = "100" />';
	// var Item = "#imageResult_"+itemID;
	// // var output = $("#output");
	// var url = "imageRequest.php";
	
	// $.ajax({

	// 		beforeSend: function(){
	// 			$(Item).html(spinner)
	// 		},
	// 		url: url,
	// 		type: "POST",
	// 		success: function(){
	// 			$(Item).html(spinner);
	// 		}
	// 	});

}
