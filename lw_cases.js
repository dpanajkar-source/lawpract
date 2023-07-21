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




$("#Bcc_Radio").click(function() {
	$("#Brief_File").val($("#Bcc_Radio").val()+finalvaluebcc);
	if($("#Caseparty").val()!="")
	{
	$("#Upload").removeAttr('disabled');
	}
	
	
	 $("#brief").val(finalvaluebcc); 
	/* $("#Stageinsert").removeAttr('disabled');
	$("#Clientcatinsert").removeAttr('disabled');
	$("#Casecatinsert").removeAttr('disabled');
	$("#Courtinsert").removeAttr('disabled');
	$("#Casestatusinsert").removeAttr('disabled');*/
  
});


/*function checkdelete()
{

if(confirm("Do you really want to delete?"))
	{
return true;
	}else
	{
return false;
	}

}*/


$("#Boc_Radio").click( function() {
	$("#Brief_File").val($("#Boc_Radio").val()+finalvaluebcc);
	
	 $("#brief").val(finalvaluebcc);
		
  
});

$("#Foc_Radio").click( function() {
	$("#Brief_File").val($("#Foc_Radio").val()+finalvaluebcc);
	
	 $("#brief").val(finalvaluebcc);
	 
  
});

$("#Fcc_Radio").click( function() {
	$("#Brief_File").val($("#Fcc_Radio").val()+finalvaluebcc);
	 $("#brief").val(finalvaluebcc);
	 
	});

/*
$("#N_Radio_Sent").click( function() {

	 $("#Notice_noinsert").val($("#N_Radio_Sent").val()+finalvaluesnst);
	  
});

$("#N_Radio_Received").click( function() { 

	 $("#Notice_noinsert").val($("#N_Radio_Received").val()+finalvaluesnrv);
	  
});*/

$("#Notice_no").blur(function() {
$("#Notice_no_id").val('');

$("#Notice_nohidden").val($("#Notice_no").val());

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
  }else if($("#Casepartyname").val()==0)
  {
  alert("Please Select/Enter Party Name from Drop Down List");
  
  return false;
  }else if($("#Caseoppopartyname").val()==0)
  {
  alert("Please Select/Enter Opposite Party Name from Drop Down List");
  
  return false;  
  }else if($("#Nextdate").val())
  {
    var record_day1=$("#Currdate").val().split("/");
    var sum1=record_day1[1]+'/'+record_day1[0]+'/'+record_day1[2];  
    var record_day2=$("#Nextdate").val().split("/");
    var sum2=record_day2[1]+'/'+record_day2[0]+'/'+record_day2[2];  
    var record1 = new Date(sum1);
    var record2 = new Date(sum2); 
    if(record2 < record1)
    {
            alert("Next date must be greater than Current date");
            return false;
    }  
	 
  }   										 
					  function selCol() {		
					  
						var rowCount=document.getElementById("myTableData").rows.length;
					 			 
					 var emp = [];
					 var filled = [];
					 emp=document.getElementById("myTableData").rows[1].cells[0];
					 
					 var j=0;
					 for(var x=2; x<rowCount; x++)
					 	{ 
						 
					       emp[x]=document.getElementById("myTableData").rows[x].cells[0];
                            
                               if(emp[x].textContent!='')
                                   {
								filled[j++]=emp[x].textContent;					
                                   }
					 	}		
						
						return filled;						
					
					}
  
  var Client=selCol();
 
 
 if(Client<1)
      {
     
      }//condition for client array not empty
      else{
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
//alert('success');
//$("#message").html(data);
}

});//end of ajax
          
 }//end of else statement
	  
	  //below is for opposite party list
	   function selColoppoparty() {		
					  
					 					 
					 var rowCount=document.getElementById("myTableDataoppoparty").rows.length;
					 			 
					 var emp = [];
					 var filled = [];
					 emp=document.getElementById("myTableDataoppoparty").rows[1].cells[0];
					 
					 var j=0;
					 for(var x=2; x<rowCount; x++)
					 	{ 
						 
					       emp[x]=document.getElementById("myTableDataoppoparty").rows[x].cells[0];
                            
                               if(emp[x].textContent!='')
                                   {
								filled[j++]=emp[x].textContent;					
                                   }
					 	}		
						
						return filled;						
					
					}
  
  var oppoparties=selColoppoparty();
  
  if(oppoparties<1)
      {
       
      }//condition for client array not empty
      else{
		  
	$.ajax({
url: 'addclientsoppo.php', // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
dataType: "json",
//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
data: {
			'Clientoppoparty': JSON.stringify(oppoparties),
			'brief_fileoppoparty': $("#Brief_File").val()			
	  },

success: function(data)   // A function to be called if request succeeds
{
//alert('success');
//$("#message").html(data);
}

});
          
      }
	  
  }





function checkvalidityupdate()
  {     
    
  if($("#Brief_Fileupdate").val()==0)
  {
  alert("Please Enter Brief_File No!!");
  
  return false;
  }else if($("#Casepartynameupdate").val()==0)
  {
  alert("Please Select/Enter Party Name from Drop Down List");
  
  return false;
  }else if($("#Caseoppopartynameupdate").val()==0)
  {
  alert("Please Select/Enter Opposite Party Name from Drop Down List");
  
  return false;  } 
  
 
  										 
					  function selCol() {		
					  
					 				 
					 var rowCount=document.getElementById("myTableDataupdate").rows.length;
					 			 
					 var emp = [];
					 var filled = [];
					 emp=document.getElementById("myTableDataupdate").rows[1].cells[0];
					 
					 var j=0;
					 for(var x=2; x<rowCount; x++)
					 	{ 
						 
					       emp[x]=document.getElementById("myTableDataupdate").rows[x].cells[0];
								filled[j++]=emp[x].textContent;					
						
					 	}		
						
						return filled;						
					
					}
  
  var Client=selCol();

    
if(Client==0)
      {
      
      }//condition for client array not empty
      else{
   
	$.ajax({
url: 'addclients.php', // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
dataType: "json",
//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
data: {
			'Client': JSON.stringify(Client),
			'brief_file': $("#Brief_Fileupdate").val()			
	  },

success: function(data)   // A function to be called if request succeeds
{
//alert('success');
//$("#message").html(data);
}

});//end of ajax
          
 }//end of else statement
	  
 
	   //below is for opposite party list
	   function selColoppoparty() {		
					  
					 
					 var rowCount=document.getElementById("myTableDataoppoupdate").rows.length;
					 			 
					 var emp = [];
					 var filled = [];
					 emp=document.getElementById("myTableDataoppoupdate").rows[1].cells[0];
					 
					 var j=0;
					 for(var x=2; x<rowCount; x++)
					 	{ 
						 
					       emp[x]=document.getElementById("myTableDataoppoupdate").rows[x].cells[0];
                            
                               if(emp[x].textContent!='')
                                   {
								filled[j++]=emp[x].textContent;					
                                   }
					 	}		
						
						return filled;						
					
					}
  
  var oppoparties=selColoppoparty();

  
  if(oppoparties<1)
      {
           
     
      }//condition for client array not empty
      else{
		  
	$.ajax({
url: 'addclientsoppo.php', // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
dataType: "json",
//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
data: {
			'Clientoppoparty': JSON.stringify(oppoparties),
			'brief_fileoppoparty': $("#Brief_Fileupdate").val()			
	  },

success: function(data)   // A function to be called if request succeeds
{
//alert('success');
//$("#message").html(data);
}

});
          
      }
	  
  
  }


 

  
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