var serial=0;
var curHal=1;
$(document).ready(function (val) {
	$("#detailSoal").hide();
	onloadHandler();
	$("#tblkaryawan tbody").on('click','.tab',function() {
	$("#tblkaryawan tbody tr").removeClass("warning");
	var selected = $(this).addClass("warning");
	if(!selected)
		$(this).addClass("warning");
	var idkry=$(this).find("input").val();
	//alert(nik);return
	setSoal(idkry);
	});


	$("#form1").on('submit',function(e){
		
	})
	$("#btnsimpan").on('click',function(e){
		
	})

})

function simpan(){
	var soal = document.getElementsByName("idSoal[]");
	var jmlClassPanel = document.getElementsByClassName("panelCheck").length;
	if(jmlClassPanel>2){
		var jumSoalUraian=document.getElementsByClassName("idSoalUraian").length;
		for(var i=0;i<jumSoalUraian;i++){
			var idSoalUraian=document.getElementsByClassName('idSoalUraian')[i].value;
			var txtSoalUraianValue=document.getElementById('soalUraian'+idSoalUraian).value
			if(txtSoalUraianValue==''){
				alert("Isian belum lengkap,\nCek kembali Checklish maupun kolom isian anda");
				$("#soalUraian"+idSoalUraian).focus()
				return
			}
		}
	}

	//alert(soal.length);return
		for(var i=0;i<soal.length;i++){
			var id=soal[i].value;
			var valueTp=document.getElementById('valueTp'+id).value
			if(valueTp==""){
				alert("ceklish masih ada yang kosong");return
			}

		}
		
		var data=$("#form1").serializeArray();
		var url = 'paformolds/crud';
		$.ajax({
			url: url,
			type: "POST",
			data: data,
			dataType: "text",
			success: function(result){
				//console.log(result);return;
				if(result=='sukses'){
					alert('Data inputan form sukses disimpan.');
					var idkry=$("#idkry").val();
					onloadHandler();
					setSoal(idkry);
				}
				
			}
		})
}
function onloadHandler() {
	getData(1)
}
function getData(hal){
	curHal=hal;
	cariData(hal);
}
function cariData(hal){
	var url = 'paformolds/getData';

	$.ajax({
		url: url,
		type: "POST",
		data: ({hal:hal}),
		dataType: "text",
		success: function(result){
			if(result=='close'){
				document.getElementById('txtPeriode').innerHTML ='Periode penilaian tahun ini belum dibuka';
				return
			}
			//console.log(result);
			result=result.split("^");
			$('#tblkaryawan').children('thead:first').html(result[0]);
			$('#tblkaryawan').children('tbody:first').html(result[1]);
			if(result[2].trim().length!=0){
				document.getElementById('linkHal').style.display='';
				document.getElementById('linkHal').innerHTML=result[2];
			}else{
				document.getElementById('linkHal').style.display='none';
			}
			document.getElementById('txtPeriode').innerHTML =result[3];
			document.getElementById('periode').value=result[4];
			document.getElementById('nikuser').value=result[5];
			document.getElementById('namauser').value=result[6];
			document.getElementById('iduser').value=result[7];
		}
	})
}

function getPeriode(){
	var url = 'paformolds/getData';
	$.ajax({
		url: url,
		type: "POST",
		data: ({hal:hal}),
		dataType: "text",
		success: function(result){

		}
	})
}
function setSoal(idkry){
	var url="paformolds/setsoal";
	var periode=$("#periode").val();
	$("#txtNik").text('');
	$("#txtNama").text('');
	$("#txtTglMsk").text('');
	$("#txtJabatan").text('');
	$("#txtStatus").text('');
	$('#formPenilaian').html('');
	$("#nikkry").val('');
	$("#namakry").val('');
	$.ajax({
		url: url,
		type: "POST",
		data: ({periode:periode,idkry:idkry}),
		dataType: "text",
		success: function(result){
			//console.log(result);return
			if(result==''){
				alert('data masih kosong');
				return
			}
			result = result.split('^');
			var datakaryawan=result[0].split('~');
				$("#txtNik").text(datakaryawan[1]);
				$("#txtNama").text(datakaryawan[2]);
				$("#txtTglMsk").text(datakaryawan[3]);
				$("#txtJabatan").text(datakaryawan[4]);
				$("#txtStatus").text('');
				$('#formPenilaian').html(result[1]);
				$("#idkry").val(datakaryawan[0]);
				$("#nikkry").val(datakaryawan[1]);
				$("#namakry").val(datakaryawan[2]);
				$("#detailSoal").show();
		}
	})
}
function tes(val,id){
	//alert(id)
	document.getElementById('valueTp'+id).value="";
	document.getElementById('valueTp'+id).value=val;
}
function pilih(val,id){
	//alert(id)
	document.getElementById('soalUraian'+id).value="";
	document.getElementById('soalUraian'+id).value=val;
}