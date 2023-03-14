var serial=0;
var curHal=1;
var source;
var divisiList;
function loadGridArrayKhusus(gridobj,tblName,buffer) {}
function onLoadHandler() {
getData(1);
	}
function getData(hal){
	curHal=hal;
	cariData('',hal);
}

function cariData(strCari,hal){
	
	var url = 'popupoutlets/getData';
  	var lokasi=document.location.toString().split("?");
	lokasi=lokasi[1].split("=");
	comId=lokasi[1];
	var namaKolom=document.forms[0].namaKolom.value;
	//call jQuery AJAX function
	$.ajax({
      url: url,
      type: "POST",
      data: ({comId:comId,namaKolom:namaKolom,strCari:strCari,hal:hal}),
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
