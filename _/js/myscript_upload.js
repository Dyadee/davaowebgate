	$(document).ready(function(){
		
	
	//BEGIN AJAX FORM UPLOAD PROGRESS
	var progressbox     = $('#progressbox');
    var progressbar     = $('#progressbar');
    var statustxt       = $('#statustxt');
    var submitbutton    = $("#SubmitButton");
    var myform          = $("#UploadForm");
    var output          = $("#output");
    var completed       = '0%';

    $(myform).ajaxForm({
	
        beforeSend: function() { //BEFORE SENDING FORM
			submitbutton.attr('disabled', ''); // disable upload button
			statustxt.empty();
			//progressbox.slideDown(); //show progressbar
			progressbar.width(completed); //initial value 0% of progressbar
			statustxt.html(completed); //set status text
			statustxt.css('color','#000'); //initial color of status text
        },
        uploadProgress: function(event, position, total, percentComplete) { //ON PROGRESS
			progressbar.width(percentComplete + '%') //update progressbar percent complete
			statustxt.html(percentComplete + '%'); //update status text
			if(percentComplete>50){
				statustxt.css('color','#fff'); //change status text to white after 50%
			}
		},
		complete: function(response) { // ON COMPLETE
			output.html(response.responseText); //update element with received data
			myform.resetForm();  // reset form
			submitbutton.removeAttr('disabled'); //enable submit button
			//progressbox.slideUp(); // hide progressbar
		}
	}); //END AJAX FORM UPLOAD PROGRESS
	
		
	});//END document.ready(function(){});
	

    
