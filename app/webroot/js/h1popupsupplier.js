var serial=0;
var curHal=1;
$(document).ready(function () {
	onLoadHandler();
});
function onLoadHandler() {
	getData(1);
}
function getData(hal){
	curHal=hal;
	var txtOutlet=document.getElementById('txtOutlet').value;
	cariData(txtOutlet,hal);
}
function cariData(txtOutlet,hal){
	// subDivisi='';
	// if(document.getElementById('divId').value=='2'){
	// 	subDivisi=obj_caller.document.getElementById('subDivisi').value;
	// 	}
	// 	prodDivisiLain=document.getElementById("prodDivisiLain").checked;
	var url = 'popupsuppliers/getData';
	//call jQuery AJAX function
	$.ajax({
		url: url,
		type: "POST",
		data: ({txtOutlet:txtOutlet,hal:hal}),
		dataType: "text",
		success: function(result){
		console.log(result)
		result=result.split("!");
		//alert(returnedVal[2])
			$('#tblDetil').children('thead:first').html(result[0]);
			$('#tblDetil').children('tbody:first').html(result[1]);
			if(result[2].trim().length!=0){
					document.getElementById('linkHal').style.display='';
					document.getElementById('linkHal').innerHTML=result[2];
				}else{
					document.getElementById('linkHal').style.display='none';
				}
			document.getElementById('txtOutlet').value="";
		}
	});	
}