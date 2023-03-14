// global the manage memeber table 
   
    $(document).ready(function(){

$("#permintaansetuju").keyup(function(){
  var jmlpermintaan = $("#permintaansetuju").val();
if(jmlpermintaan==="0"){
$("#statusorder").html("ditolakGA");
$("#permintaankurang").html("0");
}else{
 $("#statusorder").html(""); 
 $("#permintaankurang").html("");
}
})
////////////////// end keyup
$("#jumlahalokasi").keyup(delay(function (e) {
  //var jmlpermintaan = $("#permintaansetuju").val();
  var jmlpermintaan = $("#jumlahpermintaan").html();
  var stktersedia = $("#stoktersedia").html();
  var jmlalokasi = $("#jumlahalokasi").val();

var alokasisebagian1 = jmlpermintaan - jmlalokasi;
//alert(alokasisebagian1);

if(parseInt(jmlalokasi)>parseInt(jmlpermintaan)){
alert("alokasi stok melebihi permintaan");
$("#permintaankurang").html("");
  $("#statusorder").html("");
  ///////---
}else if(parseInt(jmlpermintaan)===parseInt(jmlalokasi)){

$("#statusorder").html("dialokasikeseluruhan");
$("#permintaankurang").html("0");

  ///////---
}else if(parseInt(jmlalokasi)==="0"){
$("#statusorder").html("disetujuikeseluruhan");
$("#permintaankurang").html(jmlpermintaan);
  ///////---
}else if(parseInt(jmlalokasi)>parseInt(stktersedia)){
$("#jumlahalokasi").val(stktersedia);
alert("maksimal stok di alokasi:"+stktersedia);
$("#permintaankurang").html("");
  $("#statusorder").html("");
}else{

  $("#permintaankurang").html(alokasisebagian1);
  $("#statusorder").html("dialokasisebagian");
  ///////---
}
/*
if(jmlalokasi>stktersedia){
$("#jumlahalokasi").val(stktersedia);
alert("maksimal stok di alokasi:"+stktersedia);
$("#permintaankurang").html("");
  $("#statusorder").html("");
  }
*/
},500));
////////////////// end key up
$("#btntolak").click(function(){
$("#permintaankurang").html("0");
  $("#statusorder").html("ditolakGA");
})


//////////////
    var url = 'verifikasigas/getData';

    $.ajax({
      url: url,
      type: "POST",

      success: function(output){
 
          $("#isitbl").html(output);
          }
    });  
    //////////////
      });  

function alokasi(data){





  var idpermintaan2 = "";
  var notranspermintaan2 = "";
  var tanggal = "";
  var karyawan = "";
  var barang = "";
  var jumlah = "";
  var spermintaan  = "";
  var nik = "";
  var harga = "";
  var lokasibarang = "";
  var kodebarang = "";
  var jenispermintaan = "";


   idpermintaan2 = $("#link"+data).attr("data-permintaanid");
  notranspermintaan2 = $("#link"+data).attr("data-notranspermintaan");
  tanggal = $("#link"+data).attr("data-tanggalpermintaan");
   karyawan = $("#link"+data).attr("data-namakaryawan");
  barang = $("#link"+data).attr("data-namabarang");
  jumlah = $("#link"+data).attr("data-jumlahpermintaan");
   spermintaan = $("#link"+data).attr("data-spermintaan");
   nik = $("#link"+data).attr("data-nik");
  namadivisi = $("#link"+data).attr("data-namadivisi");
  harga = $("#link"+data).attr("data-harga");
   lokasibarang = $("#link"+data).attr("data-slokasibarang");
  kodebarang = $("#link"+data).attr("data-masterbarangid");
  jenispermintaan = $("#link"+data).attr("data-jenispermintaan");
  //alert($("#idpermintaan"+data).val());

    $("#notranspermintaan2").val(notranspermintaan2);
    $("#idpermintaan2").val(idpermintaan2);
    $("#tanggalpermintaan").html(tanggal);
    $("#namapeminta").html(karyawan);
    $("#barangpermintaan").html(barang);
    $("#jumlahpermintaan").html(jumlah);
    $("#stoktersedia").html(spermintaan);
    $("#nik2").val(nik);
    $("#namadivisi2").val(namadivisi);
    $("#harga2").val(harga);
    $("#lokasibarang2").val(lokasibarang);
    $("#kodebarang2").val(kodebarang);
    $("#jenispermintaan2").val(jenispermintaan);
}

function delay(fn, ms) {
  let timer = 0
  return function(...args) {
    clearTimeout(timer)
    timer = setTimeout(fn.bind(this, ...args), ms || 0)
  }
}

function okproses(){
   var url = 'verifikasigas/okProses';

   var pidpermintaan = $("#idpermintaan2").val();
   var pstatusorder = $("#statusorder").html();
   var pnotranspermintaan = $("#notranspermintaan2").val();
   var pnik = $("#nik2").val();
   var pnamadivisi = $("#namadivisi2").val();
   var pharga = $("#harga2").val();

   var pnamakaryawan = $("#namapeminta").html();
   var pnamabarang = $("#barangpermintaan").html();
   var pjumlahpermintaan = $("#jumlahpermintaan").html();
   var pstoktersedia = $("#stoktersedia").html();

   var ppermintaankurang = $("#permintaankurang").html();
   var pjumlahalokasi = $("#jumlahalokasi").val();
   var plokasibarang = $("#lokasibarang2").val();

   var pkodebarang = $("#kodebarang2").val();
   var pjenispermintaan = $("#jenispermintaan2").val();
   var pjumlahpo = $("#permintaankurang").html();

    $.ajax({
      url: url,
      type: "POST",
      data: {jumlahpo:pjumlahpo,jenispermintaan:pjenispermintaan,kodebarang:pkodebarang,lokasibarang:plokasibarang,jumlahalokasi:pjumlahalokasi,permintaankurang:ppermintaankurang,namakaryawan:pnamakaryawan,namabarang:pnamabarang,jumlahpermintaan:pjumlahpermintaan,stoktersedia:pstoktersedia,idpermintaan:pidpermintaan,statusorder:pstatusorder,notranspermintaan:pnotranspermintaan,nik:pnik,namadivisi:pnamadivisi,harga:pharga},
      success: function(output){
          alert(output);
             $('#formalokasi').modal('toggle');
             loadlagi();
          }
    });  
}

function loadlagi(){
      var url = 'verifikasigas/getData';

    $.ajax({
      url: url,
      type: "POST",

      success: function(output){
 
          $("#isitbl").html(output);
          }
    });  
}

function detailpermintaan(data){
  var notranspermintaan = $("#detail"+data).attr("data-notranspermintaan");
  
  var url = 'verifikasigas/getData2';
    $.ajax({
      url: url,
      type: "POST",
      data:{notranspermintaan:notranspermintaan},
      success: function(output){
 
          $("#isipermintaan").html(output);
          }
    });  
    
}