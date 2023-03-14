
var serial=0;
var curHal=1;
$(document).ready(function(){
    //alert('test')
    onloadHandler();
    $('#btnAdd').on('click',function(e){
        e.preventDefault();
        $("#myModalLabel").text('FORM MASTER REWARD: TAMBAH')
        document.getElementById('rewardID').value="";
        document.getElementById('namaReward').value="";
        document.getElementById('txtJenisSaldo').value="";
        $("input[name=status]").prop('checked',false)
        $("#buttonSave").html('<i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE')
        //SetAutoComplete();
        setAutocomplateForm();
        $("#modalFormMasterreward").modal('show');
    })

    $('#buttonSave').on('click',function(e){
        e.preventDefault();
        //alert('test')
        var mode;
        var rewardID=document.getElementById('rewardID').value;
        var namaReward=document.getElementById('namaReward').value;
        var jenisSaldo=document.getElementById('txtJenisSaldo').value;
        var statusCek=$("input[name='status']:checked").val();
        //window.confirm("Press a button!")
        if(namaReward==''){alert('Isi nama reward');$("#namaReward").focus();return}
        if(jenisSaldo==''){alert('Pilih Jenis Saldo');$("#txtJenisSaldo").focus();return}
        if(statusCek==undefined){alert('Pilih Status');return}
        if(rewardID==''){mode='add'}else{mode='edit'}
        var confirm =window.confirm('Apa data yang Anda masukkan sudah benar?');
        if(confirm){saveMode(mode)}
        //alert('test')
    })
    $("#tableMasterreward tbody").on('click','.edtBtn',function(e){
        e.preventDefault();
        $("#txtJenisSaldo option").attr("selected", false);
        var id=$(this).parent().next().text();
        var jenisSaldo=$("#tdJenissaldo"+id).text();

        var element = document.getElementById("txtJenisSaldo");
        element.value = jenisSaldo;
        //alert(jenisSaldo);return
        var radio=$("#radio"+id).text();
        if(radio=='true')
            {$("#optionsRadios1").prop('checked', true);}
        else
            {$("#optionsRadios2").prop('checked', true);}

        $("#rewardID").val(id)
        $("#namaReward").val($("#tdNamareward"+id).text());
        
        $("#myModalLabel").text('FORM MASTER REWARD: EDIT')
        $("#modalFormMasterreward").modal('show');
        $("#buttonSave").html('<i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE')
        setAutocomplateForm();
    })

})
function onloadHandler(){
    //return
    getData(1);
}
function getData(hal){
    var txtNamaMastermarketplacefilter=document.getElementById('txtNamaMastermarketplacefilter').value;
    var txtNamaMasterrewardfilter=document.getElementById('txtNamaMasterrewardfilter').value;
    var txtStatus=document.getElementById('txtStatus').value;
    curHal=hal;
    var url="Masterrewards/getData";
    $.ajax({
        url:url,
        type:"POST",
        data:({hal:hal,
            txtNamaMastermarketplacefilter:txtNamaMastermarketplacefilter,
            txtNamaMasterrewardfilter:txtNamaMasterrewardfilter,
            txtStatus:txtStatus,
            fungsi:'getData'
        }),
        dataType: "text",
        success:function(result){
            //console.log(result);return
            result=result.split("!");
            $('#tableMasterreward').children('tbody:first').html(result[0]);
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
    //alert(e);return
    var mode=e;
    var rewardID=document.getElementById('rewardID').value;
    var namaReward=document.getElementById('namaReward').value;
    var jenisSaldo=document.getElementById('txtJenisSaldo').value;
    var statusCek=$("input[name='status']:checked").val();
    //alert(jenisSaldo);return
    
    var url='masterrewards/saveMode';
    $.ajax({
        url:url,
        type:'POST',
        // contentType:false,
        // cache:false,
        // contentData:false,
        data:({rewardID:rewardID,namaReward:namaReward,jenisSaldo:jenisSaldo,statusCek:statusCek,mode:mode}),
        success:function(result){
            //console.log(result);return
            result=result.split("~");
                
            var hal=result[0];
                //console.log(hal);return
            if(result[1]=='sukses' && mode=='add'){
                alert('Data Reward berhasil ditambah')
                getData(hal);
                $("#modalFormMasterreward").modal('hide');
            }else if(result[1]=='sukses' && mode=='edit'){
                alert('Data Reward berhasil diubah');
                getData(hal);
                $("#modalFormMasterreward").modal('hide');
            }
            
        }
    })
}

function setAutocomplateForm(val){
    $("#nmMarketplace").val('');
    // $("#atasan").val('');
    // $("#appAtasan1").val('');
    // $("#appAtasan2").val('');
    var isiVal=val;
    var getData=JSON.parse(getDtMarketplace());
    //console.log(getData);return
    //var  dataatasan=getData.dtatasan;
    //console.log(dataatasan);
    //var datakaryawan = getData.dtkaryawan;
    //console.log(datakaryawan)
    //return
     //console.log(divisi)
    $("#txtMarketplace").html('');
    //$("#txtAtasan").html('');
    //$("#txtApp1").html('');
    //$("#txtApp2").html('');
   var marketplace = new SelectPure("#txtMarketplace",{
        options:getData,
        value:isiVal,
         multiple: false,
        placeholder:"--please select--",
         icon: "fa fa-user",
        autocomplete: true,
        onChange:value=>{
            $('#nmMarketplace').val('');
            var datakaryawan=value.split('~');
             datakaryawan=datakaryawan[0];
            //console.log(user)
            $('#nmMarketplace').val(datakaryawan);  
        },
    })
    return
    var karyawan = new SelectPure("#txtKaryawan",{
        options:datakaryawan,
        value:isiVal,
        // multiple: false,
         placeholder:"--please select--",
        // icon: "fa fa-times",
        autocomplete: true,
        onChange:value=>{
            $('#karyawan').val('');
            var datakaryawan=value;
            //console.log(user)
            $('#karyawan').val(datakaryawan);  
        },
    })

    var app1 = new SelectPure("#txtApp1",{
        options:dataatasan,
        value:isiVal,
        // multiple: false,
        // placeholder:"--please select--",
        // icon: "fa fa-times",
        autocomplete: true,
        onChange:value=>{
            $('#appAtasan1').val('');
            var dataatasanapp1=value;
            //console.log(user)
            $('#appAtasan1').val(dataatasanapp1);  
        },
    })
    var app2 = new SelectPure("#txtApp2",{
        options:dataatasan,
        value:isiVal,
        // multiple: false,
        // placeholder:"--please select--",
        // icon: "fa fa-times",
        autocomplete: true,
        onChange:value=>{
            $('#appAtasan2').val('');
            var dataatasanapp2=value;
            //console.log(user)
            $('#appAtasan2').val(dataatasanapp2);  
        },
    })
}
function getDtMarketplace(){
    var url = 'masterrewards/getDtMarketplace';
    var dataMarketplace;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            async:false,
            success: function(result){
            //console.log(result);return
            dataMarketplace=result;
            //jsonVal=JSON.parse(result);
            //console.log(jsonVal);return
        }
  });	
   return dataMarketplace; 
}