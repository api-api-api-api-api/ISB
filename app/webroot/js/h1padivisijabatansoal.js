var serial=0;
var curHal=1;
$(document).ready(function(){
    onLoadHandler();
     //scoup divisi in document function
    $("#tableDivisiSoals tbody").on("click",".editTagDiv",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        $("#lblDiv"+getID).hide();
        $("#idNamaDivisi"+getID).show();
        $("#btnDivEdit"+getID).hide();
        $("#btnDiv"+getID).show();
        // $("#btnSimpanTag"+getID).show();
        // $("#btnBatalTag"+getID).show();
    })
    $("#tableDivisiSoals tbody").on("click",".batalTagDiv",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        $("#lblDiv"+getID).show();
        $("#idNamaDivisi"+getID).hide();
        $("#btnDivEdit"+getID).show();
        $("#btnDiv"+getID).hide();
    })
    

    $("#tableDivisiSoals tbody").on("click",".simpanTagDiv",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        
        var namaDivisi=$("#idNamaDivisi"+getID).val();
       
        if(namaDivisi==''){
            alert('Nama Group harus diisi!');
            $("#idNamaDivisi"+getID).focus();
            return
        }
        //alert(namaDivisi);return
        var url="padivisijabatansoals/simpan";
        $.ajax({
            url: url,
            type: "POST",
            data: ({namaDivisi:namaDivisi,id:getID,CRUD:"update"}),
            dataType: "text",
            success: function(result){
            //console.log(result);return
            if(result='Sukses'){
                alert('Data divisi berhasil dirubah')
                $("#lblDiv"+getID).text(namaDivisi.toUpperCase());
                $("#idNamaDivisi"+getID).val(namaDivisi.toUpperCase());
                $("#lblDiv"+getID).show();
                $("#idNamaDivisi"+getID).hide();
                $("#btnDivEdit"+getID).show();
                $("#btnDiv"+getID).hide();
                }
            }
        });	
        
    })

    $("#tableDivisiSoals tbody").on("click",".hapusTagDiv",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        

        var url="padivisijabatansoals/deleteDivisi";
        var question =confirm('Yakin data akan dihapus?');
        if(question){
            $.ajax({
                url: url,
                type: "POST",
                data: ({id:getID}),
                dataType: "text",
                success: function(result){
                //console.log(result);return
                    if(result=='ada'){
                        alert('Data divisi tidak bisa dihapus,\nkarena divisi tersebut sudah digunakan dalam peruntukan soal ')
                    }else{
                        alert('Data divisi berhasil dihapus');
                        getDataDivisi(result);
                        $("#txtDivisiId").val("");
                        getDataJabatan(1);
                    }                
                
                }
            });	
        }
    })
   
    $("#addDivisi").on("click",function(e){
        e.preventDefault(); 
        var txtInputDivisi=$("#txtInputDivisi").val();
        
        if(txtInputDivisi==''){
            alert('Inputan divisi masih kosong!');
            $("#txtInputDivisi").focus();
            return
        }
        var url="Padivisijabatansoals/simpan";
        $.ajax({
			url: url,
			type: "POST",
			data:({namaDivisi:txtInputDivisi,CRUD:"create"}),
			dataType:"text",
			async:false,
			success: function(result){
                
                var hal=result.substr(6);
                console.log(hal)
                if(result.substr(0,6)=='sukses'){
                    alert('Data divisi berhasil disimpan')
                    getDataDivisi(hal);
                    $("#txtInputDivisi").val('');
                }
			}
		})
    })

    $("#tableDivisiSoals tbody").on('click','.tab',function() {
		$("#tableDivisiSoals tbody tr").removeClass("ativetab");
		var selected = $(this).addClass("ativetab");
		if(!selected)
			$(this).addClass("ativetab");
            $("#txtDivisiId").val("");
            var txtDivisiId=$(this).find('input[name=txtid]').val()
            $("#txtDivisiId").val(txtDivisiId);
            $("#txtInputJabatan").prop('disabled',false)

            getDataJabatan(1);
	});
    // end scoup divisi

    //scoup jabatan
    $("#tableJabatanSoals tbody").on("click",".editTagJab",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        //alert(getID);return
        $("#lblJab"+getID).hide();
        $("#idNamaJabatan"+getID).show();
        $("#btnJabEdit"+getID).hide();
        $("#btnJab"+getID).show();
       
    })

    $("#tableJabatanSoals tbody").on("click",".batalTagJab",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        $("#lblJab"+getID).show();
        $("#idNamaJabatan"+getID).hide();
        $("#btnJabEdit"+getID).show();
        $("#btnJab"+getID).hide();
       
    })

    $("#tableJabatanSoals tbody").on("click",".simpanTagJab",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        //alert(getID);return
        var namaJabatan=$("#idNamaJabatan"+getID).val();
       
        if(namaJabatan==''){
            alert('Nama Group harus diisi!');
            $("#idNamaJabatan"+getID).focus();
            return
        }
        //alert(namaJabatan);return
        var url="padivisijabatansoals/simpanJabatan";
        $.ajax({
            url: url,
            type: "POST",
            data: ({namaJabatan:namaJabatan,id:getID,CRUD:"update"}),
            dataType: "text",
            success: function(result){
            //console.log(result);return
            if(result='sukses'){
                alert('Data jabatan berhasil dirubah')
                $("#lblJab"+getID).text(namaJabatan.toUpperCase());
                $("#idNamaJabatan"+getID).val(namaJabatan.toUpperCase());
                $("#lblJab"+getID).show();
                $("#idNamaJabatan"+getID).hide();
                $("#btnJabEdit"+getID).show();
                $("#btnJab"+getID).hide();
                }
            }
        });	
        
    })

    $("#tableJabatanSoals tbody").on("click",".hapusTagJab",function(e){
        e.preventDefault();
        var getID=$(this).parent().parent().next().text();
        var txtDivisiId=document.getElementById('txtDivisiId').value;

        var url="padivisijabatansoals/deleteJabatan";
        var question =confirm('Yakin data akan dihapus?');
        if(question){
            $.ajax({
                url: url,
                type: "POST",
                data: ({id:getID,txtDivisiId:txtDivisiId}),
                dataType: "text",
                success: function(result){
                    if(result=='ada'){
                        alert('Data jabatan tidak bisa dihapus,\nkarena jabatan tersebut sudah digunakan dalam peruntukan soal ')
                    }else{
                        alert('Data jabatan berhasil dihapus');
                
                        getDataJabatan(result);
                    }
                //console.log(result);return
                
                
                
                }
            });	
        }
    })
    $("#addJabatan").on("click",function(e){
        e.preventDefault(); 
        var txtInputJabatan=$("#txtInputJabatan").val();
        var txtDivisiId=document.getElementById('txtDivisiId').value;
        if(txtDivisiId==''){
            alert('Pilih Divisi Terlebih dahulu');
            return
        }
        if(txtInputJabatan==''){
            alert('Inputan Jabatan masih kosong!');
            $("#txtInputJabatan").focus();
            return
        }
        var url="Padivisijabatansoals/simpanJabatan";
        $.ajax({
			url: url,
			type: "POST",
			data:({namaJabatan:txtInputJabatan,txtDivisiId:txtDivisiId,CRUD:"create"}),
			dataType:"text",
			async:false,
			success: function(result){
                
                var hal=result.substr(6);
                //console.log(hal)
                if(result.substr(0,6)=='sukses'){
                    alert('Data jabatan berhasil disimpan')
                    getDataJabatan(hal);
                    $("#txtInputJabatan").val('');
                }
			}
		})
    })
    // end scoup jabatan

})
function onLoadHandler(){
    $("#txtInputJabatan").prop('disabled',true)
    getDataDivisi(1);
}
//scoup divisi function
function getDataDivisi(hal){
    curHal=hal;
    var txtSrcDivisi=document.getElementById('txtSrcDivisi').value;
    var url="Padivisijabatansoals/getDataDivisi";

    $.ajax({
        url:url,
        type:"POST",
        data:({hal:hal,txtSrcDivisi:txtSrcDivisi,fungsi:'getDataDivisi'}),
        dataType: "text",
        success:function(result){
            //console.log(result);return
            result=result.split("^");
            $('#tableDivisiSoals').children('tbody:first').html(result[0]);
            if(result[1].trim().length!=0){
                document.getElementById('linkHal1').style.display='';
                document.getElementById('linkHal1').innerHTML=result[1];
            }else{
                document.getElementById('linkHal1').style.display='block';
                document.getElementById('linkHal1').innerHTML='...';
            }
        }
    })
    
}

//end scoup divisi


//scoup jabatan function
function getDataJabatan(hal){
    curHal=hal;
    var txtDivisiId=document.getElementById('txtDivisiId').value;
    var url="Padivisijabatansoals/getDataJabatan";
    //alert(txtDivisiId);return
    $.ajax({
        url:url,
        type:"POST",
        data:({hal:hal,txtDivisiId:txtDivisiId,fungsi:'getDataJabatan'}),
        dataType: "text",
        success:function(result){
            //console.log(result);
            result=result.split("^");
            $('#tableJabatanSoals').children('tbody:first').html(result[0]);
            if(result[1].trim().length!=0){
                document.getElementById('linkHal2').style.display='';
                document.getElementById('linkHal2').innerHTML=result[1];
            }else{
                document.getElementById('linkHal2').style.display='block';
                document.getElementById('linkHal2').innerHTML='...';
            }
        }
    })
    
}

//end scoup divisi