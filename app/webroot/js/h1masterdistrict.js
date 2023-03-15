var serial=0;
var curHal=1;
var onloadData=getDataNegara();
//console.log(onloadData)
$(document).ready(function(e){
   $("#btnAddDistrict").on('click',function(e){
        e.preventDefault();
        $("#myModalLabel").text("ADD DISTRICT OR ITS EQUIVALENT TO THIS");
        $("#idKecamatan").val("");
        $("#inpNegara").val("");
        $("#inpKota").val("")
        $("#inpNegara").val("");
        $("#inpProvinsi").val("");
        $("#inpNamaKecamatan").val("");
        $("#inpStatus").val("true");
        $("#inpNegara").prop('disabled',false);
        $("#inpProvinsi").prop('disabled',false);
        $("#modaldistrict").modal('show')
   })

   $("#tableMaintenanceDistrict tbody").on('click','.edtBtn',function(e){
        e.preventDefault();
        $("#myModalLabel").text("UPDATE DISTRICT");
        var idKec=$(this).attr('data-id');
        var idProv=$(this).attr('data-prov');
        var idNeg=$(this).attr('data-neg');
        var idKota=$(this).attr('data-kota');
        var namaKec=$(this).attr('data-kec');
        var aktif=$(this).attr('data-aktif');
        //alert(namaKec);return
        $("#idKecamatan").val(idKec);
        $("#inpNegara").val(idNeg)
        getProvinsi(idNeg,'edit')
        $("#inpProvinsi").val(idProv);
        getKota(idProv,'edit');
        $("#inpKota").val(idKota);
        $("#inpNamaKecamatan").val(namaKec);
        $("#inpStatus").val(aktif);
        $("#inpNegara").prop('disabled',true);
        $("#inpProvinsi").prop('disabled',true);
        $("#modaldistrict").modal('show');
    })

   $("#buttonSave").on("click",function(e){
        e.preventDefault();
        var inpNegara=document.getElementById('inpNegara').value
        var inpProvinsi=document.getElementById('inpProvinsi').value
        var inpKota=document.getElementById('inpKota').value;
        var idKecamatan=document.getElementById('idKecamatan').value;
        var inpNamaKecamatan=document.getElementById('inpNamaKecamatan').value;
        var inpStatus=document.getElementById('inpStatus').value;
        //cek inputan kosong
        if(inpNegara==''){
            alert("Negara tidak boleh kosong");
            return
        }
        
        // if(inpProvinsi==''){
        //     alert("Provinsi tidak boleh kosong");
        //     return
        // }
        // if(inpKota==''){
        //     alert("Kota tidak boleh kosong");
        //     return
        // }

        // if(inpNamaKecamatan==''){
        //     alert("input district tidak boleh kosong");
        //     $("#inpNamaKota").focus();
        //     return
        // }

        //console.log(inpNegara);return
        var url="Masterdistricts/saveCRUD";
        //console.log(inpNegara+inpProvinsi+inpNamaKota)
        $.ajax({
            url:url,
            data:({idKecamatan:idKecamatan,
                inpNamaKecamatan:inpNamaKecamatan,
                inpKota:inpKota,
                inpProvinsi:inpProvinsi,
                inpNegara:inpNegara,
                inpStatus:inpStatus}),
            type:"POST",
            dataType:"Text",
            success:function(returnVal){
                // console.log(returnVal);return
                if(returnVal=='gagal'){
                    alert('data sudah ada');                   
                    return
                }
                $('#txtNegara').val("");
                $('#txtProvinsi').val("");
                $('#txtKota').val("");
                $('#txtNamaKecamatan').val("");
                returnVal=returnVal.split("^");
                var hal=returnVal[0];
                if(returnVal[1]=='sukses' && !idKecamatan){
                    alert('Data kota berhasil ditambah')
                    $("#txtStatus").val(inpStatus);
                    getData(hal);
                    $("#modaldistrict").modal('hide');
                }else if(returnVal[1]=='sukses' && idKecamatan){
                    alert('Data kota berhasil diubah');
                    //$("#txtStatus").val(inpStatus);
                    //getData(hal);
                    getData($("#setHal").val())
                    $("#modaldistrict").modal('hide');
                }
            }
        })

    })
   onLoadHandler()
})

function onLoadHandler(){
    $("#txtNegara").html(onloadData);
    $("#inpNegara").html(onloadData);
    getData(1)
}
function getData(hal){
    var txtNegara=document.getElementById('txtNegara').value
    var txtPropinsi=document.getElementById('txtProvinsi').value
    var txtKota=document.getElementById('txtKota').value
    var txtNamaKecamatan=document.getElementById('txtNamaKecamatan').value
    var txtStatus   = document.getElementById('txtStatus').value;

    var url="Masterdistricts/getData";
    $.ajax({
        url:url,
        type:"POST",
        dataType:"Text",
        data:({hal:hal,
            txtNegara:txtNegara,
            txtPropinsi:txtPropinsi,
            txtKota:txtKota,
            txtNamaKecamatan:txtNamaKecamatan,
            txtStatus:txtStatus,
            fungsi:'getData'}),
        success:function(returnVal){
            $("#setHal").val(hal);
            //console.log(returnVal)
            returnVal=returnVal.split("^");
            $('#tableMaintenanceDistrict').children('tbody:first').html(returnVal[0]);
            if(returnVal[1].trim().length!=0){
                document.getElementById('linkHal1').style.display='';
                document.getElementById('linkHal1').innerHTML=returnVal[1];
            }else{
                document.getElementById('linkHal1').style.display='block';
                document.getElementById('linkHal1').innerHTML='...';
            }
        }
    })
}

 function getDataNegara(){
    var url = 'Masterdistricts/getDataNegara';
    var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            async:false,
            success: function(result){
            //console.log(result);return
            dataCallback=result;
            //jsonVal=JSON.parse(result);
            //console.log(jsonVal);return
        }
    });	
   return dataCallback; 
}

function getProvinsi(idNegara,tipe){
    if(tipe=='filter'){
        $("#txtProvinsi").html(getDataProvinsi(idNegara))
    }else{
        $("#inpProvinsi").html(getDataProvinsi(idNegara))
    }
}

function getKota(idProvinsi,tipe){
    if(tipe=='filter'){
        //console.log(getDataKota(idProvinsi))
        $("#txtKota").html(getDataKota(idProvinsi))
    }else{
        $("#inpKota").html(getDataKota(idProvinsi))
    }
}

function getDataProvinsi(idNegara){
    //alert(idNegara)
    //alert(idNegara);return
    var dataProvinsi
    $.ajax({
        url:'Masterdistricts/getDataProvinsi',
        type:'POST',
        dataType:'text',
        data:({idNegara:idNegara}),
        async:false,
        success:function(returnVal){
            dataProvinsi=returnVal
            //console.log(dataProvinsi)
        }
    })
   return dataProvinsi
}
function getDataKota(idProvinsi){
    var dataKota
    $.ajax({
        url:'Masterdistricts/getDataKota',
        type:'POST',
        dataType:'text',
        data:({idProvinsi:idProvinsi}),
        async:false,
        success:function(returnVal){
            dataKota=returnVal
            //console.log(dataKota)
        }
    })
    return dataKota
}