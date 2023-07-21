/**
 *  highlightRow and highlight are used to show a visual feedback. If the row has been successfully modified, it will be highlighted in green. Otherwise, in red
 */
 
 EditableGrid.prototype.clearFilter = function(){
         this.localset('filter',''); //clears the localstorage entry
        this.currentFilter='';
}

function highlightRow(rowId, bgColor, after)
{
	var rowSelector = $("#" + rowId);
	rowSelector.css("background-color", bgColor);
	rowSelector.fadeTo("normal", 0.5, function() { 
		rowSelector.fadeTo("fast", 1, function() { 
			rowSelector.css("background-color", '');
		});
	});
}

function highlight(div_id, style) {
	highlightRow(div_id, style == "error" ? "#e5afaf" : style == "warning" ? "#ffcc00" : "#8dc70a");
}

function MM_openbrwindow(x,width,height,id){
var smswindow=window.open(x + '?id=' + id,'popup','width=' + width + ',height=' + height + ',scrollbars=0,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=180,top=30');
}
        
/**
   updateCellValue calls the PHP script that will update the database. 
 */
function updateCellValue(editableGrid, rowIndex, columnIndex, oldValue, newValue, row, onResponse)
{      

if(columnIndex==5)
{
MM_openbrwindow('bf_new_PDFReceipt.php',600,400,editableGrid.getCell(rowIndex, 0).innerHTML);

editableGrid.setValueAt(rowIndex, 5, oldValue)==false;

}else if(columnIndex==6)
{
MM_openbrwindow('bf_new_PDFReceipt_individual.php',600,400,editableGrid.getCell(rowIndex, 0).innerHTML);

editableGrid.setValueAt(rowIndex, 6, oldValue)==false;

}else
{
	
	$.ajax({
	url: 'bf_update_individual.php',
		type: 'POST',
		dataType: "html",
	   		data: {
			tablename : editableGrid.name,
			id: editableGrid.getRowId(rowIndex), 
			user_id:  $("#UserID").val(),
			newvalue: editableGrid.getColumnType(columnIndex) == "boolean" ? (newValue ? 1 : 0) : newValue, 
			colname: editableGrid.getColumnName(columnIndex),
			coltype: editableGrid.getColumnType(columnIndex)
			
		},
		success: function (response)
		{ 
		    //alert(editableGrid.getValueAt(rowIndex, 3));
					   
		   //alert(editableGrid.getCell(rowIndex, 4).innerHTML);
            
            //below gives actual value at a given cell
          //alert(editableGrid.getValueAt(rowIndex, columnIndex));
           
          // reset old value if failed then highlight row
			var success = onResponse ? onResponse(response) : (response == "ok" || !isNaN(parseInt(response))); // by default, a sucessfull reponse can be "ok" or a database id 
			if (!success) editableGrid.setValueAt(rowIndex, columnIndex, oldValue);
		    highlight(row.id, success ? "ok" : "error"); 
		},
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
	}); 
	
}//end of condition for updating
}
   


function DatabaseGrid() 
{ 
	this.editableGrid = new EditableGrid("bf_ind_receipts", {
		enableSort: true,
	    // define the number of row visible by page
      	pageSize: 100,
      // Once the table is displayed, we update the paginator state
        tableRendered:  function() {  updatePaginator(this); },
   	    tableLoaded: function() { datagrid.initializeGrid(this); },
		modelChanged: function(rowIndex, columnIndex, oldValue, newValue, row) {
   	    	updateCellValue(this, rowIndex, columnIndex, oldValue, newValue, row);
       	}
 	});
	this.fetchGrid(); 
	
}

DatabaseGrid.prototype.fetchGrid = function()  {
	
		// call a PHP script to get the data
	this.editableGrid.loadJSON("bf_loaddata_individual.php?db_tablename=bf_ind_receipts");
	
};

DatabaseGrid.prototype.initializeGrid = function(grid) {

  var self = this;

// render for the action column
	grid.setCellRenderer("action", new CellRenderer({ 
		render: function(cell, id) {                 
		      cell.innerHTML+= "<i onclick=\"datagrid.deleteRow("+id+");\" class='fa fa-trash-o red' ></i>";
		}
	})); 


	grid.renderGrid("tablecontent", "testgrid");
	
	
	};    

DatabaseGrid.prototype.deleteRow = function(id) 
{

  var self = this;

  if ( confirm('Are you sure you want to delete the row id ' + id )  ) {

        $.ajax({
		url: 'bf_delete_individual.php',
		type: 'POST',
		dataType: "html",
		data: {
			tablename : self.editableGrid.name,
			user_id:  $("#UserID").val(),
			id: id 
		},
		success: function (response) 
		{ 
			if (response == "ok" )
		        self.editableGrid.removeRow(id);
		},
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
	});

        
  }
			
}; 


DatabaseGrid.prototype.addRow = function(id) 
{

  var self = this;
    
    if($("#B_no").val()=='')
        {
            alert('Please select Bill No first before adding a Record');
            return false;
        }else if($("#Cust_name").val()=='')
		{
		alert('Please enter Customer Name before adding a Record');
            return false;			
		}else if($("#Billdate").val()=='')
		{
		alert('Please enter Bill Date before adding a Record');
            return false;			
		}else if($("#Amount").val()=='')
		{
		alert('Please Enter Amount before adding a Record');
            return false;			
		}else if($("#Particulars").val()=='')
		{
		alert('Please Enter Particulars for taking the Amount before adding a Record');
            return false;			
		}		
		else            
        {
			
		$.ajax({
		url: 'bf_add_individual.php',
		type: 'POST',
		dataType: "html",
		data: {
			tablename: self.editableGrid.name,
			cust_id:  $("#Cust_id").val(),	
			cust_namehidden:  $("#Cust_namehidden").val(),			
			B_no: $("#B_no").val(),
			billdate:  $("#Billdate").val(),
			user_id:  $("#UserID").val(),
			amount:  $("#Amount").val(),
			totalfees:  $("#Totalfees").val(),
			balance:  $("#Balance").val(),
			particulars:  $("#Particulars").val()				
		},
		success: function (response) 
		{ 
		
		alert('Record Added');
		//alert($("#Bill_no").val());
		/*$("#Cust_id").val(''),
			$("#Cust_namehidden").val(''),
			$("#Cust_name").val(''),			
			$("#Bill_no").val(''),
			$("#Amount").val(''),
			$("#Particulars").val(''),	*/
					       
                //showAddForm();
				
				// Below code refreshes the transactions page after adding a new row
                self.fetchGrid();
			   location.reload();				
          
		},
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: false
	});
		

        }
			
}; 



function updatePaginator(grid, divId)
{
    divId = divId || "paginator";
	var paginator = $("#" + divId).empty();
	var nbPages = grid.getPageCount();

	// get interval
	var interval = grid.getSlidingPageInterval(20);
	if (interval == null) return;
	
	// get pages in interval (with links except for the current page)
	var pages = grid.getPagesInInterval(interval, function(pageIndex, isCurrent) {
		if (isCurrent) return "<span id='currentpageindex'>" + (pageIndex + 1)  +"</span>";
		return $("<a>").css("cursor", "pointer").html(pageIndex + 1).click(function(event) { grid.setPageIndex(parseInt($(this).html()) - 1); });
	});
		
	// "first" link
	var link = $("<a class='nobg'>").html("<i class='fa fa-fast-backward'></i>");
	if (!grid.canGoBack()) link.css({ opacity : 0.4, filter: "alpha(opacity=40)" });
	else link.css("cursor", "pointer").click(function(event) { grid.firstPage(); });
	paginator.append(link);

	// "prev" link
	link = $("<a class='nobg'>").html("<i class='fa fa-backward'></i>");
	if (!grid.canGoBack()) link.css({ opacity : 0.4, filter: "alpha(opacity=40)" });
	else link.css("cursor", "pointer").click(function(event) { grid.prevPage(); });
	paginator.append(link);

	// pages
	for (p = 0; p < pages.length; p++) paginator.append(pages[p]).append(" ");
	
	// "next" link
	link = $("<a class='nobg'>").html("<i class='fa fa-forward'>");
	if (!grid.canGoForward()) link.css({ opacity : 0.4, filter: "alpha(opacity=40)" });
	else link.css("cursor", "pointer").click(function(event) { grid.nextPage(); });
	paginator.append(link);

	// "last" link
	link = $("<a class='nobg'>").html("<i class='fa fa-fast-forward'>");
	if (!grid.canGoForward()) link.css({ opacity : 0.4, filter: "alpha(opacity=40)" });
	else link.css("cursor", "pointer").click(function(event) { grid.lastPage(); });
	paginator.append(link);
}; 