var serial=0;
var curHal=1;
$(document).ready(function () {
   
    onLoadHandler();
    $("#getDataFupbApp tbody").on('click','.btnConfirm',function(e){
        e.preventDefault();
        var idHisFupb=$(this).parent().find('input[name=fupbhisID]').val();
        var genID=$(this).parent().find('input[name=genID]').val();
       // alert($(this).parent().find('input[name=akses]').val());return
       //alert(genID);return
        if(document.getElementById('canvas__'+genID)!=='undefined' && document.getElementById('canvas__'+genID)!==null){		
            if(isCanvasBlank(document.getElementById('canvas__'+genID))=='true'){
                alert('Harap bubuhkan tanda tangan untuk simpan data');return;
                }
            var photo = document.getElementById('canvas__'+genID).toDataURL('image/jpeg');		
        }
        
        var url="fupbappls/saveConfirm";
        $.ajax({
            url:url,
            type:"POST",
            data:({idHisFupb:idHisFupb,photo:photo}),
            success:function(result){
                //console.log(result)
                onLoadHandler();
            }
        })
    })
    $("#getDataFupbApp tbody").on('click','.btnReturn',function(e){
        $("#txtidHisFupb").val('');
        $('#txtAlasanReturn').val('');
        var idHisFupb=$(this).parent().find('input').val();
        $("#txtidHisFupb").val(idHisFupb);
        
        $("#modalReturn").modal('show');
        return
        //alert(idHisFupb);return        
    })

    $('#tmblSaveReturn').on('click',function(e){
        var idHisFupb=$("#txtidHisFupb").val();
        var alasanReturn=$('#txtAlasanReturn').val();

        if(alasanReturn==''){
            alert('Isikan alasan dikembalikan')
            $('#txtAlasanReturn').focus();
            return
        }
        var question =confirm('Kembalikan Data?');
        //return;
        if(question){
            var url="fupbappls/saveReturn";
            $.ajax({
                url:url,
                type:"POST",
                data:({idHisFupb:idHisFupb,alasanReturn:alasanReturn}),
                success:function(result){
                    alert("Return Success");
                    $("#modalReturn").modal('hide');
                    onLoadHandler();
                }
            })
        }
    })


    $("#getDataFupbApp tbody").on('click','.btnTerminate',function(e){
        var idHisFupb=$(this).parent().find('input').val()
        var genID=$(this).parent().find('input[name=genID]').val();
        if(document.getElementById('canvas__'+genID)!=='undefined' && document.getElementById('canvas__'+genID)!==null){		
            if(isCanvasBlank(document.getElementById('canvas__'+genID))=='true'){
                alert('Harap bubuhkan tanda tangan untuk simpan data');return;
                }
            var photo = document.getElementById('canvas__'+genID).toDataURL('image/jpeg');		
        }
        
        
        //alert(idHisFupb);return
        var url="fupbappls/saveTerminate";
        $.ajax({
            url:url,
            type:"POST",
            data:({idHisFupb:idHisFupb,photo:photo}),
            success:function(result){
                alert(result)
                onLoadHandler();
            }
        })
    })
    $("#getDataFupbAPP tbody").on('click','.printBtn',function(e){
        e.preventDefault();
        $("#idCetakPDF").val('');
        var getGenerateID=$(this).parent().next().text();
        document.getElementById('idCetakPDF').value=getGenerateID;
        //alert(getGenerateID);
        document.fupbAppl.action='fupbappls/cetakpdf';
        document.fupbAppl.target='_blank';
        document.fupbAppl.submit();
       

    })
})

function onLoadHandler(){
    getData(1);
}
function getData(hal){
    curHal=hal;
    var url="fupbappls/getData";
    $.ajax({
        url:url,
        type:"POST",
        data:({hal:hal}),
        success:function(result){
            //console.log(result);return
            result=result.split("^");
            $('#getDataFupbApp').children('tbody:first').html(result[0]);
            if(result[1].trim().length!=0){
                document.getElementById('linkHal1').style.display='';
                document.getElementById('linkHal1').innerHTML=result[1];
            }else{
                document.getElementById('linkHal1').style.display='none';
            }
            $('.sigPad').signaturePad({
                drawOnly:true,
                drawBezierCurves:true,
                lineTop:200
            });
        }

    })
}
function isCanvasBlank(canvas) {
	isBlank='true';
	//canvas=document.getElementById('canvas_1');
	dataCanvas=canvas.getContext('2d').getImageData(0, 0, canvas.width, canvas.height).data;
	dataCanvas=dataCanvas.filter((v, i, a) => a.indexOf(v) === i); 
	for(i=0;i<dataCanvas.length;i++){
		if(dataCanvas[i]!='255' && dataCanvas[i]!='222' && dataCanvas[i]!='204')
	{isBlank='false';break}	
		}

return isBlank;
}