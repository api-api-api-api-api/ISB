$(document).ready(function () {
	onLoadHandler();
	
	$("#tableA").on('click','tr',function(){
		// get the current row
		var currentRow=$(this).closest("tr"); 
		var col1=currentRow.find("td:eq(0)").text(); // get current row 1st TD value
		$('.choose').removeAttr("style");
		$("#tr"+col1).css("background-color", "#ff6f61");
		$("#tr"+col1).css("color", "#ffffff");
		getJenis(col1)
		
	});
	
});
function onLoadHandler() {
	getKategori();
	getJenis('');
}
function getKategori(){
    var url = 'Masterjeniskategorigroups/getKategori';
    var txtKategori=document.getElementById('txtKategori').value;
    $.ajax({
		url: url,
		type: "POST",
		data: ({txtKategori:txtKategori}),
		dataType: "text",
		success: function(result){
		//console.log(result)
		result=result.split("!");
		// //alert(returnedVal[2])
		$('#tableA').children('thead:first').html(result[0]);
		$('#tableA').children('tbody:first').html(result[1]);
			 document.getElementById('txtKategori').value="";
		$(".delKategori").hide();
		$("#btnEdit").hide();
		//$('#tableA tr').last().css("background-color", "#ff6f61");
		//$('#tableA tbody').children('tr:last td:first').focus();
		var rowpos = $('#tableA tr:last').position();
		$('#tableA tbody').scrollTop(rowpos.top);
		$('#tableA tr:last').css("background-color", "#ff6f61");
		$('#tableA tr:last').css("color", "#ffffff");
		console.log(rowpos)
		}
	});	
}
function getJenis(id){
	const katId=id;
	var url = 'Masterjeniskategorigroups/getJenis';
    //var txtKategori=document.getElementById('txtJenis').value;
    $.ajax({
		url: url,
		type: "POST",
		data: ({katId:katId}),
		dataType: "text",
		success: function(result){
		//console.log(result)
		result=result.split("!");
		// //alert(returnedVal[2])
		$('#tableB').children('thead:first').html(result[0]);
		$('#tableB').children('tbody:first').html(result[1]);
		 	//document.getElementById('txtKategori').value="";	
		}
	});	
}

function addKat() {
	$("#h1form").toggle();
}
function simpan(){
	alert('test')
	$("#h1form").hide()
	onLoadHandler();
}
function editKat(){
	$("#btnEdit").hide();
	$("#btnDel").show();
	$(".editKat").show();
	$(".delKategori").hide();
	$(".editKategori").show();
}
function delKat(){
	$("#btnDel").hide();
	$("#btnEdit").show();
	$(".editKat").show();
	$(".editKategori").hide();
	$(".delKategori").show();
}
function editLinkKat(i){
	$('#h1form').show();
	$('#txtKatId').val(i);
	$('#txtKatInput').val($('#txtNamaKat'+i).text());
}

