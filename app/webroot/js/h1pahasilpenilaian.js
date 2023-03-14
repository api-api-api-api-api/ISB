  var txtFilterDivisiAll;
  var txtFilterNamaKryAll;
$(document).ready(function(){

    getfilterdivisi();
    setfilterdivisi();

    getfilternamakry();
    setfilternamakry();
    
    getperiode();
    getdata(1);


})

function tropen(no){
  //$(".trhide").hide();
  isVisible = $("#tropen"+no).closest('tr').is(':visible');
  if(isVisible==true){
    $("#tropen"+no).hide();
  }else{
    $("#tropen"+no).show();
  }
}



function getdata(hal){

        var userTampil=document.getElementById('userTampil').value
        var url ="pahasilpenilaians/getdata";

        // filter dari cari data
        var periode = $("#pilihperiode").val();
        //alert(periode);
        var filterdivisi = $("#txtfilterdivisi").val();
        var nikkry = $("#txtfilternamakry").val();
        var usertampil = $("#userTampil").val();


 

        $("#tblhasil").html("");
        $("#linkHal").html("");
                
        $.ajax({
            url:url,
            type:"POST",
            async:false,
            data: ({fungsi:"getdata",hal:hal,periode:periode, filterdivisi:filterdivisi, nikkry:nikkry, userTampil:userTampil}),
            success:function(result){
               
                  returnedVal=result.split("!");
                //console.log(result);return
                $("#tblhasil").html(returnedVal[0]);
                $("#linkHal").html(returnedVal[1]);
                $(".trhide").hide();

            }
        })

}


function cetakpdf(filter){
  //alert(filter);return;
  //2000625|NOFI KUSUMA|1976-11-29|3
  
  if(filter!=''){
    var filterSingle=filter.split('|');
    var periode = filterSingle[3];
    var filterdivisi='';
    var nikkry=filterSingle[0];
    var userTampil=$("#userTampil").val();
    
    

  }else{
    var periode = $("#pilihperiode").val();
    var filterdivisi = $("#txtfilterdivisi").val();
    var nikkry = $("#txtfilternamakry").val();
    var userTampil=$("#userTampil").val();
  }
  //console.log(nikkry);return
  window.open("pahasilpenilaians/cetakpdf/?userTampil="+userTampil+"&periode="+periode+"&filterdivisi="+filterdivisi+"&nikkry="+nikkry);
        /*
        var url ="hasilpenilaians/cetakpdf/?periode="+periode;

        $.ajax({
            url:url,
            type:"GET",
            data: ({periode:periode, filterdivisi:filterdivisi}),
            success:function(result){

            }
        })
        */
}


function caridata(hal){

        var periode = $("#pilihperiode").val();

        var filterdivisi = $("#txtfilterdivisi").val();
        var nikkry = $("#txtfilternamakry").val();
        var usertampil = $("#userTampil").val();


 

        $("#tblhasil").html("");
        $("#linkHal").html("");

        var url ="pahasilpenilaians/caridata";

        $.ajax({
            url:url,
            type:"POST",
            data: ({fungsi:"caridata",hal:hal,periode:periode, filterdivisi:filterdivisi, nikkry:nikkry, userTampil:usertampil}),
            success:function(result){
        

               
                  returnedVal=result.split("!");

                //console.log(result);return
                $("#tblhasil").html(returnedVal[0]);
                $("#linkHal").html(returnedVal[1]);
                $(".trhide").hide();
            }
        })


}


function getperiode(){

        var url ="pahasilpenilaians/getperiode";
                
        $.ajax({
            url:url,
            type:"POST",
            async:false,
            success:function(result){


               $("#pilihperiode").html(result);
            }
        })

}

function savedata(){

        var tglstart= $("#tglstart").val();
         var tglend= $("#tglend").val();

        var url ="pahasilpenilaians/savedata";
                
        $.ajax({
            url:url,
            type:"POST",
            data: ({tglstart:tglstart,tglend:tglend}),
            success:function(result){
                  
                  getdata(1);
            }
        })

}

function addsoal(data){
    window.location.replace("banksoals/"+data);

}



  function getfilterdivisi(){


    var url = 'pahasilpenilaians/getfilterdivisi';
          var jsonVal;
          $.ajax({
              url: url,
              type: "POST",
              dataType:"text",
              async:false,
              success: function(returnedVal){



       
                txtFilterDivisiAll=returnedVal;


                //alert(txtKategoriAll);

               
          }
    }); 


  }

    function getfilternamakry(){


    var url = 'pahasilpenilaians/getfilternamakry';
          var jsonVal;
          $.ajax({
              url: url,
              type: "POST",
              dataType:"text",
              async:false,
              success: function(returnedVal){

               // alert(returnedVal);

       
                txtFilterNamaKryAll=returnedVal;


                //alert(txtKategoriAll);

               
          }
    }); 


  }




  function filterdivisijson(){

    

    var jsonVal=JSON.parse(txtFilterDivisiAll); 
     return jsonVal; 


  }


  function filternamakryjson(){

    

    var jsonVal=JSON.parse(txtFilterNamaKryAll); 
     return jsonVal; 


  }



  function setfilterdivisi(){


    var nmfilterdivisi;
     nmfilterdivisi=filterdivisijson();


      $("#filterdivisi").html('');
      var autocomplete=new SelectPure("#filterdivisi",{
          options:nmfilterdivisi,
          icon: "fa fa-times",
          autocomplete: true,
          placeholder: false,
          onChange:value=>{

               var splitfilterdivisi = value.split("^");
              $('#txtfilterdivisi').val(splitfilterdivisi[0]);
              getdata(1);


          }
      })
  }

  function setfilternamakry(){



      var nmfilternamakry;
     nmfilternamakry=filternamakryjson();


      $("#filternamakry").html('');
      var autocomplete=new SelectPure("#filternamakry",{
          options:nmfilternamakry,
          icon: "fa fa-times",
          autocomplete: true,
          placeholder: false,
          onChange:value=>{

               var splitfilternamakry = value.split("^");
              $('#txtfilternamakry').val(splitfilternamakry[0]);
              getdata(1);


          }
      })
  }

  function detail(kryID,nikkry,namakry,tgllahirkry,periode){
    //alert(kryID+nikkry+namakry+tgllahirkry+periode);return
      var url="pahasilpenilaians/detail";
      //var periode=$("#periode").val();
      //var sebagai=$("#sebagai").val();
      $("#txtNik").text('');
      $("#txtNama").text('');
      $("#txtTglMsk").text('');
      $("#txtJabatan").text('');
      $("#txtStatus").text('');
      $('#formPenilaian').html('');
      $("#nikkry").val('');
      $("#namakry").val('');
      $("#tgllahirkry").val('');
      $.ajax({
        url: url,
        type: "POST",
        data: ({periode:periode,kryID:kryID,nikkry:nikkry,namakry:namakry,tgllahirkry:tgllahirkry}),
        dataType: "text",
        success: function(result){
          //console.log(result);return
          if(result==''){
            alert('data masih kosong');
            return
          }
          result = result.split('^');
          var datakaryawan=result[0].split('~');
            $("#txtNik").text(datakaryawan[1]);
            $("#txtNama").text(datakaryawan[2]);
            $("#txtTglMsk").text(datakaryawan[4]);
            $("#txtJabatan").text(datakaryawan[5]);
            $("#txtStatus").text('');
            $('#detailPenilaian').html(result[1]);
            $("#idkry").val(datakaryawan[0]);
            $("#nikkry").val(datakaryawan[1]);
            $("#namakry").val(datakaryawan[2]);
            $("#tgllahirkry").val(datakaryawan[3]);
            $('#formKomentar').html(result[7]);
          $("#detailSoal").show();
        }
      })
        $('#modalDetailPenilaian').modal('show')
  }


