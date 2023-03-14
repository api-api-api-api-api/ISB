
$(document).ready(function(e){
    
    getData();
    $("#tableListPengajuan tbody").on('click','.btnGetPelamar',function(e){
        var idErf=$(this).attr('data-id');
        var nomorErf=$(this).attr('data-erf');
        $("#nomorErfModal").val(nomorErf);
        getPelamar(idErf)
        $("#modalLinkPelamar").modal('show')
    })

    $("#tableModalListPelamar tbody").on('click','.btnModalPenilaian',function(e){
       
        var namaPelamar=$(this).attr('data-namaPelamar');
        var linkid=$(this).attr('data-linkid');
        var idErf=$(this).attr('data-erf');
        var nomorErf=$(this).attr('data-nomorErf');
        var penilaianNameInput=['penampilan','stabilitas','motivasi','keakraban','keterampilan','komunikasi','ketajaman','tingkatPergaulan'];
        for(var i=0;i<penilaianNameInput.length;i++){
            $("input[name='"+penilaianNameInput[i]+"']").each(function(){
                $(this).prop('checked',false)
            });

        //    var jmlvalue=$("input[name='"+penilaianNameInput[i]+"']").length
        //    for(var j=0;j<jmlvalue;j++){
        //     $("input[name='"+penilaianNameInput[i]+"']").eq(j).prop('checked',false);
        //    }
        }
        $("input[name='rekomendasi']").each(function(){
            $(this).prop('checked',false)
        });
        $("#setButtonPenilaian").html("<button type='button' class='btn btn-primary btnSubmitRekomendasi'  id='btnSubmitRekomendasi' data-namaPelamar='"+namaPelamar+"' data-linkid='"+linkid+"' data-erf='"+idErf+"' data-nomorErf='"+nomorErf+"'  ><i class='fa fa-hdd-o' aria-hidden='true'></i> Simpan</button>")
        $("#keteranganRekomendasi").val('')
        $("#myModalLabelPenilaianPelamar").html('');
        $("#myModalLabelPenilaianPelamar").html('PENILAIAN PELAMAR // NOMOR PENGAJUAN:  '+nomorErf+' // NAMA PELAMAR: '+namaPelamar+'');
        //$("#modalLinkPelamar").modal('hide')
        $("#modalPenilaianRekomendasi").modal('show')
    })

    $("#setButtonPenilaian").on('click','.btnSubmitRekomendasi',function(e){
    //$("#tableModalListPelamar tbody").on('click','.btnSubmitRekomendasi',function(e){
        e.preventDefault();
        //alert('test');return
        var linkId=$(this).attr('data-linkid');
        var idErf=$(this).attr('data-erf');
        var nomorErf=$(this).attr('data-nomorErf');
        var tglInterview=$("#tglInterview"+linkId).val();

        //sebelum update per row
        // var rekomendasi             =$("input[name='rekomendasi"+linkId+"']:checked").val();
        // var keteranganRekomendasi   =$("#keteranganRekomendasi"+linkId).val();
        // var penampilan              =$("input[name='penampilan"+linkId+"']:checked").val();
        // var stabilitas              =$("input[name='stabilitas"+linkId+"']:checked").val();
        // var motivasi                =$("input[name='motivasi"+linkId+"']:checked").val();
        // var keakraban               =$("input[name='keakraban"+linkId+"']:checked").val();
        // var keterampilan            =$("input[name='keterampilan"+linkId+"']:checked").val();
        // var komunikasi              =$("input[name='komunikasi"+linkId+"']:checked").val();
        // var ketajaman               =$("input[name='ketajaman"+linkId+"']:checked").val();
        // var tingakatPergaulan       =$("input[name='tingkatPergaulan"+linkId+"']:checked").val();
        // if(tglInterview==''){
        //     alert("Inputkan tanggal interview ");
        //     $("#tglInterview"+linkId).focus();
        //     return
        // }
        //setelah update single 
        var penampilan              =$("input[name='penampilan']:checked").val();
        var stabilitas              =$("input[name='stabilitas']:checked").val();
        var motivasi                =$("input[name='motivasi']:checked").val();
        var keakraban               =$("input[name='keakraban']:checked").val();
        var keterampilan            =$("input[name='keterampilan']:checked").val();
        var komunikasi              =$("input[name='komunikasi']:checked").val();
        var ketajaman               =$("input[name='ketajaman']:checked").val();
        var tingakatPergaulan       =$("input[name='tingkatPergaulan']:checked").val();
        var rekomendasi             =$("input[name='rekomendasi']:checked").val();
        var keteranganRekomendasi   =$("#keteranganRekomendasi").val();
        //alert(stabilitas);return
        if(penampilan=== undefined){alert("Inputkan penilaian penampilan");return;}
        if(stabilitas=== undefined){alert("Inputkan penilaian stabilitas");return;}
        if(motivasi=== undefined){alert("Inputkan penilaian motivasi");return;}
        if(keakraban=== undefined){alert("Inputkan penilaian keakraban");return;}
        if(keterampilan=== undefined){alert("Inputkan penilaian keterampilan kerja");return;}
        if(komunikasi=== undefined){alert("Inputkan penilaian komunikasi lisan");return;}
        if(ketajaman=== undefined){alert("Inputkan penilaian ketajaman berpikir");return;}
        if(tingakatPergaulan=== undefined){alert("Inputkan penilaian tingakat pergaulan");return;}

        //cek isian kosong
        if(keteranganRekomendasi==''){
            alert("isikan keterangan rekomendasi");
            $("#keteranganRekomendasi").focus();
            return;
        }
        if(rekomendasi=== undefined){
            alert("Pilih rekomendasi balik");
            return;
        }
        //console.log(rekomendasi);return
        

        // if(document.getElementById("canvas__")!=="undefined" && document.getElementById("canvas__")!==null){      
        //     if(isCanvasBlank(document.getElementById("canvas__"))=="true"){
        //         alert('Harap bubuhkan tanda tangan untuk approve data');
        //         return;
        //     } 
        // }
        var isittd=document.getElementById("canvas__").toDataURL("image/jpeg");
        //console.log(isittd);return
        var url="Erfrekomendasibaliks/simpan";
        $.ajax({
            url:url,
            dataType:'text',
            type:'POST',
            data:({linkId:linkId,idErf:idErf,nomorErf:nomorErf,tglInterview:tglInterview,penampilan:penampilan,stabilitas:stabilitas,motivasi:motivasi,keakraban:keakraban,keterampilan:keterampilan,komunikasi:komunikasi,ketajaman:ketajaman,tingakatPergaulan:tingakatPergaulan,keteranganRekomendasi:keteranganRekomendasi,rekomendasi:rekomendasi,isittd:isittd}),
            success:function(returnedVal){
                //console.log(returnedVal);return;
                if(returnedVal=='sukses'){
                    alert('Data berhasil disubmit')
                    getPelamar(idErf);
                    getData()
                    $("#modalPenilaianRekomendasi").modal('hide')
                }else{
                    alert('Penyimpanan gagal');
                }
                
                //console.log(returnedVal)
            }
        })
        
    })

    
})

function getData(){
    var url="Erfrekomendasibaliks/getData";
    $.ajax({
        url:url,
        dataType:"text",
        type:'POST',
        data:({}),
        success:function(returnedVal){
            //console.log(returnedVal)
            returnedVal=returnedVal.split("^");
            $('#tableListPengajuan').children('tbody:first').html(returnedVal[0]);
            // if(returnedVal[1].trim().length!=0){
            //     document.getElementById('linkHal1').style.display='';
            //     document.getElementById('linkHal1').innerHTML=result[1];
            // }else{
            //     document.getElementById('linkHal1').style.display='none';
            // }
        }
    })
}
function getPelamar(idErf){
    var url="Erfrekomendasibaliks/getPelamar";
    $.ajax({
        url:url,
        dataType:"text",
        type:"POST",
        data:({idErf:idErf}),
        success:function(returnedVal){
            //console.log(returnedVal)
            returnedVal=returnedVal.split("^");
            $('#tableModalListPelamar').children('tbody:first').html(returnedVal[0]);
            $('.sigPad').signaturePad({
                drawOnly:true,
                drawBezierCurves:true,
                lineTop:200
            });
            $(".tglInterview").datepicker({
                setDate: new Date(),           
                firstDay: 1,
                defaultDate: "d",
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                autoclose: true,
                onSelect: function( selectedDate,inst ) {
                    getData();
                    
                }
            }).keyup(function(e) {
                if(e.keyCode == 8 || e.keyCode == 46) {
                    $.datepicker._clearDate(this);
                    //$("#endDate" ).val('');
                }
        });
            //console.log(returnedVal)
        }
    })
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

function openDetil(pelamarId){
    $("#loading").fadeIn();
    $('#modalLinkDetailPelamar').modal('show');
    $('#iframeDetail').attr('src','about:blank'); 
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
// function simpan(obj){
//     console.log($(obj).attr('data-linkid'));

// }