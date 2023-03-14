var serial=0;
var curHal=1;
$(document).ready(function(e){
    getData(1);
    $("#tableListPengajuan tbody").on('click','.btnBatal',function(e){
        e.preventDefault()
        //alert($(this).attr('data-nomor'))
        $("#idErf").val($(this).attr('data-set'));
        $("#nomorErf").val($(this).attr('data-nomor'));
        $("#pengaju").val($(this).attr('data-pengaju'));
        $("#txtNomorErf").text($(this).attr('data-nomor'))
        $("#modalPembatalanErf").modal('show')
    })

    $("#btnSimpanPembatalan").on('click',function(e){
        e.preventDefault();
        var idErf=document.getElementById('idErf').value;
        var nomor= document.getElementById('nomorErf').value;
        var pengaju=document.getElementById('pengaju').value;
        var alasanPembatalan=document.getElementById('ketPembatalan').value;

        if(alasanPembatalan==''){
            alert('Harap isikan alasan pembatalan');
            $("#ketPembatalan").focus();
            return
        }
        //alert(pengaju);return
        var url="erflaporans/pembatalan";
        $.ajax({
            url:url,
            dataType:'text',
            type:'POST',
            data:({idErf:idErf,nomor:nomor,pengaju:pengaju,alasanPembatalan:alasanPembatalan}),
            success:function(returnedVal){
                //console.log(returnedVal);
                if(returnedVal=='sukses'){
                    alert('Pembatalan ERF dengan Nomor:'+nomor+'\nBerhasil diajukan!!!');
                    getData(1);
                }
               
            }
        })
       
    })
})

function getData(hal){
    curHal=hal;
    var bulan=document.getElementById('bulan').value;
    var tahun=document.getElementById('tahun').value;

    var url="erflaporans/getData";
    $.ajax({
        url:url,
        dataType:"text",
        type:'POST',
        data:({hal:hal,bulan:bulan,tahun:tahun,fungsi:'getData'}),
        success:function(returnedVal){
            //console.log(returnedVal)
            returnedVal=returnedVal.split("^");
            $('#tableListPengajuan').children('tbody:first').html(returnedVal[0]);
            if(returnedVal[1].trim().length!=0){
                document.getElementById('linkHal1').style.display='';
                document.getElementById('linkHal1').innerHTML=returnedVal[1];
            }else{
                document.getElementById('linkHal1').style.display='none';
            }
        }
    })
}