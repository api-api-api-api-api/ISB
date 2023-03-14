var serial=0;
var curHal=1;
$(document).ready(function(){
    onloadHandler();
    $('#btnAdd').on('click',function(e){
        e.preventDefault();
        $("#myModalLabel").text('FORM MARKETPLACE: TAMBAH')
        document.getElementById('marketplaceID').value="";
        document.getElementById('namaMarketplace').value="";
        $("input[name=status]").prop('checked',false)
        $("#buttonSave").html('<i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE')
        //SetAutoComplete();
        $("#modalFormMastermarketplace").modal('show');
    })

    $('#buttonSave').on('click',function(e){
        e.preventDefault();
        var mode;
        var marketplaceID=document.getElementById('marketplaceID').value;
        var namaMarketplace=document.getElementById('namaMarketplace').value;
        var statusCek=$("input[name='status']:checked").val();
        //window.confirm("Press a button!")
        if(namaMarketplace==''){alert('Isi nama marketplace');$("#namaMarketplace").focus();return}
        if(statusCek==undefined){alert('Pilih Status');return}
        if(marketplaceID==''){mode='add'}else{mode='edit'}
        var confirm =window.confirm('Apa data yang Anda masukkan sudah benar?');
        if(confirm){saveMode(mode)}
        //alert('test')
    })
    $("#tableMastermarketplace tbody").on('click','.edtBtn',function(e){
        e.preventDefault();
        var id=$(this).parent().next().text();
        var radio=$("#radio"+id).text();
        if(radio=='true')
            {$("#optionsRadios1").prop('checked', true);}
        else
            {$("#optionsRadios2").prop('checked', true);}

        $("#marketplaceID").val(id)
        $("#namaMarketplace").val($("#tdNamaMarketplace"+id).text());
        
        $("#myModalLabel").text('FORM  MARKETPLACE: EDIT')
        $("#modalFormMastermarketplace").modal('show');
        $("#buttonSave").html('<i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE')
    })
    
})

function onloadHandler(){
    getData(1)
}
function getData(hal){
    var txtNamaMarketplacefilter=document.getElementById('txtNamaMarketplacefilter').value;
    var txtStatus=document.getElementById('txtStatus').value;
    curHal=hal;
    var url="Mastermarketplaces/getData";
    $.ajax({
        url:url,
        type:"POST",
        data:({hal:hal,
            txtNamaMarketplacefilter:txtNamaMarketplacefilter,
            txtStatus:txtStatus,
            fungsi:'getData'
        }),
        dataType: "text",
        success:function(result){
            //console.log(result);return
            result=result.split("!");
            $('#tableMastermarketplace').children('tbody:first').html(result[0]);
            if(result[1].trim().length!=0){
                document.getElementById('linkHal1').style.display='';
                document.getElementById('linkHal1').innerHTML=result[1];
            }else{
                document.getElementById('linkHal1').style.display='block';
                document.getElementById('linkHal1').innerHTML='...';
            }
        }
    })
}
function saveMode(e){
    
    var mode=e;
    var marketplaceID=document.getElementById('marketplaceID').value;
    var namaMarketplace=document.getElementById('namaMarketplace').value;
    var statusCek=$("input[name='status']:checked").val();
    
    var url='Mastermarketplaces/saveMode';
    $.ajax({
        url:url,
        type:'POST',
        // contentType:false,
        // cache:false,
        // contentData:false,
        data:({marketplaceID:marketplaceID,namaMarketplace:namaMarketplace,statusCek:statusCek,mode:mode}),
        success:function(result){
            result=result.split("~");
                //console.log(result);return
            var hal=result[0];
                //console.log(hal);return
            if(result[1]=='sukses' && mode=='add'){
                alert('Data Marketplace berhasil ditambah')
                getData(hal);
                $("#modalFormMastermarketplace").modal('hide');
            }else if(result[1]=='sukses' && mode=='edit'){
                alert('Data Marketplace berhasil diubah');
                getData(hal);
                $("#modalFormMastermarketplace").modal('hide');
            }
            
        }
    })
}