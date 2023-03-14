var noerf_public;
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
    $("#tbodyPelamar").on('click','.btnGetRekomendasi',function(e){
        var idLink=$(this).attr('data-id');
        var nomorErf=$(this).attr('data-erf');
        //alert(nomorErf)
        $("#tampilRekomendasiBalik").html("");
        $("#tampilRekomendasiBalik").hide();
        var url = 'Erfapprovalhrds/getDetilRekomendasi';
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            data:({idLink:idLink,nomorErf:nomorErf}),
            async:false, 
            success: function(returnedVal){
                
                $("#tampilRekomendasiBalik").html(returnedVal);
                $("#tampilRekomendasiBalik").slideDown("slow");
                //console.log(returnedVal)
            }
        })
    })       
})

function hirarkiatasan(){
    var url = 'Erfapprovalhrds/hirarkiatasan';
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


function datapelamar(nomorErf){
    var url = 'Erfapprovalhrds/dataPelamar';
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            data:{nomorErf:nomorErf},
            success: function(result){
            result=result.split("^");
            if(result[1]=='ada'){
                $("#btnPenyelesaian").prop('disabled',false);
                $("#inputTanggalMasuk").prop('disabled',false);
            }else{
                $("#btnPenyelesaian").prop('disabled',true);
                $("#inputTanggalMasuk").prop('disabled',true);
            }             
            $("#tbodyPelamar").html(result[0]);
            
            $(".inputTanggalMasuk").datepicker({
                setDate: new Date(),           
                firstDay: 1,
                defaultDate: "d",
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                autoclose: true,
                onSelect: function( selectedDate,inst ) {
                    //getData();
                    
                }
            }).keyup(function(e) {
                if(e.keyCode == 8 || e.keyCode == 46) {
                    $.datepicker._clearDate(this);
                    //$("#endDate" ).val('');
                }
            });
        }
  });  
}

function tambahPelamar(){
$('#modalPelamar').modal('show');
$('#modalPermintaan').modal('hide');


     var url = 'Erfapprovalhrds/listPelamar';
     var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            data:{nomorErf:noerf_public},
            success: function(result){
                //alert(result);
               
            $("#tbodyListPelamar").html(result);


        }
  }); 

}

function insertPelamar(idPelamar){
   
  var url = 'Erfapprovalhrds/insertPelamar';
     var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            data:{nomorErf:noerf_public,idErf:iderf_public,idPelamar:idPelamar},
            success: function(result){
            //console.log(result);return
            tambahPelamar();

        }
  }); 
}

function reopenModalApproval(){
    modalPermintaan(noerf_public);
}

function hapusPelamar(idlink){
    var url = 'Erfapprovalhrds/hapusPelamar';
    alert(iderf_public);return
    var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            data:{idlink:idlink,idErf:iderf_public},
            success: function(result){
                //alert(result);
               datapelamar(noerf_public);
               //tambahPelamar();


        }
  }); 
}

function ambilPermintaan(){
   // alert("aaaaaa");

     var url = 'Erfapprovalhrds/ambilPermintaan';
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
var keteranganApproval = $("#keteranganApproval_"+data).val();
var statusPengajuan = $("#statusPengajuan_"+data).val();

var tipeApproval = $("#tipeApproval_"+data).val();

if(tipeApproval=='Proses ERF HRD'){
$("#btnPembatalan").hide();
$("#btnPenyelesaian").show();
$("#btnTolak").hide();
$("#btnApprove").hide();
$("#btnTambahPelamar").show();
$("#tableTambahPelamar").show();
$("#tblTdd").hide();
}else if(tipeApproval=='Approval penyelesaian'){
$("#btnPenyelesaian").show();
$("#btnPembatalan").hide();
$("#btnTolak").hide();
$("#btnApprove").hide();
$("#btnTambahPelamar").hide();
$("#tableTambahPelamar").hide();
$("#tblTdd").hide();
}else{
$("#btnPenyelesaian").hide();
$("#btnPembatalan").show();
$("#btnTolak").hide();
$("#btnApprove").hide();
$("#btnTambahPelamar").hide();
$("#tableTambahPelamar").hide();
$("#tblTdd").hide();
}


noerf_public=nomorErf;
iderf_public=idErf;
var data_posisi=posisi;
if(posisi=="Lainnya"){
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
$("#txt_keteranganApproval").html(keteranganApproval);
datapelamar(nomorErf);

$("#tampilRekomendasiBalik").html(" klik feedback rekomendasi untuk melihat detail penilaian");
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


function pilihPelamar(data){
    //console.log(data);return
    var url = 'Erfapprovalhrds/pilihPelamar';
    var tanggalMasuk=$("input[name='inputTglMasuk"+data+"']").val();
    if(tanggalMasuk==''){
        alert('Jika terpilih inputkan tanggal masuk terlebih dahulu');
        $("input[name='inputTglMasuk"+data+"']").focus();
        $("#terpilih"+data).prop('checked',false);
        return
    };
    //console.log(tanggalMasuk);return;
    var dataCallback;
    $.ajax({
        url: url,
        type: "POST",
        dataType:"text",
        data:{idPelamarLink:data,tanggalMasuk:tanggalMasuk,terpilih:'ya'}, 
        success: function(result){
            if(result=='sukses'){
                alert('data berhasil disimpan');
                datapelamar(noerf_public);
            }else{
                alert('data gagal disimpan');
            }

        }
    });   

}


function tidakPilihPelamar(data){
    //console.log(data);return;
    var url = 'Erfapprovalhrds/pilihPelamar';
    var tanggalMasuk=$("input[name='inputTglMasuk"+data+"']").val();
    var dataCallback;
    $.ajax({
        url: url,
        type: "POST",
        dataType:"text",
        data:{idPelamarLink:data,tanggalMasuk:tanggalMasuk,terpilih:'tidak'}, 
        success: function(result){
            if(result=='sukses'){
                alert('data berhasil disimpan');
                datapelamar(noerf_public);
            }else{
                alert('data gagal disimpan');
            }
        }
    });   

}


function ambilhirarki(){

 var url = 'Erfapprovalhrds/ambilhirarki';
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

    /*
      if(document.getElementById('canvas__')!=='undefined' && document.getElementById('canvas__')!==null){      
            if(isCanvasBlank(document.getElementById('canvas__'))=='true'){
                  alert('Harap bubuhkan tanda tangan untuk approve data');
                  return;
                  }
                 
        }
        var isittd=document.getElementById('canvas__').toDataURL('image/jpeg');
        */

        var nomorErf = $("#txt_nomorErf").html();


    var url = 'Erfapprovalhrds/approve';
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

function penyelesaian(){
        /*
      if(document.getElementById('canvas__')!=='undefined' && document.getElementById('canvas__')!==null){      
            if(isCanvasBlank(document.getElementById('canvas__'))=='true'){
                  alert('Harap bubuhkan tanda tangan untuk approve data');
                  return;
                  }
        }
        var isittd=document.getElementById('canvas__').toDataURL('image/jpeg');
        */
    
    //var idLink      =$("input[name='optradio']:checked").val();
    
    var nomorErf    =$("#txt_nomorErf").html();
    var inputTanggalMasuk=$("#inputTanggalMasuk").val();

    // if(idLink=== undefined){alert("Pilih kandidat karyawan yang masuk");return;}
    // if(inputTanggalMasuk==''){
    //     alert("Tentukan tanggal masuk karyawan");
    //     $("#inputTanggalMasuk").focus();
    //     return;
    // }

    //terpilih tidak boleh kosong
    var cekTerpilih=document.getElementsByClassName('cekTerpilih');
    for(var i=0;i<cekTerpilih.length;i++){
        if(cekTerpilih[i].value==''){
            alert('Tiap pelamar yang direkomendasikan, harus ditentukan Terpilih/Tidak\nCheklist terpilih masih ada yang kosong!!!');
            return;
        }
        console.log(cekTerpilih[i].value)
    }
    //alert('tst')
    //return;
    
    var url = 'Erfapprovalhrds/penyelesaian';
    var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            data:{idErf:iderf_public,nomorErf:nomorErf}, 
            success: function(result){
            //console.log(result);return;
            if(result=='sukses'){
                alert('Pengajuan permintaan karyawan dengan nomor ('+nomorErf+') telah selesai');
                $('#modalPermintaan').modal('hide');
                ambilPermintaan();
            }
            
        }
  });   
}


function pembatalan(){

    /*
      if(document.getElementById('canvas__')!=='undefined' && document.getElementById('canvas__')!==null){      
            if(isCanvasBlank(document.getElementById('canvas__'))=='true'){
                  alert('Harap bubuhkan tanda tangan untuk approve data');
                  return;
                  }
                 
        }
        var isittd=document.getElementById('canvas__').toDataURL('image/jpeg');
        */
        var nomorErf = $("#txt_nomorErf").html();

    var url = 'Erfapprovalhrds/pembatalan';
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



function tolak(){

 var nomorErf = $("#txt_nomorErf").html();

    var url = 'Erfapprovalhrds/tolak';
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






function openDetil(pelamarId){
    $("#loading").fadeIn();
    $('#modalPermintaan').modal('hide');
    $('#modalLinkDetailPelamar').modal('show');
    //$('#iframeDetail').attr('src','about:blank'); 
    
    var urlDetilPelamar="http://is.bernofarm.com:8445/ISBerno/laporandatapelamars/detail?id="+pelamarId+"&jenis=html";
    $('#iframeDetail').attr('src', urlDetilPelamar); 
    
    // var url="Erfrekomendasibaliks/getUrlDetilKaryawan";
    // $.ajax({
    //     url:url,
    //     type:"POST",
    //     dataType:"Text",
    //     data:({urlDetilPelamar:urlDetilPelamar}),
    //     success: function(returnVal){
    //         console.log(returnVal);
    //         $("#cobaTampil").html(returnVal) 
    //     }
    // })    
}
function onLoadHandler(){
    $("#loading").fadeOut();
}


   
    


