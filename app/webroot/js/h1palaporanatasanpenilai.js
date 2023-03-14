var serial=0;
var curHal=1;
$(document).ready(function(e){
    onLoadHandler();
})

function onLoadHandler(){
    getData(1);
}
function getData(hal){
    curHal=hal;
    cariData(hal)
}

function cariData(hal){
	//var statusPeriode=$("#statusPeriode").val();
	//alert(statusPeriode)
    var url = 'palaporanatasanpenilais/getData';
	
    //call jQuery AJAX function
    $.ajax({
        url: url,
        type: "POST",
        data: ({hal:hal}),
        dataType: "text",
		async:false,
        success: function(result){
            $('#tabelLaporanAtasanPenilai').children('tbody:first').html(result);
        console.log(result);return
        result=result.split("^");
            $('#tabelLaporanAtasanPenilai').children('tbody:first').html(result[0]);
            if(result[1].trim().length!=0){
                    document.getElementById('linkHal1').style.display='';
                    document.getElementById('linkHal1').innerHTML=result[1];
            }else{
                    document.getElementById('linkHal1').style.display='none';
            }
        }
    }); 
}

function cetakexcel(){
    window.open("palaporanatasanpenilais/cetakexcel")
}
  