// below is code for uploads in UPDATE mode
	
	
//to disable submit button by default
//$("#Upload").attr('disabled','disabled');
//$("#Upload").prop('disabled','disabled');


$("#Uploadimage").on('submit',(function(e) {	

e.preventDefault();

 if($("#Brief_File").val()==0)
  {
  alert("Please Enter Brief_File No!!");
  
  return false;
  }else if($("#Partyid").val()==0)
  {
alert("Please Select Party Name!!");
return false;
  }else if($("#file").val()==0)
  {
alert("Please Select File!!");
return false;
  }else
  {
$.ajax({
url: 'ajax_php_file.php', // Url to which the request is sent
type: "POST",             // Type of request to be send, called as method
dataType: "html",
data: new FormData(this), //Data sent to server, a set of key/value pairs (i.e. form fields and values	

/*data: {
		Brief_File:$("#Brief_File").val(),
		Courtcaseno:$("#Courtcaseno").val(),
		Party:$("#Party").val()
	
	  },*/

contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false*/
success: function(data)   
{
$("#myform").html(data);
}

});

  }//end of if condition
}));
					 
					 
					 
function delete_post()
{
	
var status=confirm("Are you sure you want to delete ?");

if(status==true)
	{
		
		var file=$("#filetodelete").val();
		var brief_file=$("#Brief_File").val();
		
		
	$.ajax({
			url: 'lw_ajax_delete_file.php', // Url to which the request is sent
			type: "POST",             // Type of request to be sent, called as method
			dataType: "html",
			data: {
						filetodelete:file,
						brief_file:brief_file
			      },
	
success: function(data)   // A function to be called if request succeeds
{
//alert('deleted');


$("#myform").html(data);
}

});
	
}
	
}


// below is code for uploads in delete mode

$(document).ready(function(){
$("#deleteuploads").on('submit',(function(e) {	
	//$("submit").unbind();									  

e.preventDefault();
$("#myform").empty();
$('#loading').show();
$.ajax({
url: 'lw_ajax_delete_file.php', // Url to which the request is sent
type: "POST",             // Type of request to be send, called as method
dataType: "html",
data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
	
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
	
$("#message").html(data);
}

});
}));
});


// Function to preview image after validation
/*$(function() {
$("#fileone").change(function() {*/
						   
//$("#message").empty(); // To remove the previous error message
/*var file = this.files[0];
var imagefile = file.type;
var match= ["image/jpeg","image/png","image/jpg"];
if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
{
$('#previewing').attr('src','noimage.png');
$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
return false;
}
else
{
*//*var reader = new FileReader();
reader.onload = imageIsLoaded;
reader.readAsDataURL(this.files[0]);

});
});*/
/*
function imageIsLoaded(e) {
$("#file").css("color","green");
$('#image_preview').css("display", "block");
$('#previewing').attr('src', e.target.result);
$('#previewing').attr('width', '200px');
$('#previewing').attr('height', '180px');
};*/
						  
