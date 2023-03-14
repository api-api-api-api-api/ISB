var serial=0;
var curHal=1;
var onloadData=getDt();
//onloadData=onloadData.split("!");
//console.log(onloadData)
$(document).ready(function(){
	onloadHandler();
    $('#btnAdd').on('click',function(e){
    	//alert('test');return
        e.preventDefault();
		$("#myModalLabel").text('MASTER HIRARKI FORM: TAMBAH')
		document.getElementById('mode').value="add";
        $("#nikatasan").val('');
        $("#nikKepalaBagian").val('');
        $("#nikKepalaDept").val('');
        $("#nikkaryawan").val('');
        $("#displayKaryawan").show();
        $("#displayKaryawanEdit").hide();
		$("#buttonSave").html('<i class="fa fa-floppy-o" aria-hidden="true"></i> SIMPAN')
        setAutocomplateForm();
        // setAutoComplateHirarki(1,1)
        // setAutoComplateHirarki(2,0)
        // setAutoComplateHirarki(3,0)
        // setAutoComplateHirarki(4,0)
		$("#modalPA").modal('show');
	})

     $('#buttonSave').on('click',function(e){
        e.preventDefault();
        var mode=document.getElementById('mode').value;
        var atasan=document.getElementById('nikatasan').value;
        var kabag=document.getElementById('nikKepalaBagian').value;
        var kadept=document.getElementById('nikKepalaDept').value;
        var karyawan=document.getElementById('nikkaryawan').value;

        //var statusCek=$("input[name='status']:checked").val();
        //window.confirm("Press a button!")
        if(atasan==''){alert('Isikan atasan');$("#nikatasan").focus();return}
        // if(kabag==''){alert('Isikan kepala bagian');$("#nikKepalaBagian").focus();return}
        // if(kadept==''){alert('Isikan kepala deparemen');$("#nikKepalaDept").focus();return}
        if(mode=='add'){
            if(karyawan==''){alert('Isikan karyawan');$("#nikkaryawan").focus();return}
        }
        
        // if(statusCek==undefined){alert('Pilih Status');return}
        //if(marketplaceID==''){mode='add'}else{mode='edit'}
        var confirm =window.confirm('Apa data yang Anda masukkan sudah benar?');
        if(confirm){saveMode(mode)}
        //alert('test')
    })
    $('#tblppkhirarki tbody').on('click','.btnEdit',function(e){
        e.preventDefault();
        $("#myModalLabel").text('MASTER HIRARKI FORM: EDIT')
        document.getElementById('mode').value="edit";
        var dataKry=$(this).attr('data-kry');
        var dataAtasan=$(this).attr('data-atasan');
        var dataKabag=$(this).attr('data-kabag');
        var dataKadep=$(this).attr('data-kadep');
        $("#nikatasan").val(dataAtasan);
        $("#nikKepalaBagian").val(dataKabag);
        $("#nikKepalaDept").val(dataKadep);
        $("#nikkaryawan").val(dataKry);
        $("#karyawanEdit").val(dataKry)
        dataKry=dataKry.split('~')
        $("#txtKaryawanEdit").text(dataKry[0]+' - '+dataKry[1]);
        
        $("#displayKaryawan").hide();
        $("#displayKaryawanEdit").show();
        $("#buttonSave").html('<i class="fa fa-floppy-o" aria-hidden="true"></i> SIMPAN')
        // setAutoComplateHirarki(1,1)
        // setAutoComplateHirarki(2,1)
        // setAutoComplateHirarki(3,1)
        // setAutoComplateHirarki(4,1)
        
        setAutocomplateForm();
       
         //alert(dataKry+'|'+dataAtasan+'|'+dataKabag+'|'+dataKry)
        $("#modalPA").modal('show');
        //selectPureSelect()
    })
    $('#tblppkhirarki tbody').on('click','.btnDel',function(e){
        e.preventDefault();
        var dataKry=$(this).attr('data-kry');
        var url = 'Pamasterhirarkiapps/deleteMode';
        //alert(dataKry)
        $.ajax({
                url: url,
                type: "POST",
                dataType:"text",
                data:({dataKry:dataKry}),
                async:false,
                success: function(result){
                    result=result.split('^');
                    if(result[1]=='sukses'){
                        alert('Data dengan nik di bawah ini\n'+result[0]+'\nBerhasil dihapus...')
                        //$("#modalPA").modal('hide');
                        getData(1);
                    }  
            }
      });	
      
        
    })
	
})

function onloadHandler() {
	getData(1);
}

function getData(hal){
    curHal=hal;
    var txtkaryawanFilter=document.getElementById('txtkaryawanFilter').value;
    cariData(txtkaryawanFilter,hal);
}
function cariData(txtfilter,hal){

    var url = 'Pamasterhirarkiapps/getData';
    //call jQuery AJAX function
    $.ajax({
        url: url,
        type: "POST",
        data: ({txtfilter:txtfilter,hal:hal}),
        dataType: "text",
        success: function(result){
        //console.log(result)
        result=result.split("^");
            $('#tblppkhirarki').children('thead:first').html(result[0]);
            $('#tblppkhirarki').children('tbody:first').html(result[1]);
            if(result[2].trim().length!=0){
                    document.getElementById('linkHal1').style.display='';
                    document.getElementById('linkHal1').innerHTML=result[2];
                }else{
                    document.getElementById('linkHal1').style.display='none';
                }
            document.getElementById('txtkaryawanFilter').value="";
        }
    }); 
}

function getDt(){
    var url = 'Pamasterhirarkiapps/getDt';
    var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            async:false,
            success: function(result){
            //console.log(result);
            dataCallback=result;
            jsonVal=JSON.parse(result);
            //console.log(jsonVal);return
        }
  });	
   return dataCallback; 
}
function setAutocomplateForm(val){
    var arrkar=[];
    var isiVal=val;
    var isiValAtasan=$("#nikatasan").val();
    var isiValkabag=$("#nikKepalaBagian").val();
    var isiValkadep=$("#nikKepalaDept").val();
    var isiValKry=$("#nikkaryawan").val();
    var getData=JSON.parse(onloadData);
    var dataatasan=getData.dtkaryawan;
    var datakaryawan = getData.dtkaryawan;
    

    $("#txtAtasan").html('');
    $("#txtKepalaBagian").html('');
    $("#txtKepalaDepartemen").html('');
    $("#txtKaryawan").html('');
   var atasan = new SelectPure("#txtAtasan",{
        options:datakaryawan,
        value:isiValAtasan,
        // multiple: false,

        //placeholder:"--please select--",
        icon: "fa fa-user",
        autocomplete: true,
        onChange:function(value){
            console.log(this)
            $('#nikatasan').val('');
            //console.log(value)
            var datakaryawan=value;
            //console.log(user)
            $('#nikatasan').val(datakaryawan);
            selectPureSelect();
            
        },
    })
    var karyawan = new SelectPure("#txtKaryawan",{
        options:datakaryawan,
        value:arrkar,
        //placeholder: "-Please select-",
        icon: "fa fa-times",
        multiple: true,
        autocomplete: true,
        onChange:function(value){
            //console.log(value);
            $('#nikkaryawan').val('');
            var datakaryawan=value;
            //console.log(user)
            $('#nikkaryawan').val(datakaryawan);
            selectPureSelect()
        },
    })

    var app1 = new SelectPure("#txtKepalaBagian",{
        options:dataatasan,
        value:isiValkabag,
        // multiple: false,
        // placeholder:"--please select--",
        icon: "fa fa-times",
        autocomplete: true,
        onChange:function(value){
            //console.log(value);
            $('#nikKepalaBagian').val('');
            var dataatasanapp1=value;
            //console.log(user)
            $('#nikKepalaBagian').val(dataatasanapp1);  
            selectPureSelect()
        },
    })
    var app2 = new SelectPure("#txtKepalaDepartemen",{
        options:dataatasan,
        value:isiValkadep,
        // multiple: false,
        // placeholder:"--please select--",
        // icon: "fa fa-times",
        autocomplete: true,
        onChange:function(value){
            //console.log(value);
            $('#txtKepalaDepartemen').val('');
            var dataatasanapp2=value;
            //console.log(user)
            $('#nikKepalaDept').val(dataatasanapp2);
            selectPureSelect()
        },
    })
}

function selectPureSelect(){
    var atasan=$('#nikatasan').val();
    var kabag=$('#nikKepalaBagian').val();
    var kadep=$('#nikKepalaDept').val();
    var karyawan=$('#nikkaryawan').val();
    var karGab=''
    if(atasan!='~~~' && atasan!=''){karGab+=atasan+',';}
    if(kabag!='~~~'  && kabag!=''){karGab+=kabag+',';}
    if(kadep!='~~~'  && kadep!=''){karGab+=kadep+',';}
    if(karyawan!='~~~' && karyawan!=''){karGab+=karyawan+',';}
    
    karGab=karGab.substr(0,karGab.length -1)
   
    karGab=karGab.split(',')
    //console.log(karGab)
    jmlKarGab=karGab.length;
   // console.log(jmlKarGab)
    
    //atasan
    var j=0;

    const selectPureAtasan = document.getElementById("txtAtasan").getElementsByClassName("select-pure__option").length
    for(var i=0;i<selectPureAtasan;i++){
        var dataAtr1=document.getElementById("txtAtasan").getElementsByClassName("select-pure__option")[i].getAttribute("data-value")
        if(karGab.includes(dataAtr1))
        {  
            document.getElementById("txtAtasan").getElementsByClassName("select-pure__option")[i].setAttribute("class", "select-pure__option select-pure__option--selected");
            document.getElementById("txtKaryawan").getElementsByClassName("select-pure__option")[i].setAttribute("class", "select-pure__option select-pure__option--selected");
            document.getElementById("txtKepalaBagian").getElementsByClassName("select-pure__option")[i].setAttribute("class", "select-pure__option select-pure__option--selected");
            document.getElementById("txtKepalaDepartemen").getElementsByClassName("select-pure__option")[i].setAttribute("class", "select-pure__option select-pure__option--selected");
            j++;
        }else{
            document.getElementById("txtAtasan").getElementsByClassName("select-pure__option")[i].setAttribute("class", "select-pure__option");
        } 
        console.log(j)
        if (j === jmlKarGab) { break; }
    }

    // const selectPureKaryawan = document.getElementById("txtKaryawan").getElementsByClassName("select-pure__option").length
    // j=0;
    // for(var i=0;i<selectPureKaryawan;i++){
    //     var dataAtr2=document.getElementById("txtKaryawan").getElementsByClassName("select-pure__option")[i].getAttribute("data-value")
    //     if(karGab.includes(dataAtr2))
    //     {  
    //         document.getElementById("txtKaryawan").getElementsByClassName("select-pure__option")[i].setAttribute("class", "select-pure__option select-pure__option--selected");
    //         j++;
    //     }else{
    //         document.getElementById("txtKaryawan").getElementsByClassName("select-pure__option")[i].setAttribute("class", "select-pure__option");
    //     }    
    //     if (j === jmlKarGab) { break; }   
    // }
    // const selectPureKabag = document.getElementById("txtKepalaBagian").getElementsByClassName("select-pure__option").length
    // j=0;
    // for(var i=0;i<selectPureKabag;i++){
    //     var dataAtr4=document.getElementById("txtKepalaBagian").getElementsByClassName("select-pure__option")[i].getAttribute("data-value")
    //     if(karGab.includes(dataAtr4))
    //     {  
    //         document.getElementById("txtKepalaBagian").getElementsByClassName("select-pure__option")[i].setAttribute("class", "select-pure__option select-pure__option--selected");
    //         j++;
    //     }else{
    //         document.getElementById("txtKepalaBagian").getElementsByClassName("select-pure__option")[i].setAttribute("class", "select-pure__option");
    //     }       
    //     if (j === jmlKarGab) { break; }  
    // }
    // const selectPureKadep = document.getElementById("txtKepalaDepartemen").getElementsByClassName("select-pure__option").length
    // j=0;
    // for(var i=0;i<selectPureKadep;i++){
    //     var dataAtr4=document.getElementById("txtKepalaDepartemen").getElementsByClassName("select-pure__option")[i].getAttribute("data-value")
    //     if(karGab.includes(dataAtr4))
    //     {  
    //         document.getElementById("txtKepalaDepartemen").getElementsByClassName("select-pure__option")[i].setAttribute("class", "select-pure__option select-pure__option--selected");
    //         j++;
    //     }else{
    //         document.getElementById("txtKepalaDepartemen").getElementsByClassName("select-pure__option")[i].setAttribute("class", "select-pure__option");
    //     }    
    //     if (j === jmlKarGab) { break; }    
    // }
}
function getDtHirarki(concategroup){
    //alert(approval);
    // var atasan = document.getElementById('nikatasan');
    // var kabag=document.getElementById('nikKepalaBagian');
    // var kadep=document.getElementById('nikKepalaDept');
    // var karyawan=document.getElementById('nikkaryawan');
    //console.log(concategroup)
    var url = 'Pamasterhirarkiapps/getDtAutocomplate';
    var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            data:({concategroup:concategroup}),
            async:false,
            success: function(result){
            //console.log(result);
            dataCallback=result;
            
        }
  });   
   return dataCallback; 
}
function setAutoComplateHirarki(hirarki,ready){
    //console.log(mode);return
    if(ready==0){
        var tampildata='[{"label":"-Empty-","value":"~~~"}]';
    }else{
        var atasan = $('#nikatasan');
        var kabag = $('#nikKepalaBagian');
        var kadep = $('#nikKepalaDept');
        var karyawan = $('#nikkaryawan');
        var concategroup='';
        
        if(atasan.val()=='' && kabag.val()=='' && kadep.val()=='' && karyawan.val()=='')
        {
            concategroup="('')";
        }else{
            if(atasan.val()!=''){
                atasan=atasan.val().split('~');
                atasan=atasan[1]+"~"+atasan[3];
                concategroup="'"+atasan+"'";
                var concategroup1=concategroup;
            }
            if(kabag.val()!=''){
                kabag=kabag.val().split('~');
                kabag=kabag[1]+"~"+kabag[3];
                if(concategroup==''){concategroup=+"'"+kabag+"'";}
                else{concategroup=concategroup+",'"+kabag+"'"}
                var concategroup2=concategroup;
            }
            if(kadep.val()!=''){
                kadep=kadep.val().split('~');
                kadep=kadep[1]+"~"+kadep[3];
                if(concategroup==''){concategroup=+"'"+kadep+"'";}
                else{concategroup=concategroup+",'"+kadep+"'"}
                var concategroup3=concategroup;
            }
            // if(karyawan.val()!=''){
            //     var karyawanIsi='';
            //     karyawan=karyawan.val().split(',')
            //     for(var i=0;i<karyawan.length;i++){
            //         var splitkaryawan=karyawan[i].split('~');
            //         karyawanIsi+="'"+splitkaryawan[1]+"~"+splitkaryawan[3]+"',"
            //     }
            //     karyawanIsi=karyawanIsi.substr(0,karyawanIsi.length -1);
            //     if(concategroup==''){concategroup=+"'"+karyawanIsi+"'";}
            //     else{concategroup=concategroup+",'"+karyawanIsi+"'"}
            //     console.log(karyawanIsi)
            // }
            if(hirarki==1){concategroup="''";}
            if(hirarki==2){concategroup=concategroup1;}
            if(hirarki==3){concategroup=concategroup2;}
            if(hirarki==4){concategroup=concategroup3;}
            concategroup="("+concategroup+")";
            //console.log(concategroup)
        }
        //console.log(concategroup)
        var tampildata=getDtHirarki(concategroup);
        //console.log(tampildata)
    }
    //console.log(tampildata)
    
    var getVal='';
    var txt='';
    var nik=['atasan','KepalaBagian','KepalaDept','karyawan'];
    var tiple=false;
    if(hirarki==1){txt='Atasan';getVal=$('#nikatasan').val();}
    if(hirarki==2){txt='KepalaBagian';getVal=$('#nikKepalaBagian').val();}
    if(hirarki==3){txt='KepalaDepartemen';getVal=$('#nikKepalaDept').val();}
    if(hirarki==4){txt='Karyawan';tiple=true;getVal=[]}
    //var dataAtasan=getDtApproval(gid);
    var getData=JSON.parse(tampildata);
    //console.log(getData);
    //console.log(getVal);
    //return
    //console.log(divisi)
    //var appke=approval;
    
   $("#txt"+txt).html('');
   new SelectPure("#txt"+txt,{
        options:getData,
        value:getVal,
        multiple: tiple,
        placeholder:"--please select--",
        icon: "fa fa-times",
        autocomplete: true,
        // options:getData,
        // value:getVal,
        // multiple: tiple,
        // placeholder:"--please select--",
        // icon: "fa fa-user",
        // autocomplete: true,
        onChange:function(value){
            $('#nik'+nik[hirarki-1]).val('');
            var datavalue=value;
            $('#nik'+nik[hirarki-1]).val(datavalue); 
            //console.log(nik[hirarki-1]);
            if(hirarki==1){$('#nik'+nik[1]).val(''); setAutoComplateHirarki(2,1); $('#nik'+nik[2]).val(''); setAutoComplateHirarki(3,0);$('#nik'+nik[3]).val('');setAutoComplateHirarki(4,0);}
            if(hirarki==2){$('#nik'+nik[2]).val(''); setAutoComplateHirarki(3,1);$('#nik'+nik[3]).val('');setAutoComplateHirarki(4,0);}
            if(hirarki==3){$('#nik'+nik[3]).val(''); setAutoComplateHirarki(4,1);}

        },
    })
}

function saveMode(e){
    var mode=e;
    var atasan=document.getElementById('nikatasan').value;
    var kabag=document.getElementById('nikKepalaBagian').value;
    var kadept=document.getElementById('nikKepalaDept').value;
    if(mode=='edit'){
        var karyawan=document.getElementById('karyawanEdit').value;
    }else{
        var karyawan=document.getElementById('nikkaryawan').value;
    }
    
    //alert(karyawan);console.log(atasan);return
    
    var url='Pamasterhirarkiapps/saveMode';
    $.ajax({
        url:url,
        type:'POST',
        // contentType:false,
        // cache:false,
        // contentData:false,
        data:({atasan:atasan,kabag:kabag,kadept:kadept,karyawan:karyawan,mode:mode}),
        success:function(result){
            //console.log(result);return
            result=result.split('^');
            if(result[0]!=''){
                alert('Untuk NIK dibawah ini\n'+result[0]+'\nSudah ada!!!')
            }
            if(result[1]=='sukses'){
                $("#modalPA").modal('hide');
                getData(1);
            }
            return
            // console.log(result);
            // result=result.split("~");
                
            // var hal=result[0];
            //     //console.log(hal);return
            // if(result[1]=='sukses' && mode=='add'){
            //     alert('Data Marketplace berhasil ditambah')
            //     getData(hal);
            //     $("#modalFormMastermarketplace").modal('hide');
            // }else if(result[1]=='sukses' && mode=='edit'){
            //     alert('Data Marketplace berhasil diubah');
            //     getData(hal);
            //     $("#modalFormMastermarketplace").modal('hide');
            // }
            
        }
    })
}