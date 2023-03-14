// JavaScript Document
var serial=0;
var curHal=1;
var saveMode='';
 $(document).ready(function () {

		    onLoadHandler();});
function onLoadHandler(){
	
	var url='users/onLoadHandler';
	
	$.ajax({
		url:url,
		type:"POST",
		data:({}),
		dataType:"text",
		success: function(returnedVal){
			
			//alert(returnedVal)
			returnedVal=returnedVal.split("!");
			document.getElementById('txtCabang').innerHTML=returnedVal[1];
			document.getElementById('txtDivisi').innerHTML=returnedVal[2];
			document.getElementById('txtGroups').innerHTML=returnedVal[3];
			document.getElementById('txtPerusahaan').innerHTML=returnedVal[4];
			document.getElementById('txtSubDivisi').innerHTML=returnedVal[5];
			}});
	
	getData(1);
	}

function getData(hal){
	//alert(hal)
	curHal=hal;
	var txtCari=document.getElementById('txtCari').value;
	cariData(txtCari,hal);
}

function cariData(txtCari,hal){
	//alert(strTanggal)
	var url = 'users/getData';
	var namaKolom=''; 
	//call jQuery AJAX function
	$.ajax({
      url: url,
      type: "POST",
      data: ({txtCari:txtCari,hal:hal}),
      dataType: "text",
      success: function(returnedVal){
		 returnedVal=returnedVal.split("!");
			$('#tblDetil').children('thead:first').html(returnedVal[2]);
			$('#tblDetil').children('tbody:first').html(returnedVal[3]);
			if(returnedVal[4].trim().length!=0){
			document.getElementById('linkHal').style.display='';
			document.getElementById('linkHal').innerHTML=returnedVal[4];}
			}
		});
		$('#txtNama').val('');
}



function saveData(){
	if (document.getElementById('txtNama').value==""){
		alert ("isi nama!");
		return 0;
	}
	else if (document.getElementById('txtGroups').value=="")
	{
		alert ("Pilih Groups!");
		return 0;
	}
	
	else if (document.getElementById('txtPenanggungjawab').value=="" && (document.getElementById('txtGroups').value=='MKT' || document.getElementById('txtGroups').value=='SM Berno' || document.getElementById('txtGroups').value=='GSM' || document.getElementById('txtGroups').value=='DM' ||document.getElementById('txtGroups').value=='AM'))
	{
		alert ("Isi Penanggung Jawab!");
		return 0;
	}
	else if (document.getElementById('txtPejabatId').value=="" && (document.getElementById('txtGroups').value=='MKT' || document.getElementById('txtGroups').value=='SM Berno' || document.getElementById('txtGroups').value=='GSM' || document.getElementById('txtGroups').value=='DM' ||document.getElementById('txtGroups').value=='AM'))
	{
		alert ("Isi Pejabat Id!");
		return 0;
	}
	
	else if (document.getElementById('txtCabang').value=="")
	{
	//	alert ("Pilih Cabang!");
//		return 0;
	}
	else if (document.getElementById('txtDivisi').value=="")
	{
	//	alert ("Pilih Divisi!");
	//	return 0;
	}
	else if (document.getElementById('txtSubDivisi').value=="" && (document.getElementById('txtGroups').value=='MKT' || document.getElementById('txtGroups').value=='SM Berno' || document.getElementById('txtGroups').value=='GSM' || document.getElementById('txtGroups').value=='DM' ||document.getElementById('txtGroups').value=='AM'))
	{
		alert ("Pilih Sub Divisi!");
		return 0;
	}
	
	else if (document.getElementById('txtPerusahaan').value=="")
	{
		alert ("Pilih Perusahaan!");
		return 0;
	}
	else if (document.getElementById('txtReguler').value=="")
	{
		alert ("Pilih Reguler!");
		return 0;
	}
	var saveMode=$('#saveMode').val();
	var id=$('#id').val();
	var nama=$('#txtNama').val();
	var penanggungjawab=$('#txtPenanggungjawab').val();
	var pejabatid=$('#txtPejabatId').val();
	var groups=$('#txtGroups').val();
	var cabang=$('#txtCabang').val();
	var divisi=$('#txtDivisi').val();
	var subDivisi=$('#txtSubDivisi').val();
	var perusahaan=$('#txtPerusahaan').val();
	var reguler=$('#txtReguler').val();
	var keterangan=$('#txtKeterangan').val();
	var url='users/saveData';
	
	$.ajax({
		url:url,
		type:"POST",
		data:({saveMode:saveMode,nama:nama,penanggungjawab:penanggungjawab,pejabatid:pejabatid,groups:groups,divisi:divisi,subDivisi:subDivisi,cabang:cabang,perusahaan:perusahaan,reguler:reguler,keterangan:keterangan,id:id,mode:'saveData'}),
		dataType:"text",
		success: function(returnedVal){
		alert(returnedVal)
			//$('#divSimpan').html(returnedVal);
			$('#id').val("");
			$('#txtNama').val("");
			$('#txtPenanggungjawab').val("");
			$('#txtPejabatId').val("");
			$('#txtGroups').val();
			$('#txtCabang').val("");
			$('#txtDivisi').val("");
			$('#txtSubDivisi').val("");
			$('#txtPerusahaan').val("");
			$('#txtReguler').val("");
			$('#txtKeterangan').val("");
			$('#saveMode').val('input');
			}});
			
			
	onLoadHandler();
	
	}
	
function editData(id){
	
	$('#saveMode').val('edit');
	$('#id').val($('#id'+id).html());
	$('#txtNama').val($('#txtNama'+id).html());
	$('#txtPenanggungjawab').val($('#txtPenanggungjawab'+id).html());
	$('#txtPejabatId').val($('#txtPejabatId'+id).html());
	$('#txtGroups').val($('#txtGroupsId'+id).html());
	$('#txtCabang').val($('#txtCabangID'+id).html());
	$('#txtDivisi').val($('#txtDivisi'+id).html());
	$('#txtSubDivisi').val($('#txtDivisi'+id).html()+"-^-"+$('#txtSubDivisi'+id).html());
	$('#txtPerusahaan').val($('#txtPerusahaanId'+id).html());
	$('#txtReguler').val($('#txtReguler'+id).html());
	$('#txtKeterangan').val($('#txtKeterangan'+id).html());
	
	}
function hapusData(id){
	
    var confirm1 = confirm('Pilih OK untuk menghapus data');
    if (confirm1) {
      prosesHapus(id)
    }else { }
  	}
	
function prosesHapus(id){
	var url = 'users/hapusData';
	
	$.ajax({
      url: url,
      type: "POST",
      data: ({id:id}),
      dataType: "text",
      success: function(returnedVal){
		  alert(returnedVal)
		  }});
	onLoadHandler();
	
	}
