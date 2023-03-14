var serial=0;
var curHal=1;
$(document).ready(function () {
	onLoadHandler();
	var table = $('table.scroll'),
    bodyCells = table.find('tbody tr:first').children(),
    colWidth;

	// Adjust the width of thead cells when window resizes
	$(window).resize(function() {
    // Get the tbody columns width array
    colWidth = bodyCells.map(function() {
        return $(this).width();
    }).get();
    
    // Set the width of thead columns
    table.find('thead tr').children().each(function(i, v) {
        $(v).width(colWidth[i]);
    });    
	}).resize();
});
function onLoadHandler() {
	getData(1);
	getData2(1);
}
function getData(hal){
	curHal=hal;
	var txtJenis=document.getElementById('txtJenis').value;
	cariData(txtJenis,hal);
	getKategori();
	//$("#h1form").hide();
}
function getData2(hal){
	curHal=hal;
	var url = 'Masterjeniskategoris/getData2';
	var txtKategori=document.getElementById('txtKategori').value;
	$.ajax({
		url: url,
		type: "POST",
		data: ({txtKategori:txtKategori,hal:hal}),
		dataType: "text",
		success: function(result){
		console.log(result)
		result=result.split("!");
		// //alert(returnedVal[2])
		$('#tblDetil1').children('thead:first').html(result[0]);
		$('#tblDetil1').children('tbody:first').html(result[1]);
		 	if(result[2].trim().length!=0){
		 		document.getElementById('linkHal1').style.display='';
				document.getElementById('linkHal1').innerHTML=result[2];
		 		}else{
		 			document.getElementById('linkHal1').style.display='none';
		 		}
		 	document.getElementById('txtKategori').value="";	
			
		}
	});	
	//$("#h1form").hide();
}
function cariData(txtJenis,hal){
	var url = 'Masterjeniskategoris/getData';
	//call jQuery AJAX function
	$.ajax({
		url: url,
		type: "POST",
		data: ({txtJenis:txtJenis,hal:hal}),
		dataType: "text",
		success: function(result){
		//console.log(result)
		result=result.split("!");
		//alert(returnedVal[2])
			$('#tableA').children('thead:first').html(result[0]);
			$('#tableA').children('tbody:first').html(result[1]);
			if(result[2].trim().length!=0){
					document.getElementById('linkHal').style.display='';
					document.getElementById('linkHal').innerHTML=result[2];
				}else{
					document.getElementById('linkHal').style.display='none';
				}
			//
			document.getElementById('txtJenis').value="";	
			
		}
	});	
}


function getKategori(i){
	var url='Masterjeniskategoris/getKategori';
	$.ajax({
		url: url,
			type: "POST",
			dataType: "text",
		success:function(result){
			var textOption = $("select#txtKategoriInput");
			var text = "";
			textOption.html('');
			textOption.append('<option value="" selected >Pilih Kategori</option>');
			let sel = i;
			//console.log(result);
			$.each(JSON.parse(result), function(index, eachRow ) {
				//console.log(eachRow)
				if(eachRow["kategoribarangs"]["id"]==i){
					sel='selected';
					}else{
						sel='';
					}
					text='<option value='+eachRow["kategoribarangs"]["id"]+' '+sel+'>'+eachRow["kategoribarangs"]["nama"]+'</option>';
					textOption.append(text);	
			})			
		}
	})

}
function add(){
	$("#h1form").show("slow");
	$('#tblBtl').show();
	$('form[name="h1form"]').find("input[type=text]").val("");
	$('#txtKategoriInput').val("");
	$('.choose').removeAttr("style");

}
function edit(){
	$('.delJenis').hide();
	$('.editJenis').show();
	$('#tblBtl').show();
}
function del(){
	$('.editJenis').hide();
	$('.delJenis').show();
	$('#tblBtl').show();
}
function btl(){
	$("#h1form").hide("slow");
	$('.delJenis').hide();
	$('.editJenis').hide();
	$('.choose').removeAttr("style");
	$('#tblBtl').hide();
	$('form[name="h1form"]').find("input[type=text]").val("");
	$('#txtKategoriInput').val("");
}
function editLink(i){
	$('.choose').removeAttr("style");
	$("#tr"+i).css("background-color", "#ff6f61");
	$("#tr"+i).css("color", "#ffffff");
	//tampil form
	$('#h1form').show("slow");
	$('#txtJnsId').val(i);
	$('#txtJenisInput').val($('#txtNama'+i).text());
	$('#txtKategoriInput').val($('#txtkategoriId'+i).text());

}
function delLink(i){
	$('.choose').removeAttr("style");
	$("#tr"+i).css("background-color", "#ff6f61");
	$("#tr"+i).css("color", "#ffffff");
//mulai hapus
	var url='Masterjeniskategoris/delData'
	$.ajax({
		url:url,
			type:"POST",
			data:({id:i}),
			success:function(result){
				if(result=='Success'){
					getData(1);
				}else{
					alert('Delete failed')
					getData(1);
			}
		}
	})
}
function simpan(){
	var txtId = $('#txtJnsId').val();
	var txtJenisInput=$('#txtJenisInput').val();
	var txtKategoriInput=$('#txtKategoriInput').val();
	var url='Masterjeniskategoris/saveData';
	if(txtId==''){
		var mode='saveJenisInput';
	}else{
		var mode='updateJenisInput';
	}
	if(txtJenisInput==''){
		$("#txtJenisInput").focus();
	}else 
	if(txtKategoriInput==""){
		$("#txtKategoriInput").focus();
	}else{
		$.ajax({
			url:url,
			type:"POST",
			data:({txtId:txtId,txtJenisInput:txtJenisInput,txtKategoriInput:txtKategoriInput,mode:mode}),
			dataType:"text",
			success:function(returnedVal){
				//console.log(returnedVal)
				returnedVal=returnedVal.split("!");
				
				if(returnedVal[1]=="Error"){
					if(returnedVal[0]=='save'){
						alert("Simpan Gagal!!!")
					}else{
						alert("Update Gagal")
					}
					onLoadHandler();
					btl()
				}else{
					onLoadHandler();
					btl()
				}
			}
		})
	}
}

 // Trigger resize handler