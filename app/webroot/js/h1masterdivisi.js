var serial=0;
var curHal=1;
var onloadData=getDataNegara();
//console.log(onloadData)
$(document).ready(function(e){
   $("#btnAddDivisi").on('click',function(e){
        e.preventDefault();
        $("#myModalLabel").text("ADD DIVISI OR ITS EQUIVALENT TO THIS");
        $("#idDivisi").val("");
        $("#inpDivisi").val("");
        $("#inpGroupDivisi").val("")
        $("#modaldivisi").modal('show')
   })

   $("#tableMaintenanceDivisi tbody").on('click','.edtBtn',function(e){
        e.preventDefault();
        $("#myModalLabel").text("UPDATE DIVISI");
        var idDivisi=$(this).attr('data-id');
        var namaDivisi=$(this).attr('data-divisi');
        var namaGroupDivisi=$(this).attr('data-groupDivisi');
        //alert(namaKec);return
        $("#idDivisi").val(idDivisi);
        $("#inpDivisi").val(namaDivisi);
        $("#inpGroupDivisi").val(namaGroupDivisi);
        $("#modaldivisi").modal('show');
    })

   $("#buttonSave").on("click",function(e){
        e.preventDefault();
    
        var idDivisi=document.getElementById('idDivisi').value
        var inpDivisi=document.getElementById('inpDivisi').value
        var inpGroupDivisi=document.getElementById('inpGroupDivisi').value
        // console.log(inpDivisi);return
        // console.log(inpGroupDivisi);return
        // console.log(idDivisi);return
        //cek inputan kosong
        if(inpDivisi==''){
            alert("Divisi tidak boleh kosong");
            return
        }
        
        if(inpGroupDivisi==''){
            alert("Group Divisi tidak boleh kosong");
            return
        }
        var url="Masterdivisis/saveCRUD";
        // console.log(crud);return
        $.ajax({
            url:url,
            data:({
                idDivisi:idDivisi,
                inpDivisi:inpDivisi,
                inpGroupDivisi:inpGroupDivisi
                }),
            type:"POST",
            // dataType:"Text",
            success:function(result){
                console.log(result);return
                result=result.split("^");
                var hal=result[0];
                //console.log(hal);return
                if(result[1]=='sukses' && !idDivisi){
                    alert('Data divisi berhasil ditambah')
                    getData(hal);
                    $("#modaldivisi").modal('hide');
                }else if(result[1]=='sukses' && idDivisi1){
                    alert('Data divisi berhasil diubah');
                    getData($("#setHal").val())
                    $("#modaldivisi").modal('hide');
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
    // var txtNegara=document.getElementById('txtNegara').value
    // var txtPropinsi=document.getElementById('txtProvinsi').value
    // var txtKota=document.getElementById('txtKota').value
    // var txtNamaKecamatan=document.getElementById('txtNamaKecamatan').value
    // var txtStatus   = document.getElementById('txtStatus').value;

    var url="Masterdivisis/getData";
    $.ajax({
        url:url,
        type:"POST",
        dataType:"Text",
        data:({hal:hal,
            // txtNegara:txtNegara,
            // txtPropinsi:txtPropinsi,
            // txtKota:txtKota,
            // txtNamaKecamatan:txtNamaKecamatan,
            // txtStatus:txtStatus,
            fungsi:'getData'}),
        success:function(returnVal){
            $("#setHal").val(hal);
            //console.log(returnVal)
            returnVal=returnVal.split("^");
            $('#tableMaintenanceDivisi').children('tbody:first').html(returnVal[0]);
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