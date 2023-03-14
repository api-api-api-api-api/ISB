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
	var txtItemBarang=document.getElementById('txtItemBarang').value;
	cariData(txtItemBarang,hal);
}
function cariData(txtItemBarang,hal){
	var selectFilter = document.getElementById('selectFilter').value;
	var selectGroup = document.getElementById('group').value;
	//alert(selectGroup)
	// subDivisi='';
	// if(document.getElementById('divId').value=='2'){
	// 	subDivisi=obj_caller.document.getElementById('subDivisi').value;
	// 	}
	// 	prodDivisiLain=document.getElementById("prodDivisiLain").checked;
	var url = 'masterbarangs/getData';
	//call jQuery AJAX function
	$.ajax({
		url: url,
		type: "POST",
		data: ({selectFilter:selectFilter,txtItemBarang:txtItemBarang,hal:hal,selectGroup:selectGroup}),
		dataType: "text",
		success: function(result){
		//console.log(result)
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
			//document.getElementById('txtItemBarang').value="";
		}
	});	
}
$(function() {
    $("#tabs" ).tabs();
});


// function edit(data){
// 	var r=data;
// 	document.getElementById('btnUpdate'+r).style.display='block';
// 	document.getElementById('btnBatal'+r).style.display='block';
// 	document.getElementById('btnEdit'+r).style.display='none';
// 	$('.btnEdit').prop('disabled', true);
// 	$('.lbl'+r).hide();
// 	$('#namaBrg'+r).show();
// 	$('#postId'+r).show();
// }
// function batal(data){
// 	var r=data;
// 	document.getElementById('btnUpdate'+r).style.display='none';
// 	document.getElementById('btnBatal'+r).style.display='none';
// 	document.getElementById('btnEdit'+r).style.display='block';
// 	$('.btnEdit').prop('disabled', false);
// 	$('.lbl'+r).show();
// 	$('#namaBrg'+r).hide();
// 	$('#postId'+r).hide();
// }
// function update(data){
// 	var r=data;
// 	var namaBrg=$('#namaBrg'+r).val(),
// 		postId=$('#postId'+r).val();
// 	if(namaBrg=='' || namaBrg==null){
// 		alert ('Nama barang masih kosong');
// 		$("#namaBrg").focus();
// 		return;
// 	}
// 	var cek=confirm('Cek kembali, Apakah data yang di inputkan sudah sesuai dan benar?');
// 	if(cek){
// 		var url = 'masterbarangs/update';
// 		$.ajax({
// 			url: url,
// 			type: "POST",
// 			data:({itemId:r,namaBrg:namaBrg,postId:postId}),
// 			success: function(result){
// 				//console.log(result)
// 				if (result=='sukses'){
// 					alert('Data Diupdate');
// 					$('form[name=masterBarangForm]').find("input[type=text]").val("");
// 					getData(1);
// 					batal(r);
// 				}
// 				//window.location.reload();
// 			}
// 		})
// 	}
	
// }
function addToBrg(){
	$("#btnAksi").val('');
 	var tambah=$("#addBarang").val();
	 var itemId='Null'
	 var group=$("#group").val();
	 
  	$("#btnAksi").val(tambah+"|"+itemId+"|"+group);
  	//alert('Tambah Data Item barang');
	var sURL = "popupmasterbarangs"//?";
	var oEls = document.forms["h1form"].elements
	for( var i=0; i < oEls.length; i++ ) {
		if( oEls[i].name =="btnAksi" ) {
			//sURL += escape(oEls[i].name) + "=" + escape(oEls[i].value) + "&";
		}
	}
	//sURL = sURL.substring(0, sURL.length - 1);
	var obj_calwindow = window.open(
		sURL,'Group','resizable=0,scrollbars=1,toolbar=0,directories=0,status=1,menubar=0,width=600,height=700,left=300,top=100'
	);
	obj_calwindow.opener = self;
	obj_calwindow.focus();
}
function updateToData(data){
	$("#btnAksi").val('');
	var update='Update'
	var itemId=data;
	var group=$("#group").val();
	$("#btnAksi").val(update+"|"+itemId+"|"+group);
	var sURL = "popupmasterbarangs"//?";
	var oEls = document.forms["h1form"].elements
	for( var i=0; i < oEls.length; i++ ) {
		if( oEls[i].name =="btnAksi" ) {
			//sURL += escape(oEls[i].name) + "=" + escape(oEls[i].value) + "&";
		}
	}
	//sURL = sURL.substring(0, sURL.length - 1);
	var obj_calwindow = window.open(
		sURL,'Group','resizable=0,scrollbars=1,toolbar=0,directories=0,status=1,menubar=0,width=600,height=700,left=300,top=100'
	);
	obj_calwindow.opener = self;
	obj_calwindow.focus();
	close();

}
function editTag(data){
	//let id=data;
	var maintenanceTag=$("#maintenanceTag").val();
	//alert(maintenanceTag+id)
	//show item form
	//$("#id"+maintenanceTag+id).show();
	$("#lbl"+maintenanceTag+data).hide();
	$("#idNama"+maintenanceTag+data).show();
	$("#btnEditTag"+maintenanceTag+data).hide();
	$("#btnSimpanTag"+maintenanceTag+data).show();
	$("#btnBatalTag"+maintenanceTag+data).show();
}
function batalTag(data){
	var maintenanceTag=$("#maintenanceTag").val();
	$("#lbl"+maintenanceTag+data).show();
	$("#idNama"+maintenanceTag+data).hide();
	$("#btnEditTag"+maintenanceTag+data).show();
	$("#btnSimpanTag"+maintenanceTag+data).hide();
	$("#btnBatalTag"+maintenanceTag+data).hide();
}
function simpanTag(data){
	var maintenanceTag=$("#maintenanceTag").val();
	var id=$("#txtid"+maintenanceTag+data).val();
	var nama=$("#idNama"+maintenanceTag+data).val();
	//alert(maintenanceTag+id+nama);return
	var url="masterbarangs/updateTag";
	$.ajax({
		url: url,
		type: "POST",
		data: ({maintenanceTag:maintenanceTag,id:id,nama:nama}),
		dataType: "text",
		success: function(result){
		console.log(result);return
		
		}
	});	
}
function kategoriData(){
	$("#myModal").modal('show');
	$(".clsJenis").hide();
	$(".clsKategori").show();
	$("#maintenanceTag").val('kategoriData');
	$("#myModalLabel").text('Maintenance Kategori Barang')
	getDataModal(1)
}
function jenisData(){
	$("#myModal").modal('show');
	$(".clsKategori").hide();
	$(".clsJenis").show();
	$("#maintenanceTag").val('jenisData');
	$("#myModalLabel").text('Maintenance Jenis Barang');
	getDataModal(1)
}
function getDataModal(hal){
var maintenanceTag=document.getElementById('maintenanceTag').value;
var url = 'masterbarangs/getDataModal';
	//call jQuery AJAX function
	$.ajax({
		url: url,
		type: "POST",
		data: ({maintenanceTag:maintenanceTag,hal:hal,fungsi:'getDataModal'}),
		dataType: "text",
		success: function(result){
		//console.log(result);return
		result=result.split("!");
		//alert(returnedVal[2])
			$('#tableIsi').children('thead:first').html(result[0]);
			$('#tableIsi').children('tbody:first').html(result[1]);
			if(result[2].trim().length!=0){
					document.getElementById('linkHal1').style.display='';
					document.getElementById('linkHal1').innerHTML=result[2];
				}else{
					document.getElementById('linkHal1').style.display='none';
				}
			document.getElementById('txtItemBarang').value="";
		}
	});	


}

function close_window() {
  if (confirm("Close Window?")) {
    close();
  }
}

// function simpanData(){
// 	if($("#namaBrg").val()==''||$("#namaBrg").val()==null){
// 		alert ('Nama barang masih kosong');
// 		$("#namaBrg").focus();
// 		return;
// 	}
// 	// if($("#kategoriBrg").val()==''||$("#kategoriBrg").val()==null){
// 	// 	alert ('kategori barang masih kosong');
// 	// 	$("#kategoriBrg").focus();
// 	// 	return;
// 	// }
// 	// if($("#jenisBrg").val()==''||$("#jenisBrg").val()==null){
// 	// 	alert ('Jenis barang masih kosong');
// 	// 	$("#jenisBrg").focus();
// 	// 	return;
// 	// }
// 	// if($("#editAbleVal").val()==''||$("#kategoriBrg").val()==null){
// 	// 	alert ('Editable value masih kosong');
// 	// 	$("#editAbleVal").focus();
// 	// 	return;
// 	// }
// 	var cek=confirm('Cek kembali, Apakah data yang di inputkan sudah sesuai dan benar?');
// 	if(cek){
// 		var data = $("form[name=masterBarangForm]").serializeArray();
// 		var url = 'masterbarangs/simpanData';
// 		//console.log(data);
// 		$.ajax({
// 			url: url,
// 			type: "POST",
// 			data:data,
// 			success: function(result){
// 				console.log(result)
// 				if (result=='sukses'){
// 					alert('Data Disimpan');
// 					$('form[name=masterBarangForm]').find("input[type=text]").val("");
// 					getData(1);
// 				}
// 				//window.location.reload();
// 			}
// 		})
// 	}
// }