$(document).ready(function() { 
//elements
var progressbox 		= $('#progressbox'); //progress bar wrapper
var progressbar 		= $('#progressbar'); //progress bar element
var statustxt 			= $('#statustxt'); //status text element
var submitbutton 		= $("#SubmitButton"); //submit button
var myform 				= $("#UploadForm"); //upload form
var output 				= $("#output"); //ajax result output element
var completed 			= '0%'; //initial progressbar value
var FileInputsHolder 	= $('#AddFileInput'); //Element where additional file inputs are appended
var MaxFileInputs		= 3; //Maximum number of file input boxs

var options = { 
			target:   '#output',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmit,  // pre-submit callback 
			uploadProgress: OnProgress,
			success:       afterSuccess,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
	 $('#UploadForm').submit(function() { 
			$(this).ajaxSubmit(options);  			
			// return false to prevent standard browser submit and page navigation 
			return false; 
		});

// ADDING AND REMOVING FILE INPUT BOX
var i = $("#AddFileInput div").size() + 1;
$("#AddMoreFileBox").click(function (event) {
		event.returnValue = false;
		if(i < MaxFileInputs)
		{
			$('<div class="clearfix"></div><span><input type="file" id="fileInputBox" class = "pull-left" style="margin: 5px 10px;" name="file[]"  value=""/><a href="#" class="removeclass pull-left" style="margin: 10px 0;"><span  class = "glyphicon glyphicon-minus"></span></a></span>').appendTo(FileInputsHolder);
			i++;
		}
		return false;
});

$("body").on("click",".removeclass", function(event){
		event.returnValue = false;
		if( i > 1 ) {
				$(this).parents('span').remove();i--;
		}
		
}); 


//when upload progresses	
function OnProgress(event, position, total, percentComplete)
{
	//Progress bar
	progressbar.width(percentComplete + '%') //update progressbar percent complete
	statustxt.html(percentComplete + '%'); //update status text
	if(percentComplete>50)
		{
			statustxt.css('color','#fff'); //change status text to white after 50%
		}
	if(percentComplete == 100){$('#loading-img').show();}
}

//after succesful upload
function afterSuccess()
{
	$('#SubmitButton').hide(); //hide submit button
	$('#loading-img').hide(); //hide submit button
	$("#progressbox").hide();

}

//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob){
		 
	var count = $(":input").size()-1;
		
		for(index = 0; index < count; index++){
			
			var fileInput = $(":input").eq(index).val();			

			if(!fileInput) //check empty input filed
			{
				//if(index=="1"){image = "first";}
				$("#output").html('<div align="center" style = "margin-top: 20px;" class = "alert alert-danger">Please select an image for '+fileInput+"_"+index+' item upload.</div>');			
				return false;
			}
			
			var ftype = $(":input").eq(index)[0].files[0].type;
			var fsize = $(":input").eq(index)[0].files[0].size;

			switch(ftype){
	            case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpg':
	                break;
	            default:
	                $("#output").html('<div align="center" class = "alert alert-danger" style = "margin-top: 20px;"><b>'+ftype+"_"+index+'</b> The file type you chose is unsupported! Please choose another one.');
					return false;
        	}

        	if(fsize>2097152){
				$("#output").html('<div align="center" class = "alert alert-danger" style = "margin-top: 20px;"><b>'+bytesToSize(fsize) +"_"+index+'</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.</div>');
				return false;
			}

		}

			//Progress bar
		progressbox.show(); //show progressbar
		progressbar.width(completed); //initial value 0% of progressbar
		statustxt.html(completed); //set status text
		statustxt.css('color','#000'); //initial color of status text

				
		$('#SubmitButton').hide(); //hide submit button
		//$('#loading-img').show(); //hide submit button
		$("#output").html("");  
	}
	else
	{
		//Output error to older unsupported browsers that doesn't support HTML5 File API
		$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

}); 