var iderf_public;
var noerf_public;
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


function ambilPermintaan(){
   // alert("aaaaaa");
    
     var url = 'Erfapplicantevaluations/ambilPermintaan';
     var idPelamar = $("#txtIdPelamar").val();
     var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            data:{idPelamar:idPelamar}, 
            success: function(result){
                
                var data = result.split("@@");
                var pemohon = data[0].split("@@");
                $("#txtNamaPelamar").html(data[0]);
                $("#txtWawancaraOleh").html(data[1]);
                $("#txtUntukJabatan").html(data[2]);
                $("#txtPangkatPosisi").html(data[3]);
                $("#txtUnitOrganisasi").html(data[4]);
                $("#txtTanggal").html(data[5]);
                $("#txtTglDibutuhkan").html(data[6]);
                $("#txtTandaTangan").html(data[7]);
                noerf_public = data[8];


                ambilPenilaian();
               
      


        }
  }); 
}

function ambilPenilaian(){
   // alert("aaaaaa");
    
     var url = 'Erfapplicantevaluations/ambilPenilaian';
     var idPelamar = $("#txtIdPelamar").val();
     var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            data:{idPelamar:idPelamar}, 
            success: function(result){
                if(result=="kosong"){
                $('#divbtn').html('<button type="button" class="btn btn-primary" onclick="simpan()">Simpan</button>');
                }else{
                $('#divbtn').html('<button type="button" class="btn btn-primary" onclick="update()">Update</button>');
                $('.sigPad').hide();
                var data = result.split("@@");
                $("input[name=penilaian1][value="+data[0]+"]").prop('checked', true);
                $("input[name=penilaian2][value="+data[1]+"]").prop('checked', true);
                $("input[name=penilaian3][value="+data[2]+"]").prop('checked', true);
                $("input[name=penilaian4][value="+data[3]+"]").prop('checked', true);
                $("input[name=penilaian5][value="+data[4]+"]").prop('checked', true);
                $("input[name=penilaian6][value="+data[5]+"]").prop('checked', true);
                $("input[name=penilaian7][value="+data[6]+"]").prop('checked', true);
                $("input[name=penilaian8][value="+data[7]+"]").prop('checked', true);
                $("#txtKeterangan").html(data[8]);
                $("input[name=hasilpenilaian][value="+data[9]+"]").prop('checked', true);

                }
                
        }
  }); 
}


function simpan(){

    var penilaian1 = $('input[name="penilaian1"]:checked').val();
    var penilaian2 = $('input[name="penilaian2"]:checked').val();
    var penilaian3 = $('input[name="penilaian3"]:checked').val();
    var penilaian4 = $('input[name="penilaian4"]:checked').val();
    var penilaian5 = $('input[name="penilaian5"]:checked').val();
    var penilaian6 = $('input[name="penilaian6"]:checked').val();
    var penilaian7 = $('input[name="penilaian7"]:checked').val();
    var penilaian8 = $('input[name="penilaian8"]:checked').val();
    var hasilpenilaian = $('input[name="hasilpenilaian"]:checked').val();
    var keterangan = $('#txtKeterangan').val();
    var idPelamar = $("#txtIdPelamar").val();


         if(document.getElementById('canvas__')!=='undefined' && document.getElementById('canvas__')!==null){      
            if(isCanvasBlank(document.getElementById('canvas__'))=='true'){
                  alert('Harap bubuhkan tanda tangan untuk approve data');
                  return;
                  }
                 
        }
        var isittd=document.getElementById('canvas__').toDataURL('image/jpeg');

    var url = 'Erfapplicantevaluations/simpan';
    var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            async:false, 
            data:{noErf:noerf_public,idLinkPelamar:idPelamar,penampilan:penilaian1,stabilitas:penilaian2,motivasi:penilaian3,keakraban:penilaian4,keterampilan:penilaian5,komunikasi:penilaian6,ketajaman:penilaian7,pergaulan:penilaian8,keterangan:keterangan,hasilpenilaian:hasilpenilaian,isittd:isittd}, 
            success: function(result){
           
            alert(result);
            //ambilPermintaan();


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



function update(){

    var penilaian1 = $('input[name="penilaian1"]:checked').val();
    var penilaian2 = $('input[name="penilaian2"]:checked').val();
    var penilaian3 = $('input[name="penilaian3"]:checked').val();
    var penilaian4 = $('input[name="penilaian4"]:checked').val();
    var penilaian5 = $('input[name="penilaian5"]:checked').val();
    var penilaian6 = $('input[name="penilaian6"]:checked').val();
    var penilaian7 = $('input[name="penilaian7"]:checked').val();
    var penilaian8 = $('input[name="penilaian8"]:checked').val();
    var hasilpenilaian = $('input[name="hasilpenilaian"]:checked').val();
    var keterangan = $('#txtKeterangan').val();
    var idPelamar = $("#txtIdPelamar").val();

    var url = 'Erfapplicantevaluations/update';
    var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            data:{noErf:noerf_public,idLinkPelamar:idPelamar,penampilan:penilaian1,stabilitas:penilaian2,motivasi:penilaian3,keakraban:penilaian4,keterampilan:penilaian5,komunikasi:penilaian6,ketajaman:penilaian7,pergaulan:penilaian8,keterangan:keterangan,hasilpenilaian:hasilpenilaian}, 
            success: function(result){
           
            alert(result);
            //ambilPermintaan();


        }
  });   
}






   
    


