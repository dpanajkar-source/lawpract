$("#Uploadimage").on('submit',(function(e) {	

e.preventDefault();

 if($("#Cust_name").val()==0)
  {
  alert("Please Select Customer Name First!!");
  
  return false;
  }else
  {
$.ajax({
url: 'bf_ajax_file_upload.php', // Url to which the request is sent
type: "POST",             // Type of request to be send, called as method
dataType: "html",
data: new FormData(this), //Data sent to server, a set of key/value pairs (i.e. form fields and values	

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
		var cust_name=$("#Cust_name").val();
		
		
	$.ajax({
			url: 'bf_ajax_file_upload.php', // Url to which the request is sent
			type: "POST",             // Type of request to be sent, called as method
			dataType: "html",
			data: {
						filetodelete:file,
						cust_name:cust_name
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
url: 'bf_ajax_file_upload.php', // Url to which the request is sent
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
