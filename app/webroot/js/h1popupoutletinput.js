var serial=0;
var curHal=1;
 $(document).ready(function () {
		    onLoadHandler();});

function onLoadHandler() {
	
	//document.h1form.buffer_1.value=data;
	
	getData(1);
	}
function getData(hal){
	curHal=hal;
	var txtOutlet=document.getElementById('txtOutlet').value;
	cariData(txtOutlet,hal);
}




function cariData(txtOutlet,hal){
	
	var url = 'popupoutletinputs/getData';
	filterByDM=document.getElementById("filterByDM").checked;
	//call jQuery AJAX function
	subDivisi='';
	
	if(document.getElementById('divId').value=='2'){
		
		subDivisi=obj_caller.document.getElementById('subDivisi').value;}
	
	$.ajax({
      url: url,
      type: "POST",
      data: ({filterByDM:filterByDM,txtOutlet:txtOutlet,subDivisi:subDivisi,hal:hal}),
      dataType: "text",
      success: function(returnedVal){
		
		returnedVal=returnedVal.split("!");
		$('#tblDetil').children('thead:first').html(returnedVal[0]);
		$('#tblDetil').children('tbody:first').html(returnedVal[1]);
		if(returnedVal[2].trim().length!=0){
			document.getElementById('linkHal').style.display='';
			document.getElementById('linkHal').innerHTML=returnedVal[2];}
			else{document.getElementById('linkHal').style.display='none';}
		document.getElementById('txtOutlet').value="";
		}
		});	
	
	}
	
	
