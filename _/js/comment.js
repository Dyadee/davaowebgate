$(document).ready(function(){
//when the user clicks the link, pass to a function paramenters to inititate the values to be used in 
//this entire ajax application //!!IMPORTANT

var itemID = 10;

function readComments(itemID){		
		$.post('processComment.php', {itemID: itemID, method: 'readComments'}, function(data){
		$("#comments").html(data);

	});
}//END FUNCTION readComments

function insertComment(itemID, comment, userID){		
		$.post('processComment.php', {itemID: itemID, comment: comment, userID: userID, method: 'insertComment'}, function(){
			readComments(itemID);		
		$(".commentEntry").val('');
	});
}//END FUNCTION insertComments

$(".commentEntry").bind('keydown', function(e){
		if(e.keyCode === 13 && e.shiftKey === false){
			// insertComment(itemID, $(this).val(), userID);
			insertComment(itemID, $(this).val(), 1);
			e.preventDefault();
		}
	});
	
function repeatCall(){
	readComments(itemID);
	return itemID;
}

setInterval(repeatCall, 2000);
});//END document.ready(function(){});
	

    
