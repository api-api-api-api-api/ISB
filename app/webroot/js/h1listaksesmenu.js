var serial=0;
var curHal=1;
var source;
var divisiList;
var args1;
var args2;
function loadGridArrayKhusus(gridobj,tblName,buffer) {}
function onLoadHandler() {
getData(1);
	}
function getData(hal){
	curHal=hal; 
	cariData('',hal);
}
function cariDataMenu(){
	var url = 'listmenus/getDataComboMenu';
	//call jQuery AJAX function
	$.ajax({
      url: url,
      type: "POST",
      data: ({}),
      dataType: "text",
      success: function(returnedVal){
		
				 $("#gridGroup").jqxGrid('setcolumnproperty', 'NamaMenu', 'createeditor', function (row, column, editor,list) {
                            // assign a new data source to the dropdownlist.
                            editor.jqxDropDownList({ source: bufferToArray(returnedVal) });
                        });
		}
   	}
	);	

	}
function cariDataGroup(){
	var url = 'groups/getDataComboGroup';
	//call jQuery AJAX function
	$.ajax({
      url: url,
      type: "POST",
      data: ({}),
      dataType: "text",
      success: function(returnedVal){
		
				 $("#gridGroup").jqxGrid('setcolumnproperty', 'NamaGroup', 'createeditor', function (row, column, editor,list) {
                            // assign a new data source to the dropdownlist.
                            editor.jqxDropDownList({ source: bufferToArray(returnedVal) });
                        });
		}
   	}
	);	

	}	
function cariData(strCari,hal){
	
	var url = 'listaksesmenus/getData';
  
	var namaKolom='';
	//call jQuery AJAX function
	$.ajax({
      url: url,
      type: "POST",
      data: ({namaKolom:namaKolom,strCari:strCari,hal:hal}),
      dataType: "text",
      success: function(returnedVal){
		
			returnedVal=returnedVal.split("!");
			document.h1form.buffer.value=returnedVal[0];
			document.h1form.buffer2.value=returnedVal[1];
			document.h1form.groupAsal.innerHTML=returnedVal[2];
			document.h1form.groupTujuan.innerHTML=returnedVal[2];
			source.localdata = bufferToJSon(colNames,document.h1form.buffer.value);
			
			$("#gridGroup").jqxGrid('updatebounddata');
		//	cariDataGroup();
		//	cariDataMenu();
			
		}
   	}
	);	
}
function bufferToJSon(header,buffer){
	var JSon=[];	
	data=buffer;
   while (data.indexOf("^")>=0){
     iValue=data.substring(0,data.indexOf("^"));
     data=data.substring(data.indexOf("^")+1);
     tablename = getColumnValue(iValue, 1).trim();
	 var jSingle={};
	 	x=0;
     	
		 while(iValue.indexOf("|")>=0){
			  cValue=iValue.substring(0,iValue.indexOf("|"));
              iValue=iValue.substring(iValue.indexOf("|")+1);
				if (cValue.trim()!=tablename){
      			if(header[x]=='Nilai'){cValue=formatInputNumber("Double",cValue);}
				jSingle[header[x]]=cValue;
				x++;
				}
		 		
    		 }
			
			   JSon.push(jSingle);
   }
  return JSon;
}
function bufferToArray(buffer){
	var theArray=[];	
	data=buffer;
	x=0;
   	while (data.indexOf("^")>=0){
     iValue=data.substring(0,data.indexOf("^"));
     data=data.substring(data.indexOf("^")+1);	
	 	
     	theArray[x]=iValue;
				x++;
		
			
			   
   }
  return theArray;
}
function dataReady(){
var data =bufferToJSon(headerText,document.h1form.buffer.value);
}
function saveData(){
	var rows = $('#gridAksesMenu').jqxGrid('getrows').length;
	for(n=0;n<rows;n++){
		var dataRecord = $("#gridAksesMenu").jqxGrid('getrowdata', n);
		if(dataRecord.NamaMenu.trim()==''){alert ("Harap isi nama menu");return;}
		}
		
	var buffer=document.h1form.buffer2.value;
	var url = 'listaksesmenus/saveData';
	$.ajax({
		url: url,
		type: "POST",
		data: ({buffer:buffer}),
		dataType: "text",
		success: function(returnedVal){
			alert(returnedVal)
			//parent.openDialog("Peringatan",returnedVal,320,150,"alert","dialog");		  
			getData(document.getElementById('maxHal').innerHTML);		
			document.forms[0].bufferHelper.value=returnedVal;
		}
   	});
}
function copyAksesMenu(){
	
	var asal=document.h1form.groupAsal.value;
	var tujuan=document.h1form.groupTujuan.value;
	var url = 'listaksesmenus/copyAksesMenu';
	$.ajax({
		url: url,
		type: "POST",
		data: ({asal:asal,tujuan:tujuan}),
		dataType: "text",
		success: function(returnedVal){
			alert(returnedVal)
			getData(1);
		}
   	});
}
function addData(){
	tambahRecord();
}

function tambahRecord(){
	lastId=document.forms[0].lastId.value;
	if (lastId.length==0){
		document.forms[0].lastId.value='0';
	}
	else{
		lastId=parseInt(lastId)+1;
		document.forms[0].lastId.value=lastId;
	}
	lastId=document.forms[0].lastId.value;	
	var selectedrowindex = args1.rowindex;	
	
	var dataRecord = $("#gridGroup").jqxGrid('getrowdata', selectedrowindex );
	var datarow = {"id":"N"+lastId,"groupId":dataRecord.id,"menuId":"","NamaMenu":"","Edit":""};
	var commit = $("#gridAksesMenu").jqxGrid('addrow', null, datarow);
	newRow="listaksesmenu|N"+lastId+"|"+dataRecord.id+"||||||^";
	document.forms[0].buffer2.value=document.forms[0].buffer2.value+newRow;

}

function delData(){
  
	var selectedrowindex = args2.rowindex;				
	var dataRecord = $("#gridAksesMenu").jqxGrid('getrowdata', selectedrowindex );
    idTemplatepostprice=dataRecord.id;		
	deleteDataOnBuffer("listaksesmenu",idTemplatepostprice,document.forms[0].buffer2);	
	

	var rowscount = $("#gridAksesMenu").jqxGrid('getdatainformation').rowscount;
	if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
           var id = $("#gridAksesMenu").jqxGrid('getrowid', selectedrowindex);
           var commit = $("#gridAksesMenu").jqxGrid('deleterow', id);
                        }
}

function gridFindMenu(grid,col1,col2) {
	if(args1==undefined){
		alert('Harap pilih dulu group mana yang akan diatur akses menunya');
		return;
		}
	this.finder    = menu_finder();
	this.popUp	 = "Menu";
	this.callerType= "grid";
	this.grid		=grid;
	this.col1       = col1;
	this.col2       = col2;
	this.args		=args1;
}
function menu_finder() {

	var obj_calwindow = window.open('popupmenus','menu','resizable=0,scrollbars=0,toolbar=0,status=1,menubar=0,width=450,height=380,left=250,top=200');
	obj_calwindow.opener = self;
	obj_calwindow.focus();

}	