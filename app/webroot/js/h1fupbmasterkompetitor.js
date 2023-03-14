var serial=0;
var curHal=1;
$(document).ready(function(){
    onLoadHandler();
    $("#tblKompetitor tbody").on("click",".editTag",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        $("#lbl"+getID).hide();
        $("#idNama"+getID).show();
        $("#btnDivEdit"+getID).hide();
        $("#btnDiv"+getID).show();
        // $("#btnSimpanTag"+getID).show();
        // $("#btnBatalTag"+getID).show();
    })
    $("#tblKompetitor tbody").on("click",".batalTag",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        $("#lbl"+getID).show();
        $("#idNama"+getID).hide();
        $("#btnDivEdit"+getID).show();
        $("#btnDiv"+getID).hide();
        // $("#btnSimpanTag"+data).hide();
        // $("#btnBatalTag"+data).hide();
    })

    $("#tblKompetitor tbody").on("click",".simpanTag",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        var namaCompany=$("#idNama"+getID).val();
        
        if(namaCompany==''){
            alert('Nama perusahaan kompetitor harus diisi!');
            $("#idNama"+getID).focus();
            return
        }
        var url="fupbmasterkompetitors/saveKompetitor";
        $.ajax({
            url: url,
            type: "POST",
            data: ({namaCompany:namaCompany,id:getID,CRUD:"update"}),
            dataType: "text",
            success: function(result){
            // console.log(result);return
            if(result='Sukses'){
                alert('Save Success')
                $("#lbl"+getID).text(namaCompany);
                $("#lbl"+getID).show();
                $("#idNama"+getID).hide();
                $("#btnDivEdit"+getID).show();
                $("#btnDiv"+getID).hide();
                
                }
            
            }
        });	
        
    })

    $("#tblKompetitor tbody").on("click",".hapusTag",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        
        
        //alert(getID);return
        var url="fupbmasterkompetitors/deleteKompetitor";
        var question =confirm('Yakin data akan dihapus?');
        if(question){
            $.ajax({
                url: url,
                type: "POST",
                data: ({id:getID}),
                dataType: "text",
                success: function(result){
                //console.log(result);return
                alert('Delete Success');
                getData(result);
                // if(result='Sukses'){
                //     alert('Save Success')
                //     $("#lbl"+getID).text(namaCompany);
                //     $("#lbl"+getID).show();
                //     $("#idNama"+getID).hide();
                //     $("#btnDivEdit"+getID).show();
                //     $("#btnDiv"+getID).hide();
                    
                //     }
                
                }
            });	
        }
    })

    $(".addTag").on("click",function(e){
        e.preventDefault(); 
        var txtInputKompetitor=$("#txtInputKompetitor").val();
        
        if(txtInputKompetitor==''){
            alert('Nama perusahaan kompetitor harus diisi!');
            $("#txtInputKompetitor").focus();
            return
        }
        var url="fupbmasterkompetitors/saveKompetitor";
        $.ajax({
            url: url,
            type: "POST",
            data: ({namaCompany:txtInputKompetitor,CRUD:"create"}),
            dataType: "text",
            success: function(result){
            var hal=result.substr(6);
           
            //console.log(hal);return
            if(result.substr(0,6)=='Sukses'){
                alert('Save Success')
                getData(hal);
                $("#txtInputKompetitor").val('');
            }
            
            }
        });	
    })
})
function onLoadHandler(){
   getData(1);
}
function getData(hal){
    curHal=hal;
    var txtNamaKompetitor=document.getElementById('txtNamaKompetitor').value;
    var url="fupbmasterkompetitors/getData";

    $.ajax({
        url:url,
        type:"POST",
        data:({hal:hal,txtNamaKompetitor:txtNamaKompetitor,fungsi:'getData'}),
        dataType: "text",
        success:function(result){
            //console.log(result);return
            result=result.split("!");
            $('#tblKompetitor').children('tbody:first').html(result[0]);
            if(result[1].trim().length!=0){
                document.getElementById('linkHal1').style.display='';
                document.getElementById('linkHal1').innerHTML=result[1];
            }else{
                document.getElementById('linkHal1').style.display='none';
            }
        }
    })
    
}