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
	var txtSupplier=document.getElementById('txtSupplier').value;
	cariData(txtSupplier,hal);
}
function cariData(txtSupplier,hal){
	var getFilter=document.getElementById('getFilter').value;
	// subDivisi='';
	// if(document.getElementById('divId').value=='2'){
	// 	subDivisi=obj_caller.document.getElementById('subDivisi').value;
	// 	}
	// 	prodDivisiLain=document.getElementById("prodDivisiLain").checked;
	var url = 'mastersuppliers/getData';
	//call jQuery AJAX function
	$.ajax({
		url: url,
		type: "POST",
		data: ({txtSupplier:txtSupplier,getFilter:getFilter,hal:hal}),
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
			//document.getElementById('txtSupplier').value="";
		}
	});	
}
 $(function() {
	$("#tabs").tabs();
});
 function addToSupp(){
 $("#btnAksi").val('');
 	var tambah=$("#addSupplier").val();
 	var supid='Null'
  	$("#btnAksi").val(tambah+"|"+supid);
	//alert('Tambah Supplier');
	var sURL = "popupmastersuppliers"//?";
	var oEls = document.forms["h1form"].elements
	for( var i=0; i < oEls.length; i++ ) {
		if( oEls[i].name =="btnAksi" ) {
			//sURL += escape(oEls[i].name) + "=" + escape(oEls[i].value) + "&";
		}
	}
	//sURL = sURL.substring(0, sURL.length - 1);
	var obj_calwindow = window.open(
		sURL,'Group','resizable=0,scrollbars=1,toolbar=0,directories=0,status=1,menubar=0,width=620,height=700,left=300,top=100'
	);
	obj_calwindow.opener = self;
	obj_calwindow.focus();
}
function updateToData(r){
$("#btnAksi").val('');
var update='Update'
var supid=r;
$("#btnAksi").val(update+"|"+supid);
	var sURL = "popupmastersuppliers"//?";
	var oEls = document.forms["h1form"].elements
	for( var i=0; i < oEls.length; i++ ) {
		if( oEls[i].name =="btnAksi" ) {
			//sURL += escape(oEls[i].name) + "=" + escape(oEls[i].value) + "&";
		}
	}
	//sURL = sURL.substring(0, sURL.length - 1);
	var obj_calwindow = window.open(
		sURL,'Group','resizable=0,scrollbars=1,toolbar=0,directories=0,status=1,menubar=0,width=620,height=700,left=300,top=100'
	);
	obj_calwindow.opener = self;
	obj_calwindow.focus();
}