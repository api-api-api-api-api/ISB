var serial=0;
var curHal=1;
$(document).ready(function(){
    onLoadHandler();
   
    $("#btnForm").on('click',function(e){
        e.preventDefault();
        var kantorCabangId=getKantorCabangId();
        $("#kantorCabangId").val(kantorCabangId);
        $("#kantorCabangId").prop('type','hidden')
        $("#txtkantorCabangId").text(kantorCabangId)
        $("#txtkantorCabangId").show();
        $("#crud").val('add');
        $("#idCabang").val('')
        $("#idCabang").prop('type','text');
        $("#txtnoCabangSet").text('')
        $("#txtnoCabangSet").hide();
        $("#namaCabang").val('');
        $("#alamat").val('');
        $("#kota").val('');
        $("#kodeCabang").val('');
        $("#kontakPerson").val(''); 
       
        $("#myModalLabel").text('FORM CABANG: TAMBAH')
        $("#buttonSave").html('<i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE CABANG')
        //SetAutoComplete();
        $("#modalFormMaintenanceKantorCabang").modal('show');
        // $("#companyAdd tbody").html('');
    })

   
    $("#tableMaintenanceCabang tbody").on('click','.edtBtn',function(e){
        e.preventDefault();
        var id=$(this).parent().next().text();
        $("#crud").val('edit');
        $("#idCabang").val(id);
        $("#idCabang").prop('type','hidden');
        $("#txtnoCabangSet").text(id)
        $("#txtnoCabangSet").show();
        
        // var inputCabang=document.getElementById('idCabang')
        // inputCabang.type='hidden'
        $("#kantorCabangId").val($("#tdkantorCabangId"+id).text());
        $("#kantorCabangId").prop('type','hidden')
        $("#txtkantorCabangId").text($("#tdkantorCabangId"+id).text())
        $("#txtkantorCabangId").show();
        $("#namaCabang").val($("#tdNamaCabang"+id).text());
        $("#alamat").val($("#tdAlamat"+id).text());
        $("#kota").val($("#tdKota"+id).text());
        $("#kodeCabang").val($("#tdkodeCabang"+id).text()); 
        $("#kontakPerson").val($("#tdkontakPerson"+id).text());
       
        $("#myModalLabel").text('FORM CABANG: EDIT')
        $("#modalFormMaintenanceKantorCabang").modal('show');

    })

    $("#buttonSave").on('click',function(e){
        e.preventDefault();
       
        var crud=$("#crud").val();
        var idCabang=$("#idCabang").val();
        // if(idCabang==""){
        //     crud='add';
        // }else{
        //     crud='edit';
        // }
        //alert(crud);return
        //alert(idCabang);return
        var namaCabang=$("#namaCabang").val();
        var alamat=$("#alamat").val();
        var kota=$("#kota").val();
        var kodeCabang=$("#kodeCabang").val(); 
        var kontakPerson=$("#kontakPerson").val();
        var kantorCabangId=$("#kantorCabangId").val();
        
        // if(idCabang==''){
        //     alert('Nomor Cabang harus diisi')
        //     $("#idCabang").focus();
        //     return
        // }

        if(namaCabang==''){
            alert('Nama Cabang harus diisi')
            $("#namaCabang").focus();
            return
        }       
      
        if(alamat==''){
            alert('Alamat harus diisi')
            $("#alamat").focus();
            return
        }
        if(kota==''){
            alert('Kota harus diisi')
            $("#kota").focus();
            return
        }
        if(kodeCabang==''){
            alert('Kode Cabang harus diisi')
            $("#kodeCabang").focus();
            return
        }
        if(kontakPerson==''){
            alert('Kontak harus diisi')
            $("#kontakPerson").focus();
            return
        }
               
        //alert('test');return
        var url='Maintenancekantorcabangs/saveCRUD';
        $.ajax({
            url:url,
            type:"POST",
            data:({
                idCabang:idCabang,
                namaCabang:namaCabang,
                alamat:alamat,
                kota:kota,
                kodeCabang:kodeCabang,
                kontakPerson:kontakPerson,
                kantorCabangId:kantorCabangId,
                CRUD:crud
            }),
            success:function(result){
                //console.log(result);return
                result=result.split("~");
                //console.log(result);return
                // if(result[1]=='double'){
                //     alert('Nomor Cabang sudah ada')
                //     $("#idCabang").focus();
                //     return
                // }
                var hal=result[0];
                //console.log(hal);return
                if(result[1]=='sukses' && crud=='add'){
                    alert('Data Cabang berhasil ditambah')
                    getData(hal);
                    $("#modalFormMaintenanceKantorCabang").modal('hide');
                }else if(result[1]=='sukses' && crud=='edit'){
                    alert('Data Cabang berhasil diubah');
                    getData(hal);
                    $("#modalFormMaintenanceKantorCabang").modal('hide');
                }
            }
        })
    })

})

function onLoadHandler(){
    getData(1)
}

function getKantorCabangId(){
    var kantorCabangId;
    var url="Maintenancekantorcabangs/getKantorCabangID";
    $.ajax({
        url:url,
        type:"POST",
        data:({}),
        dataType: "text",
        async:false,
        success:function(result){
            //console.log(result);return
            kantorCabangId=result;
        }
    })
    return kantorCabangId;
}
function getData(hal){
    curHal=hal;
    var txtNamaCabangFilter=document.getElementById('txtNamaCabangFilter').value;
    var txtAlamatCabangFilter=document.getElementById('txtAlamatCabangFilter').value;
    var txtKotaCabangFilter=document.getElementById('txtKotaCabangFilter').value;
    var txtKodeFilter=document.getElementById('txtKodeFilter').value;
    var txtKontakFilter=document.getElementById('txtKontakFilter').value;

    var url="Maintenancekantorcabangs/getData";

    $.ajax({
        url:url,
        type:"POST",
        data:({hal:hal,
            txtNamaCabangFilter:txtNamaCabangFilter,
            txtAlamatCabangFilter:txtAlamatCabangFilter,
            txtKotaCabangFilter:txtKotaCabangFilter,
            txtKodeFilter:txtKodeFilter,
            txtKontakFilter:txtKontakFilter,
            fungsi:'getData'
        }),
        dataType: "text",
        success:function(result){
            //console.log(result);return
            result=result.split("!");
            $('#tableMaintenanceCabang').children('tbody:first').html(result[0]);
            if(result[1].trim().length!=0){
                document.getElementById('linkHal1').style.display='';
                document.getElementById('linkHal1').innerHTML=result[1];
            }else{
                document.getElementById('linkHal1').style.display='block';
            }
        }
    })
}