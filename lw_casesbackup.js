/*$("#Submit").on('submit',(function(e) {	
alert("Ajax worked");

e.preventDefault();
$("#message").empty();
$.ajax({
url: '', // Url to which the request is send
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
}));	*/

$("#Bcc_Radio").click( function() {
	$("#Brief_File").val($("#Bcc_Radio").val()+finalvalue);
	if($("#Caseparty").val()!="")
	{
	$("#Upload").removeAttr('disabled');
	}
	 $("#brief").val(finalvalue); 
	/* $("#Stageinsert").removeAttr('disabled');
	$("#Clientcatinsert").removeAttr('disabled');
	$("#Casecatinsert").removeAttr('disabled');
	$("#Courtinsert").removeAttr('disabled');
	$("#Casestatusinsert").removeAttr('disabled');*/
  
});


/*$("#selectcol").click( function() {
								
		var ar=[];
		ar=selCol();
					//assign below values to hidden elements by creating here itself			
		//$("#inputname").val(ar[0]);
		
		alert(ar[1]);
		  
});*/

$("#N_Radio_Sent").click( function() {

	 $("#Notice_noinsert").val($("#N_Radio_Sent").val()+finalvaluesnotice);
	  
});

$("#N_Radio_Received").click( function() {

	 $("#Notice_noinsert").val($("#N_Radio_Received").val()+finalvaluesnotice);
	  
});



$("#Boc_Radio").click( function() {
	$("#Brief_File").val($("#Boc_Radio").val()+finalvalue);
	
	 $("#brief").val(finalvalue);
		
  
});

$("#Foc_Radio").click( function() {
	$("#Brief_File").val($("#Foc_Radio").val()+finalvalue);
	
	 $("#brief").val(finalvalue);
	 
  
});

$("#Fcc_Radio").click( function() {
	$("#Brief_File").val($("#Fcc_Radio").val()+finalvalue);
	 $("#brief").val(finalvalue);
	 
	});


$("#Casepartyname").blur(function() {
$("#Casepartyid").val('');
$("#Address").val('');
$("#Mobile").val('');


$("#Casepartynamehidden").val($("#Casepartyname").val());

});


$("#Caseoppopartyname").blur(function() {										  
$("#Caseoppopartyid").val('');
$("#Addressoppo").val('');
$("#Mobileoppo").val('');
$("#Caseoppopartynamehidden").val($("#Caseoppopartyname").val());

});


/*
$("#Caseparty").change(function() {
if($("#Caseparty").val()!=0 && $("#Brief_File").val()!="")
{
	
$("#Upload").removeAttr('disabled');
 $("#foldername").val($("#Caseparty").val());

}

});
*/

$("#Courtcaseno").blur(function() {
if($("#Courtcase").val()!=0 && $("#Brief_File").val()!="")
{
 $("#courtcase").val($("#Courtcaseno").val());

}

});




 
function checkvaliditysearch()
{

if($("#Brief_File_Search").val()==0 && $("#Partyname_Search").val()==0)
	{

alert("Please Enter Brief_File No or Partyname!!");

return false;
	}

}

 	

  function checkvalidity()
  {
  
  if($("#Brief_File").val()==0)
  {
  alert("Please Enter Brief_File No!!");
  
  return false;
  }else if($("#Courtcaseno").val()==0)
  {
  alert("Please Enter Court Case No!!");
  
  return false;
  }else if($("#Casepartyname").val()==0)
  {
  alert("Please Select/Enter Party Name from Drop Down List");
  
  return false;
  }else if($("#Caseoppopartyname").val()==0)
  {
  alert("Please Select/Enter Opposite Party Name from Drop Down List");
  
  return false;  } 
  
  										 
					  function selCol() {		
					  
					 var table=document.getElementById("myTableData");
					 
					 var rowCount=document.getElementById("myTableData").rows.length;
					 			 
					 var emp = [];
					 var filled = [];
					 emp=document.getElementById("myTableData").rows[1].cells[0];
					 
					 var j=0;
					 for(var x=2; x<rowCount; x++)
					 	{ 
						 
					       emp[x]=document.getElementById("myTableData").rows[x].cells[0];
								filled[j++]=emp[x].textContent;					
						
					 	}		
						
						return filled;						
					
					}
  
  var Client=selCol();
  
 
  
	$.ajax({
url: 'addclients.php', // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
dataType: "json",
//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
data: {
			'Client': JSON.stringify(Client),
			'brief_file': $("#Brief_File").val()			
	  },

success: function(data)   // A function to be called if request succeeds
{
alert('success');
//$("#message").html(data);
}

});
  
  }
 
/*//ajax call
$("#Casepartyajax").focusout(function(e) { 
	
	var res=0;
					 
	 $.ajax({
			url: 'ajax_caseparty.php',	
			type: 'POST',
			dataType: "html",
			data: {
			partyname: $("#Casepartyajax").val()
			},
		
		 success: function (data) 
			{ 
			
          $("#address").html(data);	
		   $("#addressold").hide;
		   $("#mobileold").hide;
		   
			},
			error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
			async: false
		});


});*/

  
$(document).ready(function($) {
						   
						   
$("#Stageinsert").focus(function(e) { 
					 
	 $.ajax({
			url: 'lw_casestageload.php',
			type: 'POST',
			dataType: "html",
		
		 success: function (output) 
			{ 
				$("#Stageinsert").html(output);          
			},
			error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
			async: false
		});


});

$("#Courtid").focus(function(e) { 
					 
	 $.ajax({
			url: 'lw_casecourtload.php',
			type: 'POST',
			dataType: "html",
		
		 success: function (output) 
			{ 
				$("#Courtid").html(output);          
			},
			error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
			async: false
		});


});

$("#Selectedroleparty").focus(function(e) { 
						   
				 
	 $.ajax({
			url: 'lw_partiesinvolvedload.php',
			type: 'POST',
			dataType: "html",
		
		 success: function (output) 
			{ 
				$("#Selectedroleparty").html(output);     
				$("#Selectedroleoppoparty").html(output);  
			},
			error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
			async: false
		});


});

$("#Clientcatid").focus(function(e) { 
					 
	 $.ajax({
			url: 'lw_clientcategoryload.php',
			type: 'POST',
			dataType: "html",
		
		 success: function (output) 
			{ 
				$("#Clientcatid").html(output);          
			},
			error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
			async: false
		});


});

$("#Casecatid").focus(function(e) { 
					 
	 $.ajax({
			url: 'lw_casecategoryload.php',
			type: 'POST',
			dataType: "html",
			data: {
			tablename : self.editableGrid.name,
			id: id,
		},
		
		 success: function (output) 
			{ 
				$("#Casecatid").html(output);          
			},
			error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
			async: false
		});


});

});