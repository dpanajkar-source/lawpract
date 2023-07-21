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
        
/**
   updateCellValue calls the PHP script that will update the database. 
 */
function updateCellValue(editableGrid, rowIndex, columnIndex, oldValue, newValue, row, onResponse)
{      

var currdate = editableGrid.getValueAt(rowIndex, 3);
var nextdate = editableGrid.getValueAt(rowIndex, 4);

if(nextdate)
{

var record_day1=currdate.split("/");
    var sum1=record_day1[1]+'/'+record_day1[0]+'/'+record_day1[2];  
    var record_day2=nextdate.split("/");
    var sum2=record_day2[1]+'/'+record_day2[0]+'/'+record_day2[2];  
    var record1 = new Date(sum1);
    var record2 = new Date(sum2); 
    if(record2 < record1 && editableGrid.getColumnName(columnIndex)=='nextcourtdate')
    {
            alert("Next date must be greater than Current date");
            return false;
    }  
	
}

	$.ajax({
	url: 'updatefull.php?stageval=' + editableGrid.getValueAt(rowIndex, 9) + '&brief_file=' + editableGrid.getCell(rowIndex, 1).innerHTML,
		type: 'POST',
		dataType: "html",
	   		data: {
			tablename : editableGrid.name,
			id: editableGrid.getRowId(rowIndex), 
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
			this.fetchGrid(); 
		},
		error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
		async: true
	}); 
	
   
}
   


function DatabaseGrid() 
{ 
	this.editableGrid = new EditableGrid("lw_trans", {
		enableSort: true,
	    // define the number of rows visible by page
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
	this.editableGrid.loadJSON("loaddatafull.php?db_tablename=lw_trans");
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
		url: 'delete.php',
		type: 'POST',
		dataType: "html",
		data: {
			tablename : self.editableGrid.name,
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
    
    if($("#Courtcasenohidden").val()=='')
        {
            alert('Please select court case no first before adding a Record');
            return false;
        }else
            
        {
		$.ajax({
		url: 'addfull.php',
		type: 'POST',
		dataType: "html",
		data: {
			tablename : self.editableGrid.name,
			courtcaseno:  $("#Courtcasenohidden").val(),
			stage:  $("#Stage").val(),
			brief_file:  $("#Brief_filehidden").val(),
			otherdate:  $("#Otherdate").val(),
			nextdate:  $("#Nextdate").val()		
			
		},
		success: function (response) 
		{ 
			   if(response==1)
		  {
			  alert('There is atleast one entry of the selected Caseno in Diary. Please do not add a new row. First filter by caseno and then insert next date in the table directly');
		  }else
		  {
			  alert("Row added");
		  }				
				
                //showAddForm();
				
				// Below code refreshes the transactions page after adding a new row
                self.fetchGrid();
          
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