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

function cariData(strCari,hal){
	
	var url = 'hirarkis/getData';
 
	var namaKolom=document.forms[0].namaKolom.value;
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
			document.h1form.karyawanAsal.innerHTML=returnedVal[2];
			document.h1form.karyawanTujuan.innerHTML=returnedVal[2];
			source.localdata = bufferToJSon(colNames,document.h1form.buffer.value);
			
			$("#gridKaryawan").jqxGrid('updatebounddata');
		//	cariDataJabatan();
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
      			if(header[x]=='LimitBawah'){cValue=formatInputNumber("Double",cValue);}
      			if(header[x]=='LimitAtas'){cValue=formatInputNumber("Double",cValue);}
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

function copyHirarki(){	
	var asal=document.h1form.karyawanAsal.value;
	var tujuan=document.h1form.karyawanTujuan.value;
	var url = 'hirarkis/copyHirarki';
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
//grid 2 processor
function addData_1(){
	tambahRecord_1();
}
function tambahRecord_1(){
	lastId_1=document.forms[0].lastId_1.value;
	if (lastId_1.length==0){
		document.forms[0].lastId_1.value='0';
	}
	else{
		lastId_1=parseInt(lastId_1)+1;
		document.forms[0].lastId_1.value=lastId_1;
	}
	lastId_1=document.forms[0].lastId_1.value;	
	var selectedrowindex = args1.rowindex;	
	
	var dataRecord = $("#gridKaryawan").jqxGrid('getrowdata', selectedrowindex );
	var datarow = {"id":"N"+lastId_1,"nik":dataRecord.id,"linkNik":"","NamaVerificator":"","JenjangHirarki":"","LimitBawah":"0","LimitAtas":"0","Edit":""};
	var commit = $("#gridHirarki").jqxGrid('addrow', null, datarow);
	newRow="hirarki|N"+lastId_1+"|"+dataRecord.id+"|||||||||^";
	document.forms[0].buffer2.value=document.forms[0].buffer2.value+newRow;

}

function delData_1(){
  
	var selectedrowindex = args2.rowindex;				
	var dataRecord = $("#gridHirarki").jqxGrid('getrowdata', selectedrowindex );
    idTemplatepostprice=dataRecord.id;		
	deleteDataOnBuffer("hirarki",idTemplatepostprice,document.forms[0].buffer2);	
	

	var rowscount = $("#gridHirarki").jqxGrid('getdatainformation').rowscount;
	if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
           var id = $("#gridHirarki").jqxGrid('getrowid', selectedrowindex);
           var commit = $("#gridHirarki").jqxGrid('deleterow', id);
                        }
}
function saveData_1(){
	var rows = $('#gridHirarki').jqxGrid('getrows').length;
	for(n=0;n<rows;n++){
		var dataRecord = $("#gridHirarki").jqxGrid('getrowdata', n);
		if(dataRecord.NamaVerificator.trim()==''){alert ("Harap isi Verificator");return;}
		//if(dataRecord.JenjangHirarki.trim()==''){alert ("Harap isi JenjangHirarki");return;}
		}
		
	var buffer=document.h1form.buffer2.value;
	var url = 'hirarkis/saveData';
	$.ajax({
		url: url,
		type: "POST",
		data: ({buffer:buffer}),
		dataType: "text",
		success: function(returnedVal){
			alert(returnedVal)
			//parent.openDialog("Peringatan",returnedVal,320,150,"alert","dialog");		  
			//getData(document.getElementById('maxHal').innerHTML);		
			document.forms[0].bufferHelper.value=returnedVal;
		}
   	});
}
function gridFindUser(grid,tableName,col1,col2,col3) {
	if(args1==undefined){
		alert('Harap pilih dulu user mana yang akan diset hirarkipostnya');
		return;
		}
	this.finder    = user_finder();
	this.popUp	 = "Karyawan";
	this.callerType= "grid";
	this.grid		=grid;
	this.tableName	=tableName;
	this.col1       = col1;
	this.col2       = col2;
	this.col3       = col3;
	this.args		=args1;
}
function user_finder() {
	var obj_calwindow = window.open('popupusers','user','resizable=0,scrollbars=0,toolbar=0,status=1,menubar=0,width=450,height=380,left=250,top=200');
	obj_calwindow.opener = self;
	obj_calwindow.focus();

}	
function gridFindJenjangHirarki(grid,tableName,col1,col2) {
	if(args1==undefined){
		alert('Harap pilih dulu user mana yang akan diset hirarkipostkpbnya');
		return;
		}
	this.finder    = jenjanghirarki_finder();
	this.popUp	 = "Jenjanghirarki";
	this.callerType= "grid";
	this.grid		=grid;
	this.tableName	=tableName;
	this.col1       = col1;
	this.col2       = col2;
	this.args		=args1;
}
function jenjanghirarki_finder() {
	var obj_calwindow = window.open('popupjenjanghirarkis','jenjanghirarki','resizable=0,scrollbars=0,toolbar=0,status=1,menubar=0,width=450,height=380,left=250,top=200');
	obj_calwindow.opener = self;
	obj_calwindow.focus();

}	