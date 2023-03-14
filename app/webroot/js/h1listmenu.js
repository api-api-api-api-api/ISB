var serial=0;
var curHal=1;
var source;
var divisiList;
var selectedRow;
function loadGridArrayKhusus(gridobj,tblName,buffer) {}
function onLoadHandler() {
getData(1);
	}
function getData(hal){
	curHal=hal;
	cariData('',hal);
}

function cariData(strCari,hal){
	
	var url = 'listmenus/getData';
  
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
			if(returnedVal[2]>0){
			document.getElementById('linkHal').style.display='';
			document.getElementById('linkHal').innerHTML=returnedVal[1];
			document.getElementById('keterangan').innerHTML=returnedVal[3];
			}
			document.getElementById('maxHal').innerHTML=returnedVal[2];
			source.localdata = bufferToJSon(colNames,document.h1form.buffer.value);
			
			$("#jqxgrid").jqxGrid('updatebounddata');
			var rows = $('#jqxgrid').jqxGrid('getrows').length;
			selectedRow=rows;
		}
   	}
	);	
}
function bufferToJSon(header,buffer){
	var JSon=[];	
	var typeKolom='';
	var namaMenu='';
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
				if(header[x]=='NamaMenu'){namaMenu=cValue;}
				if(header[x]=='TipeMenu'){typeKolom=cValue;}	

				jSingle[header[x]]=cValue;
			
				if(typeKolom=="menu"){jSingle['NamaMenu']='../../'+namaMenu;}
				else if(typeKolom=="subMenu"){jSingle['NamaMenu']='../'+namaMenu;}
				else if(typeKolom=="groupMenu"){jSingle['NamaMenu']=namaMenu;}
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
	var rows = $('#jqxgrid').jqxGrid('getrows').length;
	for(n=0;n<rows;n++){
		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', n);
		if(dataRecord.NamaDivisi.trim()==''){alert ("Harap isi nama divisi");return;}
		if(dataRecord.NamaJabatan.trim()==''){alert ("Harap isi nama jabatan");return;}
		}
		
	var buffer=document.h1form.buffer.value;
	var url = 'jabatans/saveData';
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

function addData(type){
tambahRecord(type);
}
function tambahRecord(type){
	
	lastId=document.forms[0].lastId.value;
	if (lastId.length==0){
		document.forms[0].lastId.value='0';
	}else{
		lastId=parseInt(lastId)+1;
		document.forms[0].lastId.value=lastId;
	}
	lastId=document.forms[0].lastId.value;
	var rows = $('#jqxgrid').jqxGrid('getrows').length;
	var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedRow);
	typeMenu=dataRecord.TipeMenu;
	
	if(typeMenu.length==0 || rows==0){
		if(type==1){
			addRowBelowSelected("listMenu",document.h1form.buffer,
								0,lastId,"groupMenu","",0);
			
			}
		else if(type==2){
			alert("Belum ada data menu sama sekali."+
			"<br>Anda hanya bisa menambahkan leaf");
			return;
			}
		}
	else if(typeMenu=='groupMenu'){
		if(type==1){
			insertedIndex=parseInt(rows);
			addRowBelowSelected("listMenu",document.h1form.buffer,
								insertedIndex,lastId,"groupMenu","",0)
			}
		else if(type==2){
			parentId=dataRecord.id;
			if(parentId.substring(0,1)=='N'){
				alert("Anda tidak dapat menambah child pada parent yg belum tersimpan");
				return;
				}
			nextRow=parseInt(rows)+1;
			var cekTypeMenu="";
			for(x=nextRow;x<rows+1;x++){
				var dataRecord2 = $("#jqxgrid").jqxGrid('getrowdata', x);
				cekTypeMenu=dataRecord2.TypeMenu;
				if(cekTypeMenu!="Menu" && cekTypeMenu!="subMenu"){
					addRowBelowSelected("listMenu",document.h1form.buffer,
								parseInt(x)-1,lastId,"Menu",
								parentId,1);

				break;
				}	
			}
			
			
			}
		}
	else if(typeMenu=='Menu'){
		if(type==1){
			nextRow=parseInt(rows)+1;
			var cekTypeMenu="";
			for(x=nextRow;x<rows+1;x++){
				var dataRecord2 = $("#jqxgrid").jqxGrid('getrowdata', x);
				cekTypeMenu=dataRecord2.TypeMenu;
				if(cekTypeMenu!="Menu" && cekTypeMenu!="subMenu"){
					addRowBelowSelected("listMenu",document.h1form.buffer,
								parseInt(x)-1,lastId,"Menu",
								dataRecord.ParentId,1);
				break;
				}	
			}
			}
		else if(type==2){
			parentId=dataRecord.id;
			if(parentId.substring(0,1)=='N'){
				alert("Anda tidak dapat menambah child pada parent yg belum tersimpan");
				return;
				}
			nextRow=parseInt(selectedRow)+1;
			var cekTypeMenu="";
			for(x=nextRow;x<gridMenu.getRowCount()+1;x++){
				var dataRecord2 = $("#jqxgrid").jqxGrid('getrowdata', x);
				cekTypeMenu=dataRecord2.TypeMenu;
				if(cekTypeMenu!="subMenu"){
					addRowBelowSelected("listMenu",document.h1form.buffer,
								parseInt(x)-1,lastId,"subMenu",
								parentId,2);
				break;
				}	
			}
			}
		}
	else if(typeMenu=='subMenu'){
		
		if(type==1){
			
			nextRow=parseInt(gridMenu.getCurrentRow())+1;
			var cekTypeMenu="";
			for(x=nextRow;x<gridMenu.getRowCount()+1;x++){
				cekTypeMenu=gridMenu.getCellValue(1,x);
				if(cekTypeMenu!="subMenu"){
					addRowBelowSelected("listMenu",document.h1form.buffer,
								parseInt(x)-1,lastId,"subMenu",
								gridMenu.getCellData(4,gridMenu.getCurrentRow()),2);
				break;
				}	
			}
			
			}
			
		else if(type==2){			
			alert("Anda tidak dapat menambahkan child pada sub menu");
			return;
			}
		}
	
	}
function addRowBelowSelected(tblName,buffer,insertedIndex,lastId,typeMenu,parentId,level){ 

   	 var tempData="";
	 var bufferVal=buffer.value;
     for(x=0;x<parseInt(insertedIndex)+1;x++){
	 	iValue=bufferVal.substring(0,bufferVal.indexOf("^")+1);
		bufferVal=bufferVal.substring(bufferVal.indexOf("^")+1);
	 	tempData=tempData+iValue;
	  }
	  newRow="listMenu|N"+lastId+"||"+typeMenu+"||"+parentId+"||"+level+"|baru||^";
	  tempData=tempData+newRow+bufferVal;
      buffer.value=tempData;
	  source.localdata = bufferToJSon(colNames,document.h1form.buffer.value);
	$("#jqxgrid").jqxGrid('updatebounddata');
	/*  gridObj.setRowCount(gridObj.getRowCount()+1); 
	  loadGridArrayKhusus(gridObj,tblName,buffer);
      gridObj.refresh(); 
	  selectedIndex=parseInt(insertedIndex)+1;
	  gridObj.setCurrentRow(selectedIndex)
	  gridObj.setSelectedRows([selectedIndex]);*/
	  
    }
/*function tambahRecord(type){
	lastId=document.forms[0].lastId.value;
	if (lastId.length==0){
		document.forms[0].lastId.value='0';
	}
	else{
		lastId=parseInt(lastId)+1;
		document.forms[0].lastId.value=lastId;
	}
	lastId=document.forms[0].lastId.value;	
	var datarow = {"id":"N"+lastId,"NamaDivisi":"","NamaJabatan":""};
	var commit = $("#jqxgrid").jqxGrid('addrow', null, datarow);
	newRow="jabatan|N"+lastId+"|||||||^";
	document.forms[0].buffer.value=document.forms[0].buffer.value+newRow;
}*/

function delData(){
  
	var selectedrowindex = args.rowindex;				
	var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex );
    idJabatan=dataRecord.id;		
	deleteDataOnBuffer("jabatan",idJabatan,document.forms[0].buffer);	
	

	var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
	if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
           var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
           var commit = $("#jqxgrid").jqxGrid('deleterow', id);
                        }
}

