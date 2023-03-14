
$(document).ready(function(){

    getdata(1);    
})



function getdata(hal){



        var url ="paperiodepenilaians/getdata";
                
        $.ajax({
            url:url,
            type:"POST",
            data: ({fungsi:"getdata",hal:hal}),
            success:function(result){
               
                  returnedVal=result.split("!");
                //console.log(result);return
                $("#tblperiode").html(returnedVal[0]);
                $("#linkHal").html(returnedVal[1]);
            }
        })

}

function updatestatus(id){
  
        var txtupdatestatus= $("#txtupdatestatus").val();

        var url ="paperiodepenilaians/updatestatus";
                
        $.ajax({
            url:url,
            type:"POST",
            data: ({id:id,status:txtupdatestatus}),
            success:function(result){
                  
                  getdata(1);
            }
        })
}

function savedata(){

        var tglstart= $("#tglstart").val();
         var tglend= $("#tglend").val();
         var namaperiode= $("#namaperiode").val();

        var url ="paperiodepenilaians/savedata";
                
        $.ajax({
            url:url,
            type:"POST",
            data: ({namaperiode:namaperiode,tglstart:tglstart,tglend:tglend}),
            success:function(result){
                  
                  getdata(1);
            }
        })

}



function addsoal(data){
    window.location.replace("banksoals/"+data);

}

function editstatus(data){
$("#modaledit").modal("show");
var namaperiode=$("#xtxtnamaperiode_"+data).val();
var tglstart=$("#xtxtperiodestart_"+data).val();
var tglend=$("#xtxtperiodeend_"+data).val();
var status=$("#xtxtstatusperiode_"+data).val();

if(status=="EDITABLE"){

}else{
$("#xtxtnamaperiode").prop('readonly', true);
$("#xtxttglstart").prop('readonly', true);
$("#xtxttglend").prop('readonly', true);
}

$("#xtxtid").val(data);
$("#xtxtnamaperiode").val(namaperiode);
$("#xtxttglstart").val(tglstart);
$("#xtxttglend").val(tglend);
$("#xtxtstatus").html(status);
}

function updateperiode(){

var id=$("#xtxtid").val();
var namaperiode=$("#xtxtnamaperiode").val();
var tglstart=$("#xtxttglstart").val();
var tglend=$("#xtxttglend").val();
var status=$("#xtxtupdatestatus").val();

        var url ="paperiodepenilaians/updateperiode";
                
        $.ajax({
            url:url,
            type:"POST",
            data: ({id:id,namaperiode:namaperiode,tglstart:tglstart,tglend:tglend,status:status}),
            success:function(result){
                alert(result);
                  getdata(1);
            }
        })
}




