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
	cariData(hal);
}
function cariData(hal){
    var txtKategoriBarang=document.getElementById('txtKategoriBarang').value;
	var group=$("#txtGroup").val();
	var url = 'masterkategoriitems/getData';
	//call jQuery AJAX function
	$.ajax({
		url: url,
		type: "POST",
		data: ({txtKategoriBarang:txtKategoriBarang,hal:hal,group:group,fungsi:'getData'}),
		dataType: "text",
		success: function(result){
		//console.log(result)
		result=result.split("!");
		//alert(returnedVal[2])
			$('#tableIsi').children('tbody:first').html(result[0]);
			if(result[1].trim().length!=0){
					document.getElementById('linkHal1').style.display='';
					document.getElementById('linkHal1').innerHTML=result[1];
				}else{
					document.getElementById('linkHal1').style.display='none';
				}
        	//document.getElementById('txtKategoriBarang').value="";
        
		}
	});	
}

function editTag(data){
	//let id=data;
	var maintenanceTag=$("#maintenanceTag").val();
	//alert(maintenanceTag+id)
	//show item form
	//$("#id"+maintenanceTag+id).show();
	$("#lbl"+data).hide();
	$("#idNama"+data).show();
	$("#btnEditTag"+data).hide();
	$("#btnSimpanTag"+data).show();
	$("#btnBatalTag"+data).show();
}
function batalTag(data){
	var maintenanceTag=$("#maintenanceTag").val();
	$("#lbl"+data).show();
	$("#idNama"+data).hide();
	$("#btnEditTag"+data).show();
	$("#btnSimpanTag"+data).hide();
	$("#btnBatalTag"+data).hide();
}
function simpanTag(data){
	var maintenanceTag=$("#maintenanceTag").val();
	var id=$("#txtid"+data).val();
	var nama=$("#idNama"+data).val();
	var group=$("#txtGroup").val();
	//alert(maintenanceTag+id+nama);return
	var url="masterkategoriitems/updateTag";
	$.ajax({
		url: url,
		type: "POST",
		data: ({id:id,nama:nama,group:group}),
		dataType: "text",
		success: function(result){
		if(result='Sukses'){
            alert('Update Success')
            // $("#lbl"+data).show();
            // $("#idNama"+data).hide();
            // $("#btnEditTag"+data).show();
            // $("#btnSimpanTag"+data).hide();
            // $("#btnBatalTag"+data).hide();
            getData(1);
        }
		
		}
	});	
}
function saveKategori(){
	var KategoriBrg=$("#txtKategoriBrg").val();
	var group=$("#txtGroup").val();
	if(KategoriBrg==''){
		alert('Isian tidak boleh kosong');
		$("#txtKategoriBrg").focus();
		return
	}
    var url="masterkategoriitems/saveKategori";
    $.ajax({
		url: url,
		type: "POST",
		data: ({nama:KategoriBrg,group:group}),
		dataType: "text",
		success: function(result){
           // console.log(result);return
		if(result='Sukses'){
            alert('Save Success')
            
            getData(1);
            $("#txtKategoriBrg").val('');
        }
		
		}
	});	
}
$(function() {
    $("#tabs" ).tabs();
});
