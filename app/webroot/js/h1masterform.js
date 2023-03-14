var serial=0;
var curHal=1;
$(document).ready(function () {
	onLoadHandler();
	$("#cetak").click(function(e){
		$("#tblDetil").tableExport({
			type:'csv',
			escape:'false'
		})
	})
	$(".btnTag").on('click',function(e){
		$("#myModal").modal('show')
	})
});
function onLoadHandler() {
	getData(1);
}
function getData(hal){
	curHal=hal;
	//var txtItemBarang=document.getElementById('txtItemBarang').value;
	cariData(hal);
}
function cariData(hal){
	var txtNmBrg = document.getElementById('txtNmBrg').value;
	var txtKategoriBrg = document.getElementById('txtKategoriBrg').value;
	var txtJenisBrg = document.getElementById('txtJenisBrg').value;
	var selectGroup = document.getElementById('group').value;
	var url = 'Masterforms/getData';
	//call jQuery AJAX function
	$.ajax({
		url: url,
		type: "POST",
		data: ({txtNmBrg:txtNmBrg,txtKategoriBrg:txtKategoriBrg,txtJenisBrg:txtJenisBrg,selectGroup:selectGroup,hal:hal}),
		dataType: "text",
		success: function(result){
		//console.log(result)
		result=result.split("!");
		//alert(returnedVal[2])
			$('#tblDetil1').children('tbody:first').html(result[0]);
			if(result[1].trim().length!=0){
					document.getElementById('linkHal1').style.display='';
					document.getElementById('linkHal1').innerHTML=result[1];
				}else{
					document.getElementById('linkHal1').style.display='none';
				}
			//document.getElementById('txtItemBarang').value="";
		}
	});	
}