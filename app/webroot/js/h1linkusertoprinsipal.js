var serial=0;
var curHal=1;
$(document).ready(function(){
    onloadHandler()
    $("#btnADD").on('click',function(e){
        e.preventDefault();
        $("#myModalLabel").text("ADD DATA");
        $("#txtIdPrincipal").val('');
        $("#txtUserID").val('');
        $("#txtUserID").html('');
        $("#txtPrincipal").html('<option value="">Select Principal</option>'+getPrincipal(''))
        autocompleteUser('')
        $("#modalCRUD").modal('show');
    })
    $("#tablePrincipal").on('click','.edtBtn',function(e){
        e.preventDefault();
        var id=$(this).parent().next().text();
        var userId=$("#userId"+id).text();
        var principalId=$("#principalId"+id).text();
        $("#txtIdPrincipal").val(id);
        $("#txtUserID").val(userId);
        $("#txtPrincipal").html('<option value="">Select Principal</option>'+getPrincipal(principalId))
        autocompleteUser(userId)
        $("#modalCRUD").modal('show');
    })

    $("#tablePrincipal tbody").on("click",".delBtn",function(e){
        e.preventDefault();
        
        var getID=$(this).parent().next().text();
        
        //alert(getID);return
        //alert(getID);return
        var url="linkusertoprinsipals/deleteCURD";
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
})
function onloadHandler(){
    getData(1);
}
function getData(hal){
    curHal=hal;
    var txtNamaPenanggungaJawab=document.getElementById('txtNamaPenanggungaJawab').value;
   
    //console.log(txtPelanggaranBBF)
    
    var url="linkusertoprinsipals/getData";

    $.ajax({
        url:url,
        type:"POST",
        data:({hal:hal,
            txtNamaPenanggungaJawab:txtNamaPenanggungaJawab,
            fungsi:'getData'}),
            dataType: "text",
            success:function(result){
            //console.log(result);return
            result=result.split("!");
            $('#tablePrincipal').children('tbody:first').html(result[0]);
            if(result[1].trim().length!=0){
                document.getElementById('linkHal1').style.display='';
                document.getElementById('linkHal1').innerHTML=result[1];
            }else{
                document.getElementById('linkHal1').style.display='block';
            }
        }
    })
}
function getPrincipal(data){
    var url = 'linkusertoprinsipals/getPrincipal';
    var id=data
    var principalIsi
    $.ajax({
        url: url,
        type: "POST",
        data:({id:id}),
        dataType:"text",
        async:false,
        success: function(result){
        principalIsi=result;
        //console.log(divisiIsi);
        }
    })
    return principalIsi;
}

function getUser(data){
    var url = 'linkusertoprinsipals/getUser';
    var id=data
    var userIsi
    $.ajax({
        url: url,
        type: "POST",
        data:({id:id}),
        dataType:"text",
        async:false,
        success: function(result){
            //console.log(result);return
            userIsi=JSON.parse(result);
        }
    });	
    return userIsi;
}

function autocompleteUser(set){
    var userDipilih=set;  
    //console.log(userDipilih);  
    var userData=getUser('');
    //console.log(userDipilih);return  
    $("#autocompleteUser").html('');
    //console.log(userData);
    var autocomplete = new SelectPure("#autocompleteUser", {
        options: userData,
        placeholder: "-Please select-",
        icon: "fa fa-times",
        value: userDipilih,
        multiple: false,
        autocomplete: true,
        onChange: value => {
            $("#txtUserID").val('');
            $("#txtUserID").val(value);            
        },
        
    })

}

function saveCURD(){
    var txtIdPrincipal=$("#txtIdPrincipal").val();
    var txtUserID = $("#txtUserID").val();
    var txtPrincipal = $("#txtPrincipal").val();
    
    if(txtUserID==''){
        alert('Masukkan Penanggung Jawab');
        return
    }
 
    if(txtPrincipal==''){
        alert('Pilih Principal');
        $("#txtPrincipal").focus();
        return
    }
    if(txtIdPrincipal){
        var crud='edit';
    }else{
        var crud='simpan';
    }
    
    var url ="linkusertoprinsipals/saveCURD";

    $.ajax({
        url:url,
        type:"POST",
        data:({
                txtIdPrincipal:txtIdPrincipal,
                txtUserID:txtUserID,
                txtPrincipal:txtPrincipal,
                crud:crud
            }),
        success:function(result){
           result=result.split("~");
           var hal=result[0];
            //console.log(hal);return
            if(result[1]=='sukses' && crud=='simpan'){
                alert('Data berhasil ditambah')
                getData(hal);
                $("#modalCRUD").modal('hide');
            }else if(result[1]=='sukses' && crud=='edit'){
                alert('Data berhasil diubah');
                getData(hal);
                $("#modalCRUD").modal('hide');
            }else{
                alert('Data sudah ada');
                return
            }
            
        }
    })
}