var serial=0;
var curHal=1;
var source;
function loadGridArrayKhusus(gridobj,tblName,buffer) {}
function onLoadHandler() {
cariDataBawahanTakeover();	
cariData('',1);
	}
function getData(hal){
	curHal=hal;
	cariData(strCari.value,hal);
}	
function cariDataBawahanTakeover(){
	var url = 'hirarkis/getDataComboHirarkiBawahan';  	
	//call jQuery AJAX function
	$.ajax({
      url: url,
      type: "POST",
	  async:false,
      data: ({perusahaanId:1,divisi:'MKT2'}),
      dataType: "text",
      success: function(returnedVal){
		  
			returnedVal=returnedVal.split("!");
			document.getElementById('bawahanTakeOver').innerHTML=returnedVal[0];			
		}
   	}
	);	
}	function cariData(strCari,hal){
	namaKolom=document.forms[0].namaKolom.value;	
	var url = 'takeoverdpfbrngens/getData';
  	bawahanTakeover=document.getElementById('bawahanTakeOver').value;
	bawahanTakeover=bawahanTakeover.split("#");
	groupIdBawahan=bawahanTakeover[2];	
	idBawahan=bawahanTakeover[0];	
	
	//call jQuery AJAX function
	$.ajax({
      url: url,
      type: "POST",
      data: ({namaKolom:namaKolom,strCari:strCari,groupIdBawahan:groupIdBawahan,idBawahan:idBawahan,hal:hal}),
      dataType: "text",
      success: function(returnedVal){
			returnedVal=returnedVal.split("!");
			document.getElementById('tblPengajuanBody').innerHTML=returnedVal[0];
			if(returnedVal[2]>0){
			document.getElementById('linkHal').style.display='';
			document.getElementById('linkHal').innerHTML=returnedVal[1];
			}
			else{
				
			document.getElementById('linkHal').style.display='none';
				}
				document.getElementById('maxHal').innerHTML=returnedVal[2];
		}
   	}
	);	
}
function showDetailDPF(noDPF){	
	var url = 'takeoverdpfbrngens/getDataDetailPrint';
  	
	//call jQuery AJAX function
	$.ajax({
      url: url,
      type: "POST",
      data: ({noDPF:noDPF}),
      dataType: "text",
      success: function(returnedVal){
		 			
			document.getElementById('tblDetailDPFBody').innerHTML=returnedVal;
			
		}
   	}
	);	
}
function saveDPFDetail(noDPF,DPFId,groupId,group){	

	var url = 'takeoverdpfbrngens/saveDPFDetail';
	discPrinsipal=document.getElementById('discPrinsipal_'+DPFId).value;
	hargaJadi=parseFloat(removePeriodFromNumber(document.getElementById('hargaJadi_'+DPFId).innerHTML));
		totalDisc=parseFloat(removePeriodFromNumber(document.getElementById('totalDisc_'+DPFId).innerHTML));
	//call jQuery AJAX function
	$.ajax({
      url: url,
      type: "POST",
      data: ({DPFId:DPFId,groupId:groupId,group:group,discPrinsipal:discPrinsipal,hargaJadi:hargaJadi,totalDisc:totalDisc}),
      dataType: "text",
      success: function(returnedVal){
		  
		  alert(returnedVal);
		  showDetailDPF(noDPF);
			
		}
   	}
	);	
}
function prosesApproval(statusApproval,noDPF){
	var url = 'takeoverdpfbrngens/prosesApproval';
	var keteranganApproval=document.getElementById('keteranganApproval'+noDPF).value;
	var rejected=document.getElementsByName('reject');
	var idRejectCols='';
	for(n=0;n<rejected.length;n++)
	{
	 if(rejected[n].checked==true){
		 idReject=rejected[n].id.split("_");
		 idReject=idReject[1]
		 idRejectCols=idRejectCols+idReject+",";
		 }
		}
		
	$.ajax({
		url: url,
		type: "POST",
		data: ({noDPF:noDPF,statusApproval:statusApproval,keteranganApproval:keteranganApproval,idRejectCols:idRejectCols}),
		dataType: "text",
		success: function(returnedVal){
			alert(returnedVal);			
			onLoadHandler();		
		//	window.location.href='takeoverdpfs/cetakLaporanPDF?noDPF='+noDPF; 	
		}
   	});
}
function savePDF(noDPF){
	var url = 'takeoverdpfbrngens/cetakLaporanPDF';
  	
	//call jQuery AJAX function
	$.ajax({
      url: url,
      type: "POST",
      data: ({noDPF:noDPF}),
	  async:false,
      dataType: "text",
      success: function(returnedVal){
		  alert(returnedVal);
			returnedVal=returnedVal.split("!");
			
			
		}
   	}
	);	
}

