var serial=0;
var curHal=1;
$(document).ready(function(){
    onLoadHandler();
    $("#tblJalurRegistrasi tbody").on("click",".editTag",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        
        $("#lbl"+getID).hide();
        $("#idJalurRegistrasi"+getID).show();
        $("#btnDivEdit"+getID).hide();
        $("#btnDiv"+getID).show();
        // $("#btnSimpanTag"+getID).show();
        // $("#btnBatalTag"+getID).show();
    })
    $("#tblJalurRegistrasi tbody").on("click",".batalTag",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        $("#lbl"+getID).show();
        $("#idJalurRegistrasi"+getID).hide();
        $("#btnDivEdit"+getID).show();
        $("#btnDiv"+getID).hide();
        // $("#btnSimpanTag"+data).hide();
        // $("#btnBatalTag"+data).hide();
    })

    $("#tblJalurRegistrasi tbody").on("click",".simpanTag",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        var jalurRegistrasi=$("#idJalurRegistrasi"+getID).val();
        
        if(jalurRegistrasi==''){
            alert('Jalur registrasi harus diisi!');
            $("#idJalurRegistrasi"+getID).focus();
            return
        }
        var url="Fupbmasterjalurregistrasis/saveJalurregistrasi";
        $.ajax({
            url: url,
            type: "POST",
            data: ({jalurRegistrasi:jalurRegistrasi,id:getID,CRUD:"update"}),
            dataType: "text",
            success: function(result){
            // console.log(result);return
            if(result='Sukses'){
                alert('Save Success')
                $("#lbl"+getID).text(jalurRegistrasi);
                $("#lbl"+getID).show();
                $("#idJalurRegistrasi"+getID).hide();
                $("#btnDivEdit"+getID).show();
                $("#btnDiv"+getID).hide();
                
                }
            
            }
        });	
        
    })

    $("#tblJalurRegistrasi tbody").on("click",".hapusTag",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        
        
        //alert(getID);return
        var url="Fupbmasterjalurregistrasis/deleteJalurregistrasi";
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
        var txtInputJalurRegistasi=$("#txtInputJalurRegistasi").val();
        
        if(txtInputJalurRegistasi==''){
            alert('Jalur registrasi harus diisi!');
            $("#txtInputJalurRegistasi").focus();
            return
        }
        var url="Fupbmasterjalurregistrasis/saveJalurregistrasi";
        $.ajax({
            url: url,
            type: "POST",
            data: ({jalurRegistrasi:txtInputJalurRegistasi,CRUD:"create"}),
            dataType: "text",
            success: function(result){
            var hal=result.substr(6);
           
            //console.log(hal);return
            if(result.substr(0,6)=='Sukses'){
                alert('Save Success')
                getData(hal);
                $("#txtInputJalurRegistasi").val('');
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
   // alert(txtJalurRegistrasi);return
    var txtJalurRegistrasi=document.getElementById('txtJalurRegistrasi').value;
    var url="Fupbmasterjalurregistrasis/getData";
 
    $.ajax({
        url:url,
        type:"POST",
        data:({hal:hal,txtJalurRegistrasi:txtJalurRegistrasi,fungsi:'getData'}),
        dataType: "text",
        success:function(result){
            //console.log(result);return
            result=result.split("!");
            $('#tblJalurRegistrasi').children('tbody:first').html(result[0]);
            if(result[1].trim().length!=0){
                document.getElementById('linkHal1').style.display='';
                document.getElementById('linkHal1').innerHTML=result[1];
            }else{
                document.getElementById('linkHal1').style.display='none';
            }
        }
    })
    
}