var serial=0;
var curHal=1;
$(document).ready(function (val) {
	$("#detailSoal").hide();
	onloadHandler();
	$("#tblkaryawan tbody").on('click','.tab',function() {
	$("#tblkaryawan tbody tr").removeClass("ativetab");
	var selected = $(this).addClass("ativetab");
	if(!selected)
	$(this).addClass("warning");
	var kryID=$(this).find("input[name=kryID]").val();
	var atasanSbg=$(this).find("input[name=atasanSbg]").val()
	var nikkry=$(this).find("input[name=tdnikkry]").val();
	var namakry=$(this).find("input[name=tdnamakry]").val();
	var tgllahirkry=$(this).find("input[name=tdtgllahirkry]").val();
	
	$("#sebagai").val(atasanSbg);
	//alert(atasanSbg);return
	setData(kryID,nikkry,namakry,tgllahirkry);
	//setData(kryID);
	});


	$("#form1").on('submit',function(e){
		
	})
	$("#btnsimpan").on('click',function(e){
		
	})

})

function onloadHandler() {
	getData(1)
}
function getData(hal){
	curHal=hal;
	cariData(hal);
}
function cariData(hal){
	var url = 'papersetujuans/getData';

	$.ajax({
		url: url,
		type: "POST",
		data: ({hal:hal}),
		dataType: "text",
		success: function(result){
			//console.log(result);return
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
			document.getElementById('tgllahiruser').value=result[7];
			document.getElementById('iduser').value=result[9];
		}
	})
}

function setData(kryID,nikkry,namakry,tgllahirkry){
	var url="papersetujuans/setData";
	var periode=$("#periode").val();
	var sebagai=$("#sebagai").val();
	$("#txtNik").text('');
	$("#txtNama").text('');
	$("#txtTglMsk").text('');
	$("#txtJabatan").text('');
	$("#txtStatus").text('');
	$('#formPenilaian').html('');
	$("#nikkry").val('');
	$("#namakry").val('');
	$("#tgllahirkry").val('');
	$.ajax({
		url: url,
		type: "POST",
		data: ({periode:periode,kryID:kryID,sebagai:sebagai,nikkry:nikkry,namakry:namakry,tgllahirkry:tgllahirkry}),
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
				$("#txtTglMsk").text(datakaryawan[4]);
				$("#txtJabatan").text(datakaryawan[5]);
				$("#txtStatus").text('');
				$('#detailPenilaian').html(result[1]);
				$("#idkry").val(datakaryawan[0]);
				$("#nikkry").val(datakaryawan[1]);
				$("#namakry").val(datakaryawan[2]);
				$("#tgllahirkry").val(datakaryawan[3]);
				$('#formKomentar').html(result[7]);
			$("#detailSoal").show();
		}
	})
}

function simpan(){
	var komentar=$("#komentar").val();
	if(komentar==''){
		$("#komentar").focus()
		alert('isi komentar');
		return
	}
	
	var url="papersetujuans/simpan";

	var data=$("#form1").serializeArray();
	$.ajax({
		url: url,
		type: "POST",
		data: data,
		dataType: "text",
		success: function(result){
			if(result=='sukses'){
				alert('Data berhasil disimpan')
				var nik=$("#nikkry").val();
					getData(1)
					setData(nik);
				
			}
			console.log(result);
			
		}
	})
}