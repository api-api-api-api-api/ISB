var iderf_public;
$(document).ready(function(){

            $('.sigPad').signaturePad({
        drawOnly:true,
        drawBezierCurves:true,
        lineTop:200
    });
//hirarkiatasan();
ambilPermintaan();
//ambilhirarki();


       
})

function hirarkiatasan(){
    
        var url = 'Erfapprovalatasans/hirarkiatasan';
     var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            async:false, 
            success: function(result){
            alert(result);
               
            //$("#tbodyPeminjaman").html(result);


        }
  });  
}

function ambilPermintaan(){
   // alert("aaaaaa");
    
     var url = 'Erfapprovalatasans/ambilPermintaan';
     var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            async:false, 
            success: function(result){
                //alert(result);
               
            $("#tbodyPeminjaman").html(result);


        }
  }); 
}

function modalPermintaan(data){
$('#modalPermintaan').modal('show');
var idErf = $("#idErf_"+data).val();
var nomorErf = $("#nomorErf_"+data).val();
var tglPengajuan = $("#tglPengajuan_"+data).val();
var pemohon = $("#pemohon_"+data).val();
var divisi = $("#divisi_"+data).val();
var jabatan = $("#jabatan_"+data).val();
var dasarPermintaan = $("#dasarPermintaan_"+data).val();
var posisi = $("#posisi_"+data).val();
var tglDibutuhkan = $("#tglDibutuhkan_"+data).val();
var posisilainnya = $("#posisilainnya_"+data).val();
var statusKaryawan = $("#statusKaryawan_"+data).val();
var ketStatusKaryawan = $("#ketStatusKaryawan_"+data).val();
var jenisKelamin = $("#jenisKelamin_"+data).val();
var pendidikan = $("#pendidikan_"+data).val();
var pendidikanLain = $("#pendidikanLain_"+data).val();
var pengalamanKerja = $("#pengalamanKerja_"+data).val();
var pengalamanSecara = $("#pengalamanSecara_"+data).val();
var penguasaanBahasa = $("#penguasaanBahasa_"+data).val();
var penempatan = $("#penempatan_"+data).val() +"/"+ $("#penempatanDetail_"+data).val();
var penempatanDetail = $("#penempatanDetail_"+data).val();
var keterampilan = $("#keterampilan_"+data).val();
var keterampilanLain = $("#keterampilanLain_"+data).val();
var persyaratanLainnya = $("#persyaratanLainnya_"+data).val();
var ttjOrlainnya = $("#ttjOrlainnya_"+data).val();
var statusPengajuan = $("#statusPengajuan_"+data).val();
iderf_public=idErf;
var data_posisi=posisi;
if(posisi==""){
data_posisi=posisilainnya;
}

var data_waktukerja=statusKaryawan;
if(statusKaryawan=="Kontrak / Contract"){
data_waktukerja=statusKaryawan+" "+ketStatusKaryawan;
}

var data_pendidikanpelamar=pendidikan;
if(pendidikan==""){
data_pendidikanpelamar=pendidikanLain;
}

var data_penempatan=penempatan+" "+penempatanDetail;

var data_keterampilan=keterampilan+","+keterampilanLain;


$("#txt_nomorErf").html(nomorErf);
$("#txt_tglPengajuan").html(tglPengajuan);
$("#txt_pemohon").html(pemohon);
$("#txt_divisi").html(divisi);
$("#txt_jabatan").html(jabatan);
$("#txt_dasarPermintaan").html(dasarPermintaan);
$("#txt_posisi").html(data_posisi);
$("#txt_tglDibutuhkan").html(tglDibutuhkan);
$("#txt_statusKaryawan").html(data_waktukerja);
$("#txt_jenisKelamin").html(jenisKelamin);
$("#txt_pendidikan").html(data_pendidikanpelamar);
$("#txt_pengalamanKerja").html(pengalamanKerja);
$("#txt_pengalamanSecara").html(pengalamanSecara);
$("#txt_penguasaanBahasa").html(penguasaanBahasa);
$("#txt_penempatan").html(data_penempatan);
$("#txt_keterampilan").html(data_keterampilan);
$("#txt_persyaratanLainnya").html(persyaratanLainnya);
$("#txt_ttjOrlainnya").html(ttjOrlainnya);

//alert(nomorErf);
//$('#modalPermintaan').modal('show');
}

/*

function approve(data){

if (confirm('approve data?')) {
   
} else {
    alert('konfirmasi di batalkan');
    return;
}

var idBpkb = $("#idBpkb_"+data).val();
var idPeminjaman = $("#idPeminjaman_"+data).val();
var statusPeminjaman = $("#statusPeminjaman_"+data).val();
var keperluan = $("#keperluan_"+data).val();



}
*/




function ambilhirarki(){

 var url = 'Erfapprovalatasans/ambilhirarki';
    var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            async:false,
            data:({
 
                }),  
            success: function(result){
           
            if(result!="GA MANAGER"){
                $("#tblApprovals").css("display", "none");
            }


        }
  });   
}

 function isCanvasBlank(canvas) {
    isBlank='true';

    dataCanvas=canvas.getContext('2d').getImageData(0, 0, canvas.width, canvas.height).data;
    dataCanvas=dataCanvas.filter((v, i, a) => a.indexOf(v) === i); 
    for(i=0;i<dataCanvas.length;i++){
        if(dataCanvas[i]!='255' && dataCanvas[i]!='222' && dataCanvas[i]!='204')
    {isBlank='false';break} 
        }

return isBlank;
}


function approve(){

      if(document.getElementById('canvas__')!=='undefined' && document.getElementById('canvas__')!==null){      
            if(isCanvasBlank(document.getElementById('canvas__'))=='true'){
                  alert('Harap bubuhkan tanda tangan untuk approve data');
                  return;
                  }
                 
        }
        var isittd=document.getElementById('canvas__').toDataURL('image/jpeg');
        var nomorErf = $("#txt_nomorErf").html();

    var url = 'Erfapprovalatasans/approve';
    var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            data:{idErf:iderf_public,nomorErf:nomorErf,isittd:isittd}, 
            success: function(result){
           
            alert(result);
            $('#modalPermintaan').modal('hide');
            ambilPermintaan();


        }
  });   
}



function tolak(){

 var nomorErf = $("#txt_nomorErf").html();

    var url = 'Erfapprovalatasans/tolak';
    var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            data:{idErf:iderf_public,nomorErf:nomorErf}, 
            success: function(result){
           
            alert(result);
            $('#modalPermintaan').modal('hide');
            ambilPermintaan();


        }
  });   
}









   
    


