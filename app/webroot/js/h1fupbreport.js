var serial=0;
var curHal=1

$(document).ready(function () {
    $('.sigPad').signaturePad({
        drawOnly:true,
        drawBezierCurves:true,
        lineTop:200
    });
        
    onLoadHandler();
    $("#btnAddCompatitors").on('click',function(e){
        var tblProd=$("#companyAdd tbody tr")
        var i=tblProd.length +1 
        //<input type="text" class="form-control" name="compatitorName[]" id="compatitorName'+i+'">
        var isiTblProd='<tr class="active trCompatitor"><td style="vertical-align:middle;width:22%"><input type="text" class="form-control brands" name="brand[]" id="brand'+i+'"></td><td style="vertical-align:middle;width:15%"><select class="form-control compatitors" name="compatitor[]" id="compatitor'+i+'" ><option value="">-Select-</option>'+getCompanyCompatitor('')+'</select></td><td style="vertical-align:middle;"><input type="checkbox" class="primKompetitor"  ><input type="hidden" name="primKompetitorisi[]" class="primKompetitorisi" id="primKompetitorisi'+i+'" ></td><td style="vertical-align:middle;width:12%"><input type="text" class="form-control dosages" name="dosage[]" id="dosage'+i+'"></td><td style="vertical-align:middle;width:22%;"><input type="text" class="form-control unitPacks" name="unitPack[]" id="unitPack'+i+'"></td><td style="vertical-align:middle;width:12%;"><input type="text" class="form-control priceUnits" name="priceUnit[]" id="priceUnit'+i+'" onKeyUp="upAngka(this)" style="text-align:right;"></td><td style="vertical-align:middle;width:12%;"><input type="text" class="form-control pricePacks" name="pricePack[]" id="pricePack'+i+'" onKeyUp="upAngka(this)" style="text-align:right;"></td><td align="center" id="tdbutton'+i+'" style="vertical-align:middle;width:5%;"><button type="button" class="btn btn-xs btn-default cancelBrand"><span style="color: Tomato;"><i class="fa fa-ban fa-lg" style="margin: 5px 5px;"></i></span></button><input type="hidden" name="idRecord[]" id="idRecord'+i+'"></td></tr>';
        //$('#tblRecordProdER tbody tr').last().after(isiTblProd);
        // console.log(isiTblProd);return
        $("#companyAdd tbody").append(isiTblProd)
    }) 
    $("#companyAdd tbody").on('change','.primKompetitor',function(e){
        e.preventDefault()
        var checks=$('.primKompetitor')
        for(var i =0; i< checks.length;i++){
            var check = checks[i];
            if(!check.disabled){
                check.checked = false;
                check.value="";
                $(".primKompetitorisi").eq(i).val('');
            }
        }
        
        e.target.checked = true;
       
        $(this).parent().find('.primKompetitorisi').val('true');
        console.log($(this).parent().find('.primKompetitorisi').val())
        // console.log($(this).parent().find('input').prop('checked', true))
        // $(this).parent().find('input').attr('checked', true);
       
        //alert()
    })

    $("#companyAdd tbody").on('click','.cancelBrand',function(e){
        e.preventDefault();
        //console.log( $(this).parent().parent().children().append(isiTblProd))
        var idRecord=$(this).parent().find("input").val();
        if(idRecord==''){
            $(this).parent().parent().remove();
        }else{
            var url="Fupbreports/deleteRecord";
            $.ajax({
                url: url,
                type: "POST",
                data:({id:idRecord}),
                dataType:"text",
                async:false,
                success: function(result){
                alert(result)
                //console.log(companyCompatitors);
                $(this).parent().parent().remove();
                }
            })
        }
        
        
        // var table=document.getElementById("companyAdd")
        // for (var i = 1, row; row = table.rows[i]; i++) {
        //     //alert(row)
        //     var col=row.cells[0];
        //     col.innerHTML=i;
        // }
    })
    $("#companyAdd tbody").on('change','select[name="compatitor[]"]',function(e){
        e.preventDefault();
        var companyID=$(this).val();
        var getCompanyName=$(this).children("option:selected").text();
        
        // nomor=$(this).parent().prev().prev().text();
        // //alert(nomor)

        // product=$(this).parent().find('input');
        // alert(countryID+'-'+prodCode+'-'+url+'-'+product.val())
        //return        
    })
    $("#getDataFUPB").on('click','.edtBtn',function(e){
        e.preventDefault();
        $("#genID").val('');
        var generateID=$(this).parent().next().text();
        var textareaBrand=$("#textareaBrand"+generateID).val();
        $("#genID").val(generateID);
        var nd=$(this).attr("data-ND")
        var tb=$(this).attr("data-TB")
        var tanggal=$(this).attr("data-TANGGAL")
        var noFUPB=$(this).attr("data-NOFUPB")
        var namaProject=$(this).attr("data-NAMAPROJECT")
        var divID=$(this).attr("data-DIVISI")
        var komposisi=$(this).attr("data-KOMPOSISI")
        var dosis=$(this).attr("data-DOSIS")
        var indikasi=$(this).attr("data-INDIKASI")
        var aturanPakai=$(this).attr("data-ATURANPAKAI")
        var sediaan=$(this).attr("data-SEDIAAN")
        var kemasan=$(this).attr("data-KEMASAN")
        var jumlahkompetitor=$(this).attr("data-JUMLAHKOMPETITOR")
        var jalurRegistrasi=$(this).attr("data-JALURREGISTRASI")
        var skm=$(this).attr("data-SKM")
        if (tanggal !== null || tanggal !== '') {
            tanggal=tanggal.split('-');
            $("#tglFupb").val(tanggal[2]+'-'+tanggal[1]+'-'+tanggal[0]);
        }else{
            $("#tglFupb").val('');
        }
        
        
        $("#nd").val(nd);
        $("#tb").val(tb);
        
        $("#noFupb").val(noFUPB);
        $("#naProd").val(namaProject);
        $("#divisi").html('<option value="">Select Divisi</option>'+getDivisi(divID))
        $("#komposisi").val(komposisi);
        $("#dosis").val(dosis);
        $("#indikasi").val(indikasi);
        $("#aturanPakai").val(aturanPakai);
        $("#sediaan").val(sediaan);
        $("#kemasan").val(kemasan);
        $("#jumKompetitor").val(jumlahkompetitor);
        $("#jalurReg").val(jalurRegistrasi);
        $("#"+skm).prop("checked", true);
        $("#buttonSave").html('<i class="fa fa-floppy-o" aria-hidden="true"></i> Save Edit')

        var tblProd=$("#companyAdd tbody")
        tblProd.html('');
        //console.log(textareaBrand);return
        //<input type="text" class="form-control" name="compatitorName[]" id="compatitorName'+i+'">
        var isiTblProd=textareaBrand;
        //$('#tblRecordProdER tbody tr').last().after(isiTblProd);
        $("#companyAdd tbody").html(isiTblProd)
        
        $("#tglFupb").datepicker({
            setDate: new Date(),
            defaultDate: "d",
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            onSelect: function( selectedDate ) {}
        });  
        $("#modalFormFUPB").modal('show');
        //alert(generateID)
    })
    $("#getDataFUPB").on('click','.printBtn1',function(e){
        e.preventDefault();
        $("#idCetakPDF").val('');
        $("#lampiranCetak").val('');
        var baris=$(this).parent().parent().parent().parent().find('input').val();
        
        var getGenerateID=$("#genId"+baris).text();
        document.getElementById('idCetakPDF').value=getGenerateID;
        document.getElementById('lampiranCetak').value='Lampiran1';
        //alert(getGenerateID);return
        document.fupbReport.action='Fupbreports/cetakpdf';
        document.fupbReport.target='_blank';
        document.fupbReport.submit();
    })
    $("#getDataFUPB").on('click','.printBtn2',function(e){
        e.preventDefault();
        $("#idCetakPDF").val('');
        $("#lampiranCetak").val('');
        var baris=$(this).parent().parent().parent().parent().find('input').val();
        var getGenerateID=$("#genId"+baris).text();
        document.getElementById('idCetakPDF').value=getGenerateID;
        document.getElementById('lampiranCetak').value='Lampiran2';
        //alert(getGenerateID);return
        document.fupbReport.action='Fupbreports/cetakpdf';
        document.fupbReport.target='_blank';
        document.fupbReport.submit();
    })

    $.fn.serializeObject = function()
    {var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
    };
    
    
})

function onLoadHandler(){
    //show modal
    getData(1);
    $("#btnForm").on('click',function(e){
        e.preventDefault();
        $("#genID").val(''); 
        $("#nd").val('');
        $("#tb").val('')
        $("#noFupb").val('')
        $("#naProd").val('')
        $("#komposisi").val('')
        $("#dosis").val('')
        $("#indikasi").val('');
        $("#aturanPakai").val('')
        $("#sediaan").val('')
        $("#kemasan").val('')
        $("#jumKompetitor").val('')
        $("#jalurReg").val('')
        $("#divisi").html('<option value="">Select Divisi</option>'+getDivisi(''))
        $("#companyAdd tbody").html('');
        var today = new Date();
        var hari,bulan,tahun;
        if(parseInt(today.getDate())<10){hari='0'+today.getDate();}else{hari=today.getDate();}
        if(parseInt((today.getMonth()+1))<10){bulan='0'+(today.getMonth()+1)}else{bulan=(today.getMonth()+1);}
        var date = hari+'-'+bulan+'-'+today.getFullYear();
        $("#tglFupb").val(date);
        $("#tglFupb").datepicker({
            setDate: new Date(),
            defaultDate: "d",
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            onSelect: function( selectedDate ) {}
        });  
        $("#buttonSave").html('<i class="fa fa-floppy-o" aria-hidden="true"></i> Save')
        $("#modalFormFUPB").modal('show');
        // $("#companyAdd tbody").html('');
    })
    //clear form fupb
    
}
function getData(hal){
    curHal=hal;
    var url="Fupbreports/getData";
    $.ajax({
        url:url,
        type:"POST",
        data:({hal:hal}),
        success:function(result){
            //console.log(result);return;
            result=result.split("^");
            $('#getDataFUPB').children('tbody:first').html(result[0]);
            if(result[1].trim().length!=0){
                document.getElementById('linkHal1').style.display='';
                document.getElementById('linkHal1').innerHTML=result[1];
            }else{
                document.getElementById('linkHal1').style.display='none';
            }
        }

    })
}

//form FUPB
function getDivisi(data){
    var url = 'Fupbreports/getDivisi';
    var id=data
    var divisiIsi
    $.ajax({
        url: url,
        type: "POST",
        data:({id:id}),
        dataType:"text",
        async:false,
        success: function(result){
        divisiIsi=result;
        //console.log(divisiIsi);
        }
    })
    return divisiIsi;
}
function getCompanyCompatitor(data){
    var url = 'Fupbreports/getCompanyCompatitor';
    var id=data
    var companyCompatitors
    $.ajax({
        url: url,
        type: "POST",
        data:({id:id}),
        dataType:"text",
        async:false,
        success: function(result){
        companyCompatitors=result;
        //console.log(companyCompatitors);
        }
    })
    return companyCompatitors;
}

function upAngka(str,itemId){

	if(str.value=="-"){
		str.value=0;
		}
	if(parseInt(str.value)<0){
		str.value=str.value*(-1);
		}

	var re = /^[0-9-',']*$/;
	if (!re.test(str.value)) {
		str.value = str.value.replace(/[^0-9-',']/g,"");
				
	}
	if(str.value==""||str.value=="NaN"){
		str.value=""
	}else{
	str.value=formatCurrency(str.value,",",".", 0)
	//formatNumberField(str);
	}

	//hitungHargaSat(str,itemId)
}

function formatCurrency(amount, decimalSeparator, thousandsSeparator, nDecimalDigits){  
	amount=amount+'';
	amount=amount.replace(",",".");
    var num = parseFloat( amount ); //convert to float  

    //default values  
    decimalSeparator = decimalSeparator || '.';  
    thousandsSeparator = thousandsSeparator || ',';  
    nDecimalDigits = nDecimalDigits == null? 2 : nDecimalDigits;  
  
    var fixed = num.toFixed(nDecimalDigits); //limit or add decimal digits  
    //separate begin [$1], middle [$2] and decimal digits [$4]  
    var parts = new RegExp('^(-?\\d{1,3})((?:\\d{3})+)(\\.(\\d{' + nDecimalDigits + '}))?$').exec(fixed);   
 
    if(parts){ //num >= 1000 || num < = -1000  
        return parts[1] + parts[2].replace(/\d{3}/g, thousandsSeparator + '$&') + (parts[4] ? decimalSeparator + parts[4] : '');  
    }else{  
        return fixed.replace('.', decimalSeparator);  
    }  
} 

function simpanFUPB(){
        //var v = $("#fupbForm").serializeObject();
        var divisiNama=$("#divisi").children("option:selected").text();
        var url="Fupbreports/saveFUPB";
        var data='';
        // alert($("#genID").val());return
        //cek isian
        if($("#nd").val()==''){
            alert('The ND field is required ')
            $("#nd").focus();
            return
        }
        if($("#tb").val()==''){
            alert('The TB field is required ')
            $("#tb").focus();
            return
        }
        if($("#tglFupb").val()==''){
            alert('The Tanggal FUPB field is required ')
            $("#tglFupb").focus();
            return
        }
        if($("#noFupb").val()==''){
            alert('The No. FUPB field is required ')
            $("#noFupb").focus();
            return
        }
        if($("#naProd").val()==''){
            alert('The Nama Project field is required ')
            $("#naProd").focus();
            return
        }
        if($("#divisi").val()==''){
            alert('The Divisi field is required ')
            $("#divisi").focus();
            return
        }
        if($("#komposisi").val()==''){
            alert('The Komposisi field is required ')
            $("#komposisi").focus();
            return
        }
        if($("#dosis").val()==''){
            alert('The Dosis field is required ')
            $("#dosis").focus();
            return
        }
        if($("#indikasi").val()==''){
            alert('The Indikasi field is required ')
            $("#indikasi").focus();
            return
        }
        if($("#aturanPakai").val()==''){
            alert('The Aturan Pakai field is required ')
            $("#aturanPakai").focus();
            return
        }
        if($("#sediaan").val()==''){
            alert('The Sediaan field is required ')
            $("#sediaan").focus();
            return
        }
        if($("#kemasan").val()==''){
            alert('The Kemasan field is required ')
            $("#kemasan").focus();
            return
        }
        if($("#jumKompetitor").val()==''){
            alert('The Jumlah Kompetitor field is required ')
            $("#jumKompetitor").focus();
            return
        }
        if($("#jalurReg").val()==''){
            alert('The Jalur Registrasi field is required ')
            $("#jalurReg").focus();
            return
        }
        var i=$("#companyAdd tbody").html();
        if(i==''){
            alert('Compatitors is empty')
            return;
        }
        cekInputCompatitors=document.getElementsByClassName('trCompatitor').length;
        //alert(cekInputCompatitors);
        var checked='';
        for(var q=0;q<cekInputCompatitors;q++){
            var brands= $(".brands").eq(q);
            var compatitors= $(".compatitors").eq(q);
            var dosages= $(".dosages").eq(q);
            var unitPacks= $(".unitPacks").eq(q);
            var priceUnits= $(".priceUnits").eq(q);
            var pricePacks= $(".pricePacks").eq(q);
                checked+=$('.primKompetitorisi').eq(q).val();
               // console.log(checked);
            // var compatitors=document.getElementsByClassName("compatitors")[q];
            // var dosages=document.getElementsByClassName("dosages")[q];
            // var unitPacks= document.getElementsByClassName("unitPacks")[q];
            // var priceUnits=document.getElementsByClassName("priceUnits")[q];
            // var pricePacks=document.getElementsByClassName("pricePacks")[q];
            
            if(brands.val()==""){
                alert("Brand Name is required");
                brands.focus()
                return;
            }
            if(brands.val()==""){
                alert("Brand Name is required");
                brands.focus()
                return;
            }
            if(compatitors.val()==""){
                alert("Company compatitor is required");
                compatitors.focus()
                return;
            }
            if(dosages.val()==""){
                alert("Dosage is required");
                dosages.focus()
                return;
            }
            if(unitPacks.val()==""){
                alert("Unit / Pack is required");
                unitPacks.focus()
                return;
            }
            if(priceUnits.val()==""){
                alert("Price / unit is required");
                priceUnits.focus()
                return;
            }
            if(pricePacks.val()==""){
                alert("Price / pack is required");
                pricePacks.focus()
                return;
            }
        }
        if(checked==''){alert('Check salah satu kompatitor utama');return;}

        if(document.getElementById('canvas__')!=='undefined' && document.getElementById('canvas__')!==null){		
            if(isCanvasBlank(document.getElementById('canvas__'))=='true'){
                alert('Harap bubuhkan tanda tangan untuk approve data');return;
                }
            var photo = document.getElementById('canvas__').toDataURL('image/jpeg');		
        }

        data=$("#fupbForm").serializeArray();
        data.push({name:'divisiNama',value:divisiNama});
        var compatitorClass=$('.compatitors')
       
        for (var i=0;i<compatitorClass.length;i++){
            
            var compatitorNama=$(compatitorClass[i]).children("option:selected").text();
            data.push({name:'compatitorName[]',value:compatitorNama});
        }

        data.push({name:'photo',value:photo});
        //console.log(url);return
        //return
        //console.log(data);return
        $.ajax({
            url:url,
            type:"POST",
            data:data,
            success:function(result){
                //alert(result);return

                //console.log(result);return;
                onLoadHandler();
                $("#modalFormFUPB").modal('hide');
                //console.log(result)
            }
        })
}
//canvas
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
