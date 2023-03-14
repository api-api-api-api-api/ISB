var serial=0;
var curHal=1;
$(document).ready(function(){
    onloadHandler();
    $('#btnAdd').on('click',function(e){
        e.preventDefault();
        $("#myModalLabel").text('FORM MASTER VOUCER: TAMBAH')
        document.getElementById('voucerID').value="";
        document.getElementById('namaVoucer').value="";
        $("input[name=status]").prop('checked',false)
        $("#buttonSave").html('<i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE')
        //SetAutoComplete();
        $("#modalFormMastervoucer").modal('show');
    })

    $('#buttonSave').on('click',function(e){
        e.preventDefault();
        var mode;
        var voucerID=document.getElementById('voucerID').value;
        var namaVoucer=document.getElementById('namaVoucer').value;
        var statusCek=$("input[name='status']:checked").val();
        //window.confirm("Press a button!")
        if(namaVoucer==''){alert('Isi nama voucer');$("#namaVoucer").focus();return}
        if(statusCek==undefined){alert('Pilih Status');return}
        if(voucerID==''){mode='add'}else{mode='edit'}
        var confirm =window.confirm('Apa data yang Anda masukkan sudah benar?');
        if(confirm){saveMode(mode)}
        //alert('test')
    })
    $("#tableVoucer tbody").on('click','.edtBtn',function(e){
        e.preventDefault();
        //alert('test')
        var id=$(this).parent().next().text();
        var radio=$("#radio"+id).text();
        if(radio=='true')
            {$("#optionsRadios1").prop('checked', true);}
        else
            {$("#optionsRadios2").prop('checked', true);}

        $("#voucerID").val(id)
        $("#namaVoucer").val($("#tdNamaVoucer"+id).text());
        
        $("#myModalLabel").text('FORM  MARKETPLACE: EDIT')
        $("#modalFormMastervoucer").modal('show');
        $("#buttonSave").html('<i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE')
    })
    
})

function onloadHandler(){
    getData(1)
}
function getData(hal){
    var txtNamaVoucerFilter=document.getElementById('txtNamaVoucerFilter').value;
    var txtStatus=document.getElementById('txtStatus').value;
    curHal=hal;
    var url="mastervoucers/getData";
    $.ajax({
        url:url,
        type:"POST",
        data:({hal:hal,
            txtNamaVoucerFilter:txtNamaVoucerFilter,
            txtStatus:txtStatus,
            fungsi:'getData'
        }),
        dataType: "text",
        success:function(result){
            //console.log(result);return
            result=result.split("!");
            $('#tableVoucer').children('tbody:first').html(result[0]);
            if(result[1].trim().length!=0){
                document.getElementById('linkHal1').style.display='';
                document.getElementById('linkHal1').innerHTML=result[1];
            }else{
                document.getElementById('linkHal1').style.display='block';
            }
        }
    })
}
function saveMode(e){
    
    var mode=e;
    var voucerID=document.getElementById('voucerID').value;
    var namaVoucer=document.getElementById('namaVoucer').value;
    var statusCek=$("input[name='status']:checked").val();
    
    var url='mastervoucers/saveMode';
    $.ajax({
        url:url,
        type:'POST',
        // contentType:false,
        // cache:false,
        // contentData:false,
        data:({voucerID:voucerID,namaVoucer:namaVoucer,statusCek:statusCek,mode:mode}),
        success:function(result){
            result=result.split("~");
                //console.log(result);return
            var hal=result[0];
                //console.log(hal);return
            if(result[1]=='sukses' && mode=='add'){
                alert('Data voucer berhasil ditambah')
                getData(hal);
                $("#modalFormMastervoucer").modal('hide');
            }else if(result[1]=='sukses' && mode=='edit'){
                alert('Data voucer berhasil diubah');
                getData(hal);
                $("#modalFormMastervoucer").modal('hide');
            }
            
        }
    })
}