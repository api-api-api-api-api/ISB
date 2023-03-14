var serial=0;
var curHal=1;
 $(document).ready(function () {
		    onLoadHandler();});

function onLoadHandler() {
	
	//document.h1form.buffer_1.value=data;
	
var url='popupdistributors/onLoadHandler';
	
	$.ajax({
		url:url,
		type:"POST",
		data:({}),
		dataType:"text",
		success: function(returnedVal){
			
			returnedVal=returnedVal.split("!");
			document.getElementById('groupDist').innerHTML=returnedVal[0];
			cariData(document.getElementById('groupDist').value,1);
			}});
	}
function getData(hal){
	curHal=hal;
	var groupDist=document.getElementById('groupDist').value;
	cariData(groupDist,hal);
}




function cariData(txtDistributor,hal){
	filterBySales=document.getElementById("filterBySales").checked;
alamat=document.getElementById('alamat').value;

	var url = 'popupdistributors/getData';
	//call jQuery AJAX function
	$.ajax({
      url: url,
      type: "POST",
      data: ({filterBySales:filterBySales,txtDistributor:txtDistributor,alamat:alamat,hal:hal}),
      dataType: "text",
      success: function(returnedVal){
    	
		returnedVal=returnedVal.split("!");
		//alert(returnedVal[2])
		$('#tblDetil').children('thead:first').html(returnedVal[0]);
		$('#tblDetil').children('tbody:first').html(returnedVal[1]);
		if(returnedVal[2].trim().length!=0){
			document.getElementById('linkHal').style.display='';
			document.getElementById('linkHal').innerHTML=returnedVal[2];}
			else{document.getElementById('linkHal').style.display='none';}
		}
		});	
	
	}
	
	
