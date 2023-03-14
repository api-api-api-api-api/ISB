$(document).ready(function(){
	onloadHandler();
})
function onloadHandler() {
	getData(1)
}
function getData(hal){
	curHal=hal;
	cariData(hal);
}
function cariData(hal){
	var url = 'Papersetujuankrys/getData';
	$.ajax({
		url: url,
		type: "POST",
		data: ({hal:hal}),
		dataType: "text",
		success: function(result){
			//console.log(result);return
			result=result.split("^");
		
			if(result[0]=='0'){
				document.getElementById('txtPeriode').innerHTML ='Belum ada periode penilaian';
				$("#Penilaian1").hide();
				$("#Penilaian2").hide();
				$("#Penilaian3").hide();
				$("#Penilaian4").hide();

				return;
			}
			$("#Penilaian1").show();
			$("#Penilaian2").show();
			$("#Penilaian3").show();
			$("#Penilaian4").show();
			document.getElementById('txtPeriode').innerHTML =result[0];
			document.getElementById('periode').value=result[1];
			$("#iduser").val(result[8]);
			$("#txtNik").text(result[2]);
			$("#nikkry").val(result[2]);
			$("#txtNama").text(result[3]);
			$("#namakry").val(result[3]);
			$("#txtTglMsk").text(result[4]);
			$("#txtJabatan").text(result[5]);
			$("#txtStatus").text('');
			$('#detailPenilaian').html(result[6]);
			$('#formKomentar').html(result[7]);
		}
	})
}

function tampilpenilaian(){
	var url = 'Papersetujuankrys/tampilpenilaian';
	$.ajax({
		url: url,
		type: "POST",
		data: ({hal:hal}),
		dataType: "text",
		success: function(result){
			console.log(result);
			
		}
	})
}
function simpan(){
	var komentar=$("#komentarKaryawan").val();
	if(komentar==''){
		$("#komentarKaryawan").focus()
		alert('isi komentar');
		return
	}
	var checkpersetujuan=$("#checkPersetujuan").val();
	if(checkpersetujuan==''){
		alert('Pilih persetujuan karyawan');
		$("#checkPersetujuan").focus()
		return
	}
	if(checkpersetujuan=='No'){
		if($("#keteranganKaryawan").val()==''){
			alert('Isi Keterangan');
			$("#keteranganKaryawan").focus();
			return
		}

	}
	var url="Papersetujuankrys/simpan";

	var data=$("#form1").serializeArray();
	$.ajax({
		url: url,
		type: "POST",
		data: data,
		dataType: "text",
		success: function(result){
			if(result=='sukses'){
				alert('Data berhasil disimpan')
				getData(1)
			}
			console.log(result);
			
		}
	})
}

function pilih(val){
	var value=val;
	$("#checkPersetujuan").val(value);
	//alert(val)
}