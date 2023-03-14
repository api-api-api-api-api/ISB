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
        var isiTblProd='<tr class="active trCompatitor"><td style="vertical-align:middle;width:22%"><input type="text" class="form-control brands" name="brand[]" id="brand'+i+'"></td><td style="vertical-align:middle;width:15%"><select class="form-control compatitors" name="compatitor[]" id="compatitor'+i+'" onchange="cekExist(this,'+i+')"><option value="">-Select-</option>'+getCompanyCompatitor('')+'</select></td><td style="vertical-align:middle;text-align:center;"><input type="checkbox" class="primKompetitor"  ><input type="hidden" name="primKompetitorisi[]" class="primKompetitorisi" id="primKompetitorisi'+i+'" ></td><td style="vertical-align:middle;width:12%"><input type="text" class="form-control dosages" name="dosage[]" id="dosage'+i+'"></td><td style="vertical-align:middle;width:22%;"><textarea class="form-control unitPacks" id="unitPack'+i+'" name="unitPack[]"></textarea></td><td style="vertical-align:middle;width:12%;"><input type="text" class="form-control priceUnits" name="priceUnit[]" id="priceUnit'+i+'" onKeyUp="upAngka(this)" style="text-align:right;"></td><td style="vertical-align:middle;width:12%;"><input type="text" class="form-control pricePacks" name="pricePack[]" id="pricePack'+i+'" onKeyUp="upAngka(this)" style="text-align:right;"></td><td align="center" id="tdbutton'+i+'" style="vertical-align:middle;width:5%;"><button type="button" class="btn btn-xs btn-default cancelBrand"><span style="color: Tomato;"><i class="fa fa-ban fa-lg" style="margin: 5px 5px;"></i></span></button><input type="hidden" name="idRecord[]" id="idRecord'+i+'"></td></tr>';
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

    //cek exist
    // $("#companyAdd tbody").on('change','.compatitors',function(e){
    //     e.preventDefault();
    //     //console.log( $(this).parent().parent().children().append(isiTblProd))
    //     var thisCompany=$(this)
    //     var company= $("option:selected", this);
       
    //     $('.compatitors').not(this).each(function(){
    //         var company2= $("option:selected", this);
    //         if(company2.val()==company.val()){
    //             alert("Competitor "+company.text()+" sudah pernah dimasukkan");
    //             thisCompany.val("");
    //             return;
    //         }
    //         //alert(company2.val())
    //     });
    //    // alert(company.val());
        
    // })

    
    $("#companyAdd tbody").on('click','.cancelBrand',function(e){
        e.preventDefault();
        //console.log( $(this).parent().parent().children().append(isiTblProd))
        var idRecord=$(this).parent().find("input").val();
        if(idRecord==''){
            $(this).parent().parent().remove();
        }else{
            var url="fupbs/deleteRecord";
            $.ajax({
                url: url,
                type: "POST",
                data:({id:idRecord}),
                dataType:"text",
                async:false,
                success: function(result){
                //alert(result)
                //console.log(companyCompatitors);
                $(this).parent().parent().remove();
                
                }
            })
        }
    })

    $("#companyAdd tbody").on('change','select[name="compatitor[]"]',function(e){
        e.preventDefault();
        var companyID=$(this).val();
        var getCompanyName=$(this).children("option:selected").text();       
    })

    $("#btnForm").on('click',function(e){
        e.preventDefault();
        //alert('test')
        //$("#canvas__").signaturePad().clear();
        $("#txtNoteReturn").hide();
        $("#fupbId").val('');
        $("#txtDivisi").html('');
        $("#divisiDipilih").val('');
        $("#divisiDipilihID").val('');
        $("#divisiDipilihNama").val('');
        //$("#txtDivisi").SelectPure().reset();
        $('.sigPad').signaturePad().clearCanvas();;
        
        $("#genID").val(''); 
        $("#nd").val('');
        $("#tb").val('')
        $("#noFupb").val('')
        $("#naProd").val('')
        $("#komposisi").val('')
        $("#dosis").val('')
        $("#indikasi").val('');
        $("#aturanPakai").val('')
        $("#sediaanBentuk").val('')
        $("#sediaanRasa").val('')
        $("#sediaanWarna").val('')
        $("#sediaanAroma").val('')
        $("#sediaan").val('')
        $("#kemasan").val('')
        $("#jumKompetitor").val('')
        $("#jalurReg").val('')
        $("#targetPriceBox").val('')
        $("#targetPriceUnit").val('')
        $("#fcth1qty").val('');
        $("#fcth2qty").val('');
        $("#fcth3qty").val('');
        $("#fcth1value").val('');
        $("#fcth2value").val('');
        $("#fcth3value").val('');
        $("#infoTambahan").val('');

        $("#divisi").html('<option value="">Select Divisi</option>'+getDivisi(''))
        $("#jalurReg").html('<option value="">Select Jalur Registrasi</option>'+getJalurRegistrasi(''))
        $("#companyAdd tbody").html('');
        var today = new Date();
        var hari,bulan,tahun;
        if(parseInt(today.getDate())<10){hari='0'+today.getDate();}else{hari=today.getDate();}
        if(parseInt((today.getMonth()+1))<10){bulan='0'+(today.getMonth()+1)}else{bulan=(today.getMonth()+1);}
        var date = hari+'-'+bulan+'-'+today.getFullYear();
        $("#tglFupb").val(date);
        $("#tglFupb,#startDate,#endDate").datepicker({
            setDate: new Date(),
            defaultDate: "d",
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            onSelect: function( selectedDate ) {}
        });  
        $("#buttonSave").html('<i class="fa fa-floppy-o" aria-hidden="true"></i> Save')
        SetAutoComplete();
        $("#modalFormFUPB").modal('show');
        // $("#companyAdd tbody").html('');
    })

    $("#getDataFUPB").on('click','.btlBtn',function(e){
        e.preventDefault();
        //var ketBatal = prompt("Keterangan Pembatalan", "");
        $("#txtIdFupb").val("");
        $("#tglPembatalan").val("");
        $("#txtAlasanPembatalan").val("");
        var id=$(this).parent().next().text();
        $("#txtIdFupb").val(id);
        $("#tglPembatalan").datepicker({
            setDate: new Date(),
            changeYear: true,
            changeMonth: true,
            numberOfMonths: 1,
            dateFormat: 'dd-mm-yy',
            onSelect: function (dateStr) {
                var min = $(this).datepicker('getDate'); // Get selected date
            }
        })
        $("#modalPembatalan").modal("show");

        // if (ketBatal != null) {
        //     alert("Hello " + ketBatal + "! How are you today?")
        //     var url="fupbs/pembatalan";
        // }else{
        //     return;
        // }       
    })

    $("#tmblSavePembatalan").on('click',function(e){
        e.preventDefault();
        var id=$("#txtIdFupb").val();
        var tglPembatalan=$("#tglPembatalan").val();
        var alasanPembatalan=$("#txtAlasanPembatalan").val();

        if(tglPembatalan==''){
            alert('Tanggal pembatalan harus diisi ')
            $("#tglPembatalan").focus();
            return
        }
        if(alasanPembatalan==''){
            alert('Alasan Pembatalan harus diisi ')
            $("#txtAlasanPembatalan").focus();
            return
        }

        var url="fupbs/pembatalan";

        $.ajax({
            url:url,
            type:"POST",
            data:({id:id,tglPembatalan:tglPembatalan,alasanPembatalan:alasanPembatalan}),
                success:function(result){
                //console.log(result);return
                alert("Pengajuan pembatalan sukses dibuat");

                //console.log(result);return;
                onLoadHandler();
                $("#modalPembatalan").modal('hide');
                //console.log(result)
            }
        })

    })

    $("#getDataFUPB").on('click','.edtBtn',function(e){
        e.preventDefault();
        $("#fupbId").val('');
        $("#divisiDipilih").val('');
        var id=$(this).parent().next().text();
        var textareaBrand=$("#textareaBrand"+id).val();
        $("#fupbId").val(id);
        var noteReturn=$(this).attr("data-noteReturn")
        var nd=$(this).attr("data-ND")
        var tb=$(this).attr("data-TB")
        var tanggal=$(this).attr("data-TANGGAL")
        var noFUPB=$(this).attr("data-NOFUPB")
        var namaProject=$(this).attr("data-NAMAPROJECT")
        var datadivisi=$(this).attr("data-DIVISI")
        var datadivID=$(this).attr("data-DIVISIID")
        var datadivNama=$(this).attr("data-DIVISINAMA")
        var komposisi=$(this).attr("data-KOMPOSISI")
        var dosis=$(this).attr("data-DOSIS")
        var indikasi=$(this).attr("data-INDIKASI")
        var aturanPakai=$(this).attr("data-ATURANPAKAI")
        var sediaan=$(this).attr("data-SEDIAAN")
        var kemasan=$(this).attr("data-KEMASAN")
        var jumlahkompetitor=$(this).attr("data-JUMLAHKOMPETITOR")
        var jalurRegistrasi=$(this).attr("data-JALURREGISTRASI")
        //tambahan
        var targetPriceBox=$(this).attr("data-TARGETPRICEBOX")
        var targetPriceUnit=$(this).attr("data-TARGETPRICEUNIT")
        var fcth1qty=$(this).attr("data-FCTH1QTY")
        var fcth2qty=$(this).attr("data-FCTH2QTY")
        var fcth3qty=$(this).attr("data-FCTH3QTY")
        var fcth1value=$(this).attr("data-FCTH1VALUE")
        var fcth2value=$(this).attr("data-FCTH2VALUE")
        var fcth3value=$(this).attr("data-FCTH3VALUE")
        var infoTambahan=$(this).attr("data-INFOTAMBAHAN")
        var ujiBa=$(this).attr("data-UJIBA")
        var skm=$(this).attr("data-SKM")
        if (tanggal !== null || tanggal !== '') {
            tanggal=tanggal.split('-');
            $("#tglFupb").val(tanggal[2]+'-'+tanggal[1]+'-'+tanggal[0]);
        }else{
            $("#tglFupb").val('');
        }
        sediaan=sediaan.split("~");
        $("#txtNoteReturn").show();
        $("#txtNoteReturn").text("Keterangan Dikembalikan: "+noteReturn+"");
        $("#nd").val(nd);
        $("#tb").val(tb);
        $("#divisiDipilih").val(datadivisi);
        $("#divisiDipilihID").val(datadivID);
        $("#divisiDipilihNama").val(datadivNama);
        $("#noFupb").val(noFUPB);
        $("#naProd").val(namaProject);
        //$("#divisi").html('<option value="">Select Divisi</option>'+getDivisi(divID))
        $("#jalurReg").html('<option value="">Select Jalur Registrasi</option>'+getJalurRegistrasi(jalurRegistrasi))
        $("#komposisi").val(komposisi);
        $("#dosis").val(dosis);
        $("#indikasi").val(indikasi);
        $("#aturanPakai").val(aturanPakai);
        $("#sediaanBentuk").val(sediaan[0]);
        $("#sediaanRasa").val(sediaan[1]);
        $("#sediaanWarna").val(sediaan[2]);
        $("#sediaanAroma").val(sediaan[3]);
        $("#kemasan").val(kemasan);
        $("#jumKompetitor").val(jumlahkompetitor);
        $("#jalurReg").val(jalurRegistrasi);
        $("#targetPriceBox").val(targetPriceBox)
        $("#targetPriceUnit").val(targetPriceUnit)
        $("#fcth1qty").val(fcth1qty);
        $("#fcth2qty").val(fcth2qty);
        $("#fcth3qty").val(fcth3qty);
        $("#fcth1value").val(fcth1value);
        $("#fcth2value").val(fcth2value);
        $("#fcth3value").val(fcth3value);
        $("#infoTambahan").val(infoTambahan);
        $("#ujiBa"+ujiBa).prop("checked", true);

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

        $(".sigPad").signaturePad().clearCanvas();
        SetAutoComplete();
        $("#modalFormFUPB").modal('show');
        //alert(generateID)
    })

    $("#getDataFUPB").on('click','.printBtn1',function(e){
        e.preventDefault();
        $("#idCetakPDF").val('');
        $("#lampiranCetak").val('');
        var baris=$(this).parent().parent().parent().parent().find('input').val();
        
        var id=$("#genId"+baris).text();
        //alert(id);return
        document.getElementById('idCetakPDF').value=id;
        document.getElementById('lampiranCetak').value='Lampiran1';
        //alert(getGenerateID);return
        document.fupbReport.action='Fupbs/cetakpdf';
        document.fupbReport.target='_blank';
        document.fupbReport.submit();
    })
    $("#getDataFUPB").on('click','.printBtn2',function(e){
        e.preventDefault();
        $("#idCetakPDF").val('');
        $("#lampiranCetak").val('');
        var baris=$(this).parent().parent().parent().parent().find('input').val();
        
        var id=$("#genId"+baris).text();
        //alert(id);return
        document.getElementById('idCetakPDF').value=id;
        document.getElementById('lampiranCetak').value='Lampiran2';
        //alert(getGenerateID);return
        document.fupbReport.action='Fupbs/cetakpdf';
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
    $("#buttonSave").on('click',function(e){
        e.preventDefault();
        var divisiNama=$("#divisi").children("option:selected").text();
        var url="fupbs/saveFUPB";
        var data='';
        // alert($("#genID").val());return
        //cek isian
        if($("#nd").val()==''){
            alert('The ND field is required ')
            $("#nd").focus();
            return
        }
        if($("#tb").val()==''){
            //alert('The TB field is required ')
            //$("#tb").focus();
            //return
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
        // if($("#divisi").val()==''){
        //     alert('The Divisi field is required ')
        //     $("#divisi").focus();
        //     return
        // }
        if($("#komposisi").val()==''){
            alert('The Komposisi field is required ')
            $("#komposisi").focus();
            return
        }
        // if($("#dosis").val()==''){
        //     alert('The Dosis field is required ')
        //     $("#dosis").focus();
        //     return
        // }
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

        if($("#sediaanBentuk").val()==''){
            alert('Sediaan Bentuk  is required ')
            $("#sediaanBentuk").focus();
            return
        }
        if($("#sediaanRasa").val()==''){
            alert('Sediaan Rasa is required ')
            $("#sediaanRasa").focus();
            return
        }
        if($("#sediaanWarna").val()==''){
            alert('Sediaan Warna is required ')
            $("#sediaanWarna").focus();
            return
        }
        if($("#sediaanAroma").val()==''){
            alert('Sediaan Aroma is required ')
            $("#sediaanAroma").focus();
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
        if($("#targetPriceBox").val()==''){
            alert('Target Price Box field is required ')
            $("#targetPriceBox").focus();
            return
        }
        if($("#targetPriceUnit").val()==''){
            alert('Target Price Unit field is required ')
            $("#targetPriceUnit").focus();
            return
        }
        if($("#fcth1qty").val()==''){
            alert('Forecase Qty Tahun 1 field is required ')
            $("#fcth1qty").focus();
            return
        }
        if($("#fcth2qty").val()==''){
            alert('Forecase Qty Tahun 2 field is required ')
            $("#fcth2qty").focus();
            return
        }
        if($("#fcth3qty").val()==''){
            alert('Forecase Qty Tahun 3 field is required ')
            $("#fcth3qty").focus();
            return
        }
        if($("#fcth1value").val()==''){
            alert('Forecase Value Tahun 1 field is required ')
            $("#fcth1value").focus();
            return
        }
        if($("#fcth2value").val()==''){
            alert('Forecase Value Tahun 2 field is required ')
            $("#fcth2value").focus();
            return
        }
        if($("#fcth3value").val()==''){
            alert('Forecase Value Tahun 3 field is required ')
            $("#fcth3value").focus();
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
        var sediaan=$("#sediaanBentuk").val()+'~'+$("#sediaanRasa").val()+'~'+$("#sediaanWarna").val()+'~'+$("#sediaanAroma").val()
        //alert(sediaan)
        if(document.getElementById('canvas__')!=='undefined' && document.getElementById('canvas__')!==null){		
            if(isCanvasBlank(document.getElementById('canvas__'))=='true'){
                alert('Harap bubuhkan tanda tangan untuk approve data');return;
                }
            var photo = document.getElementById('canvas__').toDataURL('image/jpeg');		
        }
        if($("#infoTambahan").val()==''){
            alert('Input Tambahan field is required ')
            $("#infoTambahan").focus();
            return
        }
        

        data=$("#fupbForm").serializeArray();
        //data.push({name:'divisiNama',value:divisiNama});
        data.push({name:'sediaan',value:sediaan})
        var compatitorClass=$('.compatitors')
        
        for (var i=0;i<compatitorClass.length;i++){
            
            var compatitorNama=$(compatitorClass[i]).children("option:selected").text();
            data.push({name:'compatitorName[]',value:compatitorNama});
        }

        data.push({name:'photo',value:photo});
        //console.log(url);return
        //console.log(data);return
        $.ajax({
            url:url,
            type:"POST",
            data:data,
            success:function(result){
                //console.log(result);return
                alert("Fupb berhasil ditambahkan");

                //console.log(result);return;
                onLoadHandler();
                $("#modalFormFUPB").modal('hide');
                //console.log(result)
            }
        })
        
        //var v = $("#fupbForm").serializeObject();
        // var divisiNama=$("#divisi").children("option:selected").text();
        // var url="fupbs/saveFUPB";
        // var data='';

        // //cek isian
        // if($("#nd").val()==''){
        //     alert('The ND field is required ')
        //     $("#nd").focus();
        //     return
        // }
        // if($("#tb").val()==''){
        //     alert('The TB field is required ')
        //     $("#tb").focus();
        //     return
        // }
        // if($("#tglFupb").val()==''){
        //     alert('The Tanggal FUPB field is required ')
        //     $("#tglFupb").focus();
        //     return
        // }
        // if($("#noFupb").val()==''){
        //     alert('The No. FUPB field is required ')
        //     $("#noFupb").focus();
        //     return
        // }
        // if($("#naProd").val()==''){
        //     alert('The Nama Project field is required ')
        //     $("#naProd").focus();
        //     return
        // }
        // if($("#divisi").val()==''){
        //     alert('The Divisi field is required ')
        //     $("#divisi").focus();
        //     return
        // }
        // if($("#komposisi").val()==''){
        //     alert('The Komposisi field is required ')
        //     $("#komposisi").focus();
        //     return
        // }
        // if($("#dosis").val()==''){
        //     alert('The Dosis field is required ')
        //     $("#dosis").focus();
        //     return
        // }
        // if($("#indikasi").val()==''){
        //     alert('The Indikasi field is required ')
        //     $("#indikasi").focus();
        //     return
        // }
        // if($("#aturanPakai").val()==''){
        //     alert('The Aturan Pakai field is required ')
        //     $("#aturanPakai").focus();
        //     return
        // }
        // if($("#sediaan").val()==''){
        //     alert('The Sediaan field is required ')
        //     $("#sediaan").focus();
        //     return
        // }
        // if($("#kemasan").val()==''){
        //     alert('The Kemasan field is required ')
        //     $("#kemasan").focus();
        //     return
        // }
        // if($("#jumKompetitor").val()==''){
        //     alert('The Jumlah Kompetitor field is required ')
        //     $("#jumKompetitor").focus();
        //     return
        // }
        // if($("#jalurReg").val()==''){
        //     alert('The Jalur Registrasi field is required ')
        //     $("#jalurReg").focus();
        //     return
        // }
        // var i=$("#companyAdd tbody").html();
        // if(i==''){
        //     alert('Compatitors is empty')
        //     return;
        // }
        // cekInputCompatitors=document.getElementsByClassName('active').length;
        // for(var q=0;q<cekInputCompatitors;q++){
        //     var brands= document.getElementsByClassName("brands")[q];
        //     var compatitors=document.getElementsByClassName("compatitors")[q];
        //     var dosages=document.getElementsByClassName("dosages")[q];
        //     var unitPacks= document.getElementsByClassName("unitPacks")[q];
        //     var priceUnits=document.getElementsByClassName("priceUnits")[q];
        //     var pricePacks=document.getElementsByClassName("pricePacks")[q];
        //     if(brands.value==""){
        //         alert("Brand Name is required");
        //         brands.focus()
        //         return;
        //     }
        //     if(compatitors.value==""){
        //         alert("Company compatitor is required");
        //         compatitors.focus()
        //         return;
        //     }
        //     if(dosages.value==""){
        //         alert("Dosage is required");
        //         dosages.focus()
        //         return;
        //     }
        //     if(unitPacks.value==""){
        //         alert("Unit / Pack is required");
        //         unitPacks.focus()
        //         return;
        //     }
        //     if(priceUnits.value==""){
        //         alert("Price / unit is required");
        //         priceUnits.focus()
        //         return;
        //     }
        //     if(pricePacks.value==""){
        //         alert("Price / pack is required");
        //         pricePacks.focus()
        //         return;
        //     }
        // }
        // data=$("#fupbForm").serializeArray();
        // data.push({name:'divisiNama',value:divisiNama});
        // var compatitorClass=$('.compatitors')
       
        // for (var i=0;i<compatitorClass.length;i++){
            
        //     var compatitorNama=$(compatitorClass[i]).children("option:selected").text();
        //     data.push({name:'compatitorName[]',value:compatitorNama});
        // }
        // //return
        // $.ajax({
        //     url:url,
        //     type:"POST",
        //     data:data,
        //     success:function(result){
        //         onLoadHandler();
        //         console.log(result)
        //     }
        // })

    })
})


function onLoadHandler(){
    $("#startDate").val('');
    $("#endDate").val('');
    $("#noFupbSrc").val('');
    $("#namaProjectSrc").val('');
   
    
    $("#startDate").datepicker({
        setDate: new Date(),
        changeYear: true,
        changeMonth: true,
        numberOfMonths: 1,
        dateFormat: 'dd-mm-yy',
        onSelect: function (dateStr) {
            var min = $(this).datepicker('getDate'); // Get selected date
           $("#endDate").datepicker('option', 'minDate', min || '0'); // Set other min, default to today
        }
    })
    $("#endDate").datepicker({
        setDate: new Date(),
        minDate: '0',
        defaultDate: "d",
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        onSelect: function( selectedDate ) {}
    }); 
    
    $("#searchFupb").on('click',function(e){
        e.preventDefault();
        //cek selisih hari
        var start = $("#startDate").datepicker("getDate");
        var end = $("#endDate").datepicker("getDate");
        var days = (end - start) / (1000 * 60 * 60 * 24);
        //cek variable

        var valStart=$("#startDate").val();
        var valEnd=$("#endDate").val();

        if(valStart!=''){
           if(valEnd==''){
               alert('Isi tanggal Akhir')
               $("#endDate").focus();
               return
           }
        }
        if(valEnd!=''){
            if(valStart==''){
                alert('Isi tanggal Awal')
                $("#startDate").focus();
                return
            }
        }
        getData(1);

    })
    getData(1);
    
    //clear form fupb
}

function SetAutoComplete(){
    var data=$("#divisiDipilih").val();
    var divisiIsi
    if(data==''){
        divisiIsi=[];
    }else{
        //console.log(data);return
        data = data.split(",");
        //console.log(data);return
        divisiIsi=data;

    }
    var divisiData=selectDivisi('');

    //console.log(divisiIsi);return  
    $("#txtDivisi").html('');
    //console.log(divisiData);
    var autocomplete = new SelectPure("#txtDivisi", {
        options: divisiData,
        placeholder: "-Please select-",
        icon: "fa fa-times",
        value: divisiIsi,
        multiple: true,
        autocomplete: true,
        onChange: value => {
            $("#divisiDipilihID").val('');
            $("#divisiDipilihNama").val('');
            $("#divisiDipilih").val('');   
            if(value.length==0){

            }else{
                $("#divisiDipilih").val(value);
                var dataDivSplit=$("#divisiDipilih").val().split(",");
                console.log(value.length)
                var jum = dataDivSplit.length,divisiDipilihID='',divisiDipilihNama='';
                
                for(var i=0;i<jum;i++){
                    divisiDipilihID+=dataDivSplit[i].split("~")[0]+',';
                    divisiDipilihNama+=dataDivSplit[i].split("~")[1]+',';
                }
                $("#divisiDipilihID").val(divisiDipilihID.slice(0, -1));
                $("#divisiDipilihNama").val(divisiDipilihNama.slice(0, -1));
            }
            
        },
        
    })

}

function selectDivisi(data){
    var url = 'fupbs/selectDivisi';
    var id=data
    var divisiIsi
    $.ajax({
        url: url,
        type: "POST",
        data:({id:id}),
        dataType:"text",
        async:false,
        success: function(result){
            //console.log(result)
            divisiIsi=JSON.parse(result);
        
        }
    });	
    return divisiIsi;
}
function cekExist(obj,curIndex){
	objCompetitor=document.getElementsByName('compatitor[]');
	for(n=0;n<objCompetitor.length;n++){
		if(objCompetitor[n].value==obj.value && objCompetitor[n].id!=obj.id){
			alert("Kompetitor "+obj.options[obj.selectedIndex].text+" sudah pernah dimasukkan");
			obj.value="";
			return;
			
			}
		}
	}
function getData(hal){
    curHal=hal;
    var data;

    data=$("#fupbReport").serializeArray();
    data.push({name:'hal',value:hal});
    var url="fupbs/getData";
    $.ajax({
        url:url,
        type:"POST",
        data:data,
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

function getDivisi(data){
    var url = 'fupbs/getDivisi';
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

function getJalurRegistrasi(data){
    var url = 'fupbs/getJalurRegistrasi';
    var jalurRegistrasi=data
    var jaRegIsi
    $.ajax({
        url: url,
        type: "POST",
        data:({jalurRegistrasi:jalurRegistrasi}),
        dataType:"text",
        async:false,
        success: function(result){
        jaRegIsi=result;
        //console.log(jaRegIsi);
        }
    })
    return jaRegIsi;
}
function getCompanyCompatitor(){
    var url = 'fupbs/getCompanyCompatitor';
    var companyCompatitors
    $.ajax({
        url: url,
        type: "POST",
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

function closeModal(){
    $("#modalFormFUPB").modal('hide');
    onLoadHandler();
}