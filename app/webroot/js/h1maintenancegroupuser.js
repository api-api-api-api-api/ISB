var serial=0;
var curHal=1;
$(document).ready(function(){
    onLoadHandler();
    $("#tableMasterGroup tbody").on("click",".editTag",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        $("#lbl"+getID).hide();
        $("#idNama"+getID).show();
        $("#btnDivEdit"+getID).hide();
        $("#btnDiv"+getID).show();
        // $("#btnSimpanTag"+getID).show();
        // $("#btnBatalTag"+getID).show();
    })
    $("#tableMasterGroup tbody").on("click",".batalTag",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        $("#lbl"+getID).show();
        $("#idNama"+getID).hide();
        $("#btnDivEdit"+getID).show();
        $("#btnDiv"+getID).hide();
        // $("#btnSimpanTag"+data).hide();
        // $("#btnBatalTag"+data).hide();
    })

    $("#tableMasterGroup tbody").on("click",".simpanTag",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        
        var namaGroup=$("#idNama"+getID).val();
       
        if(namaGroup==''){
            alert('Nama Group harus diisi!');
            $("#idNama"+getID).focus();
            return
        }
        var url="Maintenancegroupusers/saveCRUD";
        $.ajax({
            url: url,
            type: "POST",
            data: ({namaGroup:namaGroup,id:getID,CRUD:"update"}),
            dataType: "text",
            success: function(result){
            //console.log(result);return
            if(result='Sukses'){
                alert('Save Success')
                $("#lbl"+getID).text(namaGroup);
                $("#lbl"+getID).show();
                $("#idNama"+getID).hide();
                $("#btnDivEdit"+getID).show();
                $("#btnDiv"+getID).hide();
                
                }
            
            }
        });	
        
    })

    $("#tableMasterGroup tbody").on("click",".hapusTag",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        
        
        //alert(getID);return
        var url="Maintenancegroupusers/deleteGroup";
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

    $(".addGroup").on("click",function(e){
        e.preventDefault(); 
        var txtInputGroup=$("#txtInputGroup").val();
        
        if(txtInputGroup==''){
            alert('Nama Group harus diisi!');
            $("#txtInputGroup").focus();
            return
        }
        var url="Maintenancegroupusers/saveCRUD";
        $.ajax({
            url: url,
            type: "POST",
            data: ({namaGroup:txtInputGroup,CRUD:"create"}),
            dataType: "text",
            success: function(result){
            var hal=result.substr(6);
           
            //console.log(hal);return
            if(result.substr(0,6)=='Sukses'){
                alert('Save Success')
                getData(hal);
                $("#txtInputGroup").val('');
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
    var txtNamaGroup=document.getElementById('txtNamaGroup').value;
    var url="Maintenancegroupusers/getData";

    $.ajax({
        url:url,
        type:"POST",
        data:({hal:hal,txtNamaGroup:txtNamaGroup,fungsi:'getData'}),
        dataType: "text",
        success:function(result){
            //console.log(result);return
            result=result.split("!");
            $('#tableMasterGroup').children('tbody:first').html(result[0]);
            if(result[1].trim().length!=0){
                document.getElementById('linkHal1').style.display='';
                document.getElementById('linkHal1').innerHTML=result[1];
            }else{
                document.getElementById('linkHal1').style.display='block';
            }
        }
    })
    
}