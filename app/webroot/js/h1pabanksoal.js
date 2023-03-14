  var txtKategoriAll;
  var tabaktif;
      var jmlbaris = 1;
 // var txtKategoriuraianAll;
  //var txtPeriodeAll;
  var kategoriawal;
  var kategoriaktif="";
  var counteditpilihansoal;
$(document).ready(function(){
  //console.log(getDivisi())
    getkategori();
    setkategori();
    getdata(1);
    getdata2(1);    


    getdatakategori();

    statusperiode();
    setAutocomplateDivisi('input');
    setAutocomplateJabatan('input');
  //  getkategoriuraian();
    //setkategoriuraian();
   //getperiode();
    //setperiode();
    //getperiode();
$("#btncancelkategori").hide();


    $("#tabel2").hide();


          $("#isitab1").show();
      $("#isitab2").hide();

  $("#tab1").click(function(){
       $('#tab2').removeClass('active');
      $('#tab1').addClass('active');
      $("#isitab1").show();
      $("#isitab2").hide();
      tabaktif = "pilihan";
       $("#tabel1").show();
       $("#tabel2").hide();
  });


  $("#tab2").click(function(){
    
       $('#tab1').removeClass('active');
      $('#tab2').addClass('active');
      $("#isitab1").hide();
      $("#isitab2").show();
      tabaktif = "uraian";
       $("#tabel1").hide();
       $("#tabel2").show();
  });



})


function statusperiode(){
   var url = 'pabanksoals/statusperiode';
          var jsonVal;
          $.ajax({
              url: url,
              type: "POST",
              dataType:"text",
              async:false,
              success: function(returnedVal){

                if(returnedVal=="EDITABLE"){
                  $(".stsperiode").removeAttr('disabled');
                }else{

                   $(".stsperiode").prop("disabled", true);
                }
       

                //alert(txtKategoriAll);

               
          }
    }); 


}



  function getkategori(){
    var url = 'pabanksoals/getkategori';
          var jsonVal;
          $.ajax({
              url: url,
              type: "POST",
              dataType:"text",
              async:false,
              success: function(returnedVal){

       
                txtKategoriAll=returnedVal;
                //alert(txtKategoriAll);

               
          }
    }); 


  }
/*
    function getkategoriuraian(){
    var url = 'banksoals/getkategoriuraian';
          var jsonVal;
          $.ajax({
              url: url,
              type: "POST",
              dataType:"text",
              async:false,
              success: function(returnedVal){


       
                txtKategoriAll=returnedVal;
                //alert(txtKategoriAll);

               
          }
    }); 


  }
*/


  function kategorijson(){

    

    var jsonVal=JSON.parse(txtKategoriAll); 
     return jsonVal; 
  }
/*

    function kategorijsonuraian(){

    var jsonVal=JSON.parse(txtKategoriuraianAll); 
     return jsonVal; 
  }
*/


  function setkategori(){



      var nmkategori;
     nmkategori=kategorijson();





      $("#kategori").html('');
      var autocomplete=new SelectPure("#kategori",{
          options:nmkategori,
          icon: "fa fa-times",
          autocomplete: true,
          placeholder: false,
          onChange:value=>{

               var splitkategori = value.split("^");
              $('#txtkategori').val(splitkategori[0]);
              $('#soalumumkhusus').val(splitkategori[1]);
              $('#bobottable').val(splitkategori[2]);
              if(splitkategori[0]!=''){
                liclick(splitkategori[0].toString().replace(/[^a-zA-Z0-9]/g, ''))
              }
              


          }
      })
  }


    function setkategoriganti(){



      var nmkategori;
     nmkategori=kategorijson();





      $("#spankategoriganti2").html('');
      var autocomplete=new SelectPure("#spankategoriganti2",{
          options:nmkategori,
          icon: "fa fa-times",
          autocomplete: true,
          placeholder: false,
          onChange:value=>{

               var splitkategori = value.split("^");
              $('#kategoriganti').val(splitkategori[0]);



          }
      })
  }


  function setkategoricopy(){



      var nmkategori;
     nmkategori=kategorijson();





      $("#spankategoricopy").html('');
        var autocomplete=new SelectPure("#spankategoricopy",{
          options:nmkategori,
          icon: "fa fa-times",
          autocomplete: true,
          placeholder: false,
          onChange:value=>{

               var splitkategori = value.split("^");
              $('#kategoricopy').val(splitkategori[0]);



          }
      })
  }

  

/*
  function editkategorijson(){



    var jsonVal=JSON.parse('[{"label":"Penialaian kinerja","value":"Penialaian kinerja"},{"label":"Penilaian","value":"Penilaian"},{"label":"","value":""}]'); 
     return jsonVal; 
  }

  function editsetkategori(){

      var nmkategori;
     nmkategori=editkategorijson();





      $("#kategori").html('');
      var autocomplete=new SelectPure("#kategori",{
          options:nmkategori,
          icon: "fa fa-times",
          autocomplete: true,
          placeholder: false,
          onChange:value=>{

              $('#txtkategori').val(value);



          }
      })
  }
*/
/*
  function getperiode(){
    var url = 'banksoals/getperiode';
          var jsonVal;
          $.ajax({
              url: url,
              type: "POST",
              dataType:"text",
              async:false,
              success: function(returnedVal){
             
                var tperiode = returnedVal.split("^");
                $("#periode").val(tperiode[1]);
                $("#txtperiode").val(tperiode[0]);
                //alert(txtKategoriAll);

               
          }
    }); 


  }
  */
 

  function tambahpilihansoal(){
    var isiansoal = $("#txtisiansoal").val();
    $("#panelisian").append(' <div class="panel-body" id="pilhanbaris_'+jmlbaris+'"> <table><tr><td> <button  onclick="deletepilihan('+jmlbaris+')">X</button></td><td> <div class="allsoalisian">'+isiansoal+'</div></td></tr></table></div>');
    jmlbaris = jmlbaris+1;
  }

  function deletepilihan(id){
      $("#pilhanbaris_"+id).remove();
  }




    function editsoal2(data){
    var xtxtsoal= $("#xtxtsoal_"+data).val();
    var xtxtpilihansoal= $("#xtxtpilihansoal_"+data).val();
    var xtxtid= $("#xtxtid_"+data).val();

    $("#xdivpilihansoal").html('');

    $("#xtxtideditpilihan").val(data);

    var splitpilihansoal= xtxtpilihansoal.split("@@");

    for (let i = 1; i < splitpilihansoal.length; i++) {
      $("#xdivpilihansoal").append('<div id="xeditpilihansoalsatuan_'+i+'"><table width="100%"><tr><td width="95%"><input type="text"  class="form-control editpilihansoal" name="" style="width: 100%" value="'+splitpilihansoal[i]+'"></td><td><font color="white">.</font></font><td><button style="height:30px;width:30px;border-radius: 25px;" onclick="xhapuspilihansatuan('+i+')"><font size="5">X</font></button></></tr><table><br></div>');
    }
    counteditpilihansoal = splitpilihansoal.length;

    $("#xtxteditsoal").val(xtxtsoal);

    $("#editmodal2").modal("show");
  }

  function xhapuspilihansatuan(data){
    $("#xeditpilihansoalsatuan_"+data).remove();
    counteditpilihansoal = counteditpilihansoal-1;
  }

  function edittambahpilihansoal(){
    var countsekarang = counteditpilihansoal+1;
    var pilihansoaltambah = $("#xtxttambahpilihan").val();
          $("#xdivpilihansoal").append('<div id="xeditpilihansoalsatuan_'+countsekarang+'"><table width="100%"><tr><td width="95%"><input type="text"  class="form-control editpilihansoal" name="" style="width: 100%" value="'+pilihansoaltambah+'"></td><td><font color="white">.</font></font><td><button style="height:30px;width:30px;border-radius: 25px;" onclick="xhapuspilihansatuan('+countsekarang+')"><font size="5">X</font></button></></tr><table><br></div>');
          counteditpilihansoal = countsekarang;
  }



function updatedatauraian(){

        //var periode= $("#txtperiode").val();
         var id= $("#xtxtideditpilihan").val();
         var soal= $("#xtxteditsoal").val();
         var allsoal="";

                     var inputs = $(".editpilihansoal");
            for(var i = 0; i < inputs.length; i++){
               
                allsoal=allsoal+"@@"+$(inputs[i]).val();

            }
            
      $('#xtxttambahpilihan').val('');
    


        var url ="pabanksoals/updatedatauraian";
                
        $.ajax({
            url:url,
            type:"POST",
            data: ({id:id,soal:soal,allsoal}),
            success:function(result){

                  alert(result);
                  //getdata(1);
                  getdata2(1);
            }
        })
    

}


 

  function hapussoal(data){
     var url = 'pabanksoals/hapussoal';
          var jsonVal;
          $.ajax({
              url: url,
              type: "POST",
              dataType:"text",
              data: ({id:data}),
              success: function(returnedVal){
                alert(returnedVal);



    getkategori();

    setkategori();

        getdata(1);
     
    statusperiode(); 


               
          }
    }); 
  }

  function liclick(data){
    kategoriaktif=data;
    //console.log(kategoriaktif)
    var liactive = data.toString().replace(/[^a-zA-Z0-9]/g, '');
    $(".trhasildata").hide();
    $(".trdata"+liactive).show();
    $(".lidi").removeClass("active");
    $("#lid"+liactive).addClass("active");
  }


  function hapussoal2(data){

     var url = 'pabanksoals/hapussoal2';
          var jsonVal;
          $.ajax({
              url: url,
              type: "POST",
              dataType:"text",
              data: ({id:data}),
              success: function(returnedVal){
                alert(returnedVal);


                    getdata(1);    
                    getdata2(1);

           
               
          }
    }); 
  }



  function tambahkategori(){



    var kategori = $("#txttambahkategori").val();
    var bobot = $("#txttambahbobotkategori").val();
   var tipesoal= $('input[name="tambahsoalumumkhusus"]:checked').val();




     var url = 'pabanksoals/savekategori';
          var jsonVal;
          $.ajax({
              url: url,
              type: "POST",
              dataType:"text",
              data: ({kategori:kategori,tipesoal:tipesoal,bobot:bobot}),
              success: function(returnedVal){
                alert(returnedVal);
                $("#tblperiode").html("");
   

     getkategori();

    setkategori();

        getdata(1);
 
cancelupdatekategori();

    getdatakategori();

    statusperiode(); 



                    //liclick('/'+kategori'/'); 



           
               
          }
    }); 
  }
  

function kategorisoal(){
  $("#kategorimodal").modal("show");
}



    function getproduk2(data){

           var txtcurrent = $('#txtnamaproduk'+data).val();
      
              var ini1 ='{"label":"'+txtcurrent+'","value":"'+txtcurrent+'"}';

              var rp1 = txtProdAll.replace('{"label":"-Please Select-","value":"^"}',ini1);

              jsonVal=JSON.parse(rp1);
     return jsonVal; 
  }


  /////////////////////////

  /*

  function getperiode(){
    var url = 'banksoals/getperiode';
          var jsonVal;
          $.ajax({
              url: url,
              type: "POST",
              dataType:"text",
              async:false,
              success: function(returnedVal){
       
                txtPeriodeAll=returnedVal;
                //alert(txtKategoriAll);

               
          }
    }); 


  }


  function periodeijson(){

    var jsonVal=JSON.parse(txtPeriodeAll); 
     return jsonVal; 
  }

  function setperiode(){

      var nmperiode;
     nmperiode=periodejson();

      $("#kategori").html('');
      var autocomplete=new SelectPure("#periode",{
          options:nmperiode,
          icon: "fa fa-times",
          autocomplete: true,
          placeholder: false,
          onChange:value=>{

              $('#txtkperiode').val(value);



          }
      })
  }
*/

function getdata(hal){
  $("#tblperiode").html("");
  //alert('test')
  var peruntukan=$('input[name="peruntukansoal"]:checked').val(); 
  var divisi=document.getElementById("txtdivisiInput").value;
  var jabatan=document.getElementById("txtjabatanInput").value;
  
  var url ="pabanksoals/getdatabaru";   
  $.ajax({
    url:url,
    type:"POST",
    data: ({fungsi:"getdata",hal:hal,peruntukan:peruntukan,divisi:divisi,jabatan:jabatan}),
    success:function(result){
      //console.log(result);
      returnedVal=result.split("@@");
      //console.log(result);return
      $("#tabel1").html(returnedVal[0]);
      if(kategoriaktif==""){
        liclick(returnedVal[1]);
        }else{
        liclick(kategoriaktif);
      }   
      // $("#linkHal").html(returnedVal[1]);
      statusperiode();
    }
  })

}

function getdata2(hal){

        var url ="pabanksoals/getdata2";
                
        $.ajax({
            url:url,
            type:"POST",
            data: ({fungsi:"getdata",hal:hal}),
            success:function(result){
               
                  returnedVal=result.split("!");
                //console.log(result);return
                $("#tblsoal2").html(returnedVal[0]);
                $("#linkHal2").html(returnedVal[1]);
                statusperiode();

            }
        })

}

function editkategori(data){
$("#btntekategori").html("UPDATE");
$("#btntekategori").attr("onclick","updatekategori()");
$("#btntekategori").attr('class', 'btn btn-success stsperiode');
var kategori = $("#txtedtkategori_"+data).val();
var bobot = $("#txtedtbobotkategori_"+data).val();
$("#btncancelkategori").show();
$("#txttambahkategori").val(kategori);
$("#txttambahbobotkategori").val(bobot);
kategoriawal=kategori;
}

function updatekategori(){
  var kategori = $("#txttambahkategori").val();
  var bobot = $("#txttambahbobotkategori").val();
  var url ="pabanksoals/updatekategori";
                            $.ajax({
                                url:url,
                                type:"POST",
                                data: ({kategori:kategori, kategoriawal:kategoriawal, bobot:bobot}),
                                success:function(result){
                                    alert(result);
                                                getkategori();

                                                setkategori();

                                                    getdata(1);
                                             


                                                getdatakategori();

                                                statusperiode(); 

                                            

                                           cancelupdatekategori();
                                }
                            })
}

function cancelupdatekategori(){
  $("#btncancelkategori").hide();
  $("#btntekategori").html("TAMBAH");
  $("#btntekategori").attr("onclick","tambahkategori()");
  $("#btntekategori").attr('class', 'btn btn-primary stsperiode');
  $("#txttambahkategori").val("");
}

function gantikategorisoal(data){
  setkategoriganti();
var kategori=$("#xtxtkategori_"+data).val();
$("#spankategoriganti1").html(kategori);
$("#txtidgantikategori").val(data);
$("#modalgantikategori").modal("show");
}



/*
function simpangantikategori(){


        var url ="pabanksoals/savedata";
                
        $.ajax({
            url:url,
            type:"POST",
            data: ({id:id,kategori:kategori}),
            success:function(result){
                  alert(result);
                 

            }
        })
}
*/

function simpangantikategori(){
  var id = $("#txtidgantikategori").val();
  var kategori = $("#kategoriganti").val();

          var url ="pabanksoals/simpangantikategori";
                
        $.ajax({
            url:url,
            type:"POST",
            data: ({kategori:kategori,id:id}),
            success:function(result){
                alert(result);
                //$("#modalgantikategori").modal("close");
                getdata(1);

  

            }
        })

}




function hapuskategori(id){
        var url ="pabanksoals/cekhapuskategori";
        $.ajax({
            url:url,
            type:"POST",
            data: ({id:id}),
            success:function(result){
                  var hasil = result.split("@@");
                 if(hasil[0]=="terhapus"){
                    alert("kategori berhasil di hapus");
                      getdatakategori();
                       getdata(1);
                 }else if(hasil[0]=="unset"){
                    if (confirm("unset semua soal dengan kategori ini?") == true) {
                         var url ="pabanksoals/hapuskategori";
                            $.ajax({
                                url:url,
                                type:"POST",
                                data: ({kategori:hasil[1]}),
                                success:function(result){
                                    alert(result);
                                         getkategori();

                                          setkategori();

                                              getdata(1);
                                       


                                          getdatakategori();

                                          statusperiode(); 

                                     
                                }
                            })
                      } else {
                        alert("Perintah hapus di batalkan");
                      }
                 }


            }
        })
}

function getdatakategori(){


        var url ="pabanksoals/getdatakategori";
                
        $.ajax({
            url:url,
            type:"POST",
            success:function(result){
               
                 // returnedVal=result.split("!");
                //console.log(result);return

                var dataini = result.split("@@");
                /*
                var arrKategori=dataini[1];
                var arrKategori2 ="";
                for (var i = dataini.length - 1; i >= 0; i--) {
                  arrKategori2=arrKategori2+arrKategori;
                  }
                  alert(darrKategori2);
                  */
        
                $("#tbodykategori").html(dataini[0]);

                /*
                $("#navkategori").html(dataini[1]);
                $(".trhasildata").hide();
                var datahide= dataini[2].replace(/[^a-zA-Z0-9]/g, '');
                 $(".trdata"+datahide).show();
                */

            }
        })

}
function isFloat(n){
  return Number(n) === n && n % 1 !== 0;
}

//simpan soal
function savedata(){

    //var periode= $("#txtperiode").val();
         var kategori= $("#txtkategori").val();
         
         var bobot= $("#bobot").val();
         var soal= $("#soal").val();
         //var soalumum= $("#soalumum").val();
         var soalumumkhusus= $('input[name="soalumumkhusus"]:checked').val();
         var peruntukansoal= $('input[name="peruntukansoal"]:checked').val(); 
         var bobottable= $("#bobottable").val();
         var divisi=$("#txtdivisiInput").val();
         var jabatan=$("#txtjabatanInput").val();
           // var soalumumkhusus= $("#soalumumkhusus").val();
        //alert(kategori);return
        //console.log(Number(bobot));return
      //console.log(isFloat(bobot));return

        if(kategori=='0' || kategori=='' ){
          alert("Harap isi kategori peruntukan soal");
          return;
        }
        if(kategori=='Pelaksanaan Pekerjaan (Job Implementation)'){
            if(divisi=='0' || divisi=='' ){
              alert("Harap isi divisi peruntukan soal");
              return;
            }
            if(jabatan=='0' || jabatan==''){
              alert("Harap isi jabatan peruntukan soal");
              return;
            }
            if(peruntukansoal=='all'){
              alert("Harap pilih peruntukan soal (marketing/non marketing)");
              return;
            }
        }
        if(bobot=='0' || bobot=='' ){
          alert("Harap isi bobot soal");
          $("#bobot").focus();
          return;
        }

        if(typeof bobot != 'number' && isNaN(bobot)){
          alert("Bobot harus berupa angka");
          $("#bobot").focus();
          return;
        } 
        //return
        if(soal=='0' || soal=='' ){
          alert("Harap isikan soal");
          $("#soal").focus();
          return;
        }
        
        

        var url ="pabanksoals/savedata";
                
        $.ajax({
            url:url,
            type:"POST",
            data: ({kategori:kategori,bobot:bobot,soal:soal,soalumumkhusus:soalumumkhusus,bobottable:bobottable,peruntukansoal:peruntukansoal,divisi:divisi,jabatan:jabatan}),
            success:function(result){
              //console.log(result);return
                alert(result);
                getkategori();
                setkategori();
                getdata(1);
                getdata2(1);    
                //setAutocomplateDivisi('input');
                //setAutocomplateJabatan('input')
                $("#bobot").val('');
                $("#soal").val('');
            }
        })
    

}
//edit soal


function editsoal(data){
    var periode = $("#periode_"+data).html();
    var kategori= $("#kategori_"+data).html();
    var tipesoal= $("#tipesoal_"+data).html();

    
    //alert($("#xtxtkategori_"+data).val());return
    //divisi dan jabatan soal
    var divisiId    = $("#divisi_"+data).html();
    var namaDivisi  = $("#divisiNama_"+data).html();
    var jabatanId   = $("#jabatan_"+data).html();
    var namaJabatan = $("#jabatanNama_"+data).html();
    $("#kategoriSoal").val("");
    if(divisiId=='' || namaDivisi==''){
      $("#txtdivisiEdit").val('');
    }else{
      $("#txtdivisiEdit").val(namaDivisi+'~'+divisiId);
    }

    if(jabatanId=='' || namaJabatan==''){
      $("#txtjabatanEdit").val('');
    }else{
      $("#txtjabatanEdit").val(namaJabatan+'~'+jabatanId);
    }

    //end divisi dan jabtan soal

  
    var soal= $("#soal_"+data).html();
    var peruntukansoal= $("#peruntukansoal_"+data).html();
    var bobot= $("#bobot_"+data).html();
    var id= $("#txtid_"+data).val();


    $("#txteditid").val(id);

    $("#txteditbobot").val(bobot);

    $("#txteditsoal").html(soal);

    $("#txteditperuntukan").val(peruntukansoal);

   
    if(tipesoal=="umum"){
      $('#epUmum').prop('checked',true);
      $('#epKhusus').prop('checked',false);
    }else{
      $('#epUmum').prop('checked',false);
      $('#epKhusus').prop('checked',true);
    }
    $("#kategoriSoal").val($("#xtxtkategori_"+data).val())
    if($("#xtxtkategori_"+data).val()=='Pelaksanaan Pekerjaan (Job Implementation)'){
      
      $("#editPeruntukan").show();
      $("#editDivisi").show();
      $("#editJabatan").show();
      if(peruntukansoal=="MARKETING"){
        $('#epmr').prop('checked',true);
        $('#epnonmr').prop('checked',false);
      }else{
        $('#epnonmr').prop('checked',true);
        $('#epmr').prop('checked',false);
      }
      setAutocomplateDivisi('edit');
      setAutocomplateJabatan('edit')
    }else{
      $("#editPeruntukan").hide();
      $("#editDivisi").hide();
      $("#editJabatan").hide();
    }
    
    $("#editmodal").modal("show");
}

function updatesoal(){
  var bobot = $("#txteditbobot").val();
  var soal = $("#txteditsoal").val();
  var id = $("#txteditid").val();
  var peruntukansoal= $('input[name="txteditperuntukansoal"]:checked').val();
  var txtdivisiEdit=$("#txtdivisiEdit").val();
  var txtjabatanEdit=$("#txtjabatanEdit").val();
  var kategoriSoal=$("#kategoriSoal").val()
  if(kategoriSoal=='Pelaksanaan Pekerjaan (Job Implementation)'){
    if(txtdivisiEdit=='0' || txtdivisiEdit=='' ){
      alert("Harap isi divisi peruntukan soal");
      return;
    }
    if(txtjabatanEdit=='0' || txtjabatanEdit==''){
      alert("Harap isi jabatan peruntukan soal");
      return;
    }
}
  var typeSoal= $('input[name="txteditsoalumumkhusus"]:checked').val();

  var url = 'pabanksoals/updatesoal';
        var jsonVal;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            data: ({id:id,bobot:bobot,soal:soal,peruntukansoal:peruntukansoal,txtdivisiEdit:txtdivisiEdit,txtjabatanEdit:txtjabatanEdit,typeSoal:typeSoal,kategoriSoal:kategoriSoal}),
            success: function(returnedVal){
              //console.log(returnedVal);return;
              alert(returnedVal);
  
              getkategori();
              setkategori();
              getdata(1);
              statusperiode(); 
             
        }
  }); 

}
//copy soal
function copysoal(data){
  setkategoricopy();
  var kategori= $("#xtxtkategori_"+data).val();
  var soal= $("#soal_"+data).html();
  var peruntukansoal= $("#peruntukansoal_"+data).html();
  var bobot= $("#bobot_"+data).html();
  var tipesoal= $("#tipesoal_"+data).html();
  var divisiId  = $("#divisi_"+data).html();
  var jabatanId = $("#jabatan_"+data).html();
  var namaDivisi  = $("#divisiNama_"+data).html();
  var namaJabatan = $("#jabatanNama_"+data).html();

  //alert(divisiId+"~"+jabatanId)
  $("#txtKategoriSoalCopy").val(kategori);
  $("#txtSoalCopy").val(soal);
  $("#txtPeruntukanCopy").val(peruntukansoal);
  $("#txtBobotCopy").val(bobot);
  $("#txtTipeCopy").val(tipesoal);
  $("#txtDivisiCopyView").val(namaDivisi);
  $("#txtJabatanCopyView").val(namaJabatan);
  $("#txtDivisiCek").val("");
  $("#txtDivisiCek").val(namaDivisi+"~"+divisiId);
  $("#txtJabatanCek").val("");
  $("#txtJabatanCek").val(namaJabatan+"~"+jabatanId);

  $("#txtidcopykategori").val(data);

  //set auto complate
  $("#txtdivisiCopy").val('');
  $("#txtjabatanCopy").val('');
  setAutocomplateDivisi('copy')
  setAutocomplateJabatan('copy')
  $("#modalcopy").modal("show");
}
function simpancopy(){
  var id = $("#txtidcopykategori").val();
  var divisiCek=$("#txtDivisiCek").val();
  var jabatanCek=$("#txtJabatanCek").val();
  var txtdivisiCopy=$("#txtdivisiCopy").val();
  var txtjabatanCopy=$("#txtjabatanCopy").val();
  
  // alert(divisiCek+jabatanCek);
  // alert(txtdivisiCopy+txtjabatanCopy);return
  if(divisiCek=='~'){
    alert('Data belum bisa dicopy, divisi dan jabatan soal masih kosong, harap isikan divisi dan jabatan terlebih dahulu dengan melakukan edit soal, terima kasih!!!');
    return
  }

  if(jabatanCek=='~'){
    alert('Data belum bisa dicopy, divisi dan jabatan soal masih kosong, harap isikan divisi dan jabatan terlebih dahulu dengan melakukan edit soal, terima kasih!!!');
    return
  }

  if(txtdivisiCopy=='0' || txtdivisiCopy=='' ){
    alert("Harap isi divisi peruntukan soal");
    return;
  }
  if(txtjabatanCopy=='0' || txtjabatanCopy=='' ){
    alert("Harap isi jabatan peruntukan soal");
    return;
  }

  if(divisiCek+jabatanCek==txtdivisiCopy+txtjabatanCopy){
    alert("harap isikan divisi dan jabatan  yang berbeda");
    return;
  }

  
  var kategori = $("#kategoricopy").val();
  var url ="pabanksoals/simpancopy";
                
        $.ajax({
            url:url,
            type:"POST",
            data: ({kategori:kategori,id:id,txtdivisiCopy:txtdivisiCopy,txtjabatanCopy:txtjabatanCopy}),
            success:function(result){
              //console.log(result);return
                alert(result);
                //$("#modalgantikategori").modal("close");
                getdata(1);

                $("#modalcopy").modal("hide");

            }
        })

}

function savedatauraian(){

        //var periode= $("#txtperiode").val();
         var soal= $("#soaluraian").val();
         var allsoal="";

                     var inputs = $(".allsoalisian");
            for(var i = 0; i < inputs.length; i++){
               
                allsoal=allsoal+"@@"+$(inputs[i]).html();

            }
      
    


        var url ="pabanksoals/savedatauraian";
                
        $.ajax({
            url:url,
            type:"POST",
            data: ({soal:soal,allsoal}),
            success:function(result){
              $("#soaluraian").val("");
              $("#nelisian").html("");
              $("#txtisiansoal").val("");
                  alert(result);
                  getdata(1);
                  getdata2(1);
            }
        })

}
function getDivisi(){
  var url = 'pabanksoals/getDivisi';
  var dataCallback;
      $.ajax({
          url: url,
          type: "POST",
          dataType:"text",
          data:({}),
          async:false,
          success: function(result){
          //console.log(result);return
          dataCallback=result;
          
      }
});   
 return dataCallback; 
}

// function setAutocomplateDivisi(event){
//     //camelCase(event);
//     var even = cptlFirsOneWord(event)
//     //console.log(even);return
//     var kodeDivisi=JSON.parse(getDivisi());
//     if(event=='input'){
//       var select="#divisiInput";
//       var divisiIsi='';
//     }
//     if(event=='edit'){
//       var select="#divisiEdit";
//       var divisiIsi=document.getElementById('txtdivisiEdit').value;
//     }
//     if(event=='copy'){
//       var select="#divisiCopy";
//       var divisiIsi=document.getElementById('txtdivisiCopy').value;
//     }
//     $(select).html('');
//     var autocomplete=new SelectPure(select,{
//           options:kodeDivisi,
//           icon: "fa fa-times",
//           autocomplete: true,
//           //placeholder: false,
//           value: divisiIsi,
//           //multiple: false,
//           onChange:value=>{
//             if(event=='input'){
//               $('#txtdivisiInput').val('');
//               $('#txtdivisiInput').val(value);
//               $('#txtjabatanInput').val('');
//               setAutocomplateJabatan('input')
//               getdata(1);
//             }
//             if(event=='edit'){
//               $('#txtdivisiEdit').val('');
//               $('#txtdivisiEdit').val(value);
//               $('#txtjabatanEdit').val('');
//               setAutocomplateJabatan('edit')
//             }
//             if(event=='copy'){
//               $('#txtdivisiCopy').val('');
//               $('#txtdivisiCopy').val(value);
//               $('#txtjabatanCopy').val('');
//               setAutocomplateJabatan('copy')
//             }
           
//             //setAutocomplateJabatan(value)

//           }
//       })
//   }

  

  //jabatan diambil setelah divisi di click
  function getJabatan(divisiId){
    var url = 'pabanksoals/getJabatan';
    var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            data:({divisi:divisiId}),
            async:false,
            success: function(result){
            //console.log(result);return
            dataCallback=result;
            
        }
  });   
   return dataCallback; 
  }
  // function setAutocomplateJabatan(event){
  //   //alert(event)
  //   if(event=='input'){
  //     var divisisoal=$('#txtdivisiInput').val()
  //     var divisiId;
  //     if(divisisoal!='' && divisisoal!='0'){divisiId=divisisoal.split('~')[1];}else{divisiId='0';}
  //     //alert(divisiId);return
  //     var jabatanIsi='';
  //     var select="#jabatanInput";
      
  //   } 
  //   if(event=='edit'){
  //     var divisisoal=$('#txtdivisiEdit').val()
  //     var divisiId;
  //     if(divisisoal!='' && divisisoal!='0' ){divisiId=divisisoal.split('~')[1];}else{divisiId='0';}
  //     var select="#jabatanEdit";
  //     var jabatanIsi=document.getElementById('txtjabatanEdit').value;
  //   } 
  //   if(event=='copy'){
  //     var divisisoal=$('#txtdivisiCopy').val()
  //     var divisiId;
  //     if(divisisoal!='' && divisisoal!='0' ){divisiId=divisisoal.split('~')[1];}else{divisiId='0';}
  //     var select="#jabatanCopy";
  //     var jabatanIsi=document.getElementById('txtjabatanCopy').value;
  //   }
  //   $(select).html("");
      
  //     var Jabatan=JSON.parse(getJabatan(divisiId));
  //     //$("#jabatan").html('');
  //     var autocomplete=new SelectPure(select,{
  //           options:Jabatan,
  //           icon: "fa fa-times",
  //           autocomplete: true,
  //           placeholder: false,
  //           value: jabatanIsi,
  //           onChange:value=>{
  //             if(event=='input'){
  //               $('#txtjabatanInput').val('');
  //               $('#txtjabatanInput').val(value);  
  //               getdata(1);
  //             }
  //             if(event=='edit'){
  //               $('#txtjabatanEdit').val('');
  //               $('#txtjabatanEdit').val(value);  
  //             }
  //             if(event=='copy'){
  //               $('#txtjabatanCopy').val('');
  //               $('#txtjabatanCopy').val(value);  
  //             }
  //           }
  //       })
  //   }
//select pure autpcomplete divisi jabatan minimalis
  function setAutocomplateDivisi(event){
    //camelCase(event);
    var even = cptlFirsOneWord(event)
    var kodeDivisi=JSON.parse(getDivisi());
    var select ="#divisi"+even;

    var divisiIsi=document.getElementById('txtdivisi'+even).value;
    
    $(select).html('');
    var autocomplete=new SelectPure(select,{
          options:kodeDivisi,
          icon: "fa fa-times",
          autocomplete: true,
          //placeholder: false,
          value: divisiIsi,
          //multiple: false,
          onChange:value=>{
            console.log(event)
            $('#txtdivisi'+even).val('');
            $('#txtdivisi'+even).val(value);
            if(event=='input'){
              getdata(1);
            }
            $('#txtjabatan'+even).val('');
            setAutocomplateJabatan(event)           
          }
      })
  }

  function setAutocomplateJabatan(event){
    //alert(event)
    var even = cptlFirsOneWord(event)
    var divisisoal=$('#txtdivisi'+even).val()
    var divisiId;
    if(divisisoal!='' && divisisoal!='0'){divisiId=divisisoal.split('~')[1];}else{divisiId='0';}
    var select="#jabatan"+even;
    var jabatanIsi=document.getElementById('txtjabatan'+even).value;
    $(select).html("");
    var Jabatan=JSON.parse(getJabatan(divisiId));
      //$("#jabatan").html('');
    var autocomplete=new SelectPure(select,{
            options:Jabatan,
            icon: "fa fa-times",
            autocomplete: true,
            placeholder: false,
            value: jabatanIsi,
            onChange:value=>{
              $('#txtjabatan'+even).val('');
              $('#txtjabatan'+even).val(value);  
              if(event=='input'){
                getdata(1);
              }
            }
        })
    }
// end auto complate divis jabatan minimalis 

  
function addsoal(data){
    window.location.replace("pabanksoals/"+data);
}

//function capitalize first letter in one word
function cptlFirsOneWord(str) {
    return str.replace(/(?:^\w|[A-Z]|\b\w)/g, function(word, index){
      return index == 0 ? word.toUpperCase() : word.toLowerCase();
    })
}

//camelcase function
function camelCase(str) {
  return str
      .replace(/\s(.)/g, function($1) { return $1.toUpperCase(); })
      .replace(/\s/g, '')
      .replace(/^(.)/, function($1) { return $1.toLowerCase(); });
}
// function Capitalize the first letter of each word in a string
function cptlFirtsWord(str){
  const arr = str.split(" ");
  for (var i = 0; i < arr.length; i++) {
    arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);
  }
  const str2 = arr.join(" ");
  return str2;
}




