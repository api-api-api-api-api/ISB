$(document).ready(function(e){
    var today = new Date();
    var hari,bulan,tahun;
    if(parseInt(today.getDate())<10){hari='0'+today.getDate();}else{hari=today.getDate();}
    if(parseInt((today.getMonth()+1))<10){bulan='0'+(today.getMonth()+1)}else{bulan=(today.getMonth()+1);}
    var date = hari+'-'+bulan+'-'+today.getFullYear();
    var bulanString=['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $("#dateInput").val(date);
    $("#dateTxt").text(hari+' '+bulanString[today.getMonth()]+' '+today.getFullYear());
    $("#tglDibutuhkan").datepicker({
        setDate: new Date(),
        minDate: +1,
        firstDay: 1,
        defaultDate: "d",
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        onSelect: function( selectedDate ) {}
    });  
    
    //check dasar permintaan
    
    $(".checkDasarPermintaan").on('click',function(e){
        $("#checkDasarPermintaanValue").val()
        $(".checkDasarPermintaan").attr('checked',false);
        $(this).prop('checked',true);
        $("#checkDasarPermintaanValue").val($(this).val())
        if($(this).val()=='Lainnya'){
            $("#DasarPermintaanLainnya").attr('readonly',false)
            $("#DasarPermintaanLainnya").val('')
            $("#DasarPermintaanLainnya").focus();
        }else{
            $("#DasarPermintaanLainnya").attr('readonly',true)
            $("#DasarPermintaanLainnya").val('')
        }

        // cari index dengan value penggantian, dan isi di perlu approval dengan value 1, jika tidak isi 0
        // index penggantian ada di : 1,2
        var indexGanti=$( ".checkDasarPermintaan" ).index(this);
        $("#perluApproval").val(indexGanti==1||indexGanti==2?'false':'true');

        
    })

    //check posisi
    $(".checkPosisi").on('click',function(e){
        $(".checkPosisi").attr('checked',false);
        $(this).prop('checked',true);
        if($(this).val()=='Lainnya'){
            $("#posisiLainnya").attr('readonly',false)
            $("#posisiLainnya").val('')
            $("#posisiLainnya").focus();
        }else{
            $("#posisiLainnya").attr('readonly',true)
            $("#posisiLainnya").val('')
        }
        $("#checkPosisiValue").val($(this).val());
    })

    //check status karyawan
    $(".checkStatusKaryawan").on('click',function(e){
        $(".checkStatusKaryawan").attr('checked',false);
        $(this).prop('checked',true);
        //jika index ganti pilihan merupakan karyawan kontrak (index = 1) / maka isi ketererangan
        var indexGanti=$( ".checkStatusKaryawan" ).index(this);
        if(indexGanti==1){
            $("#ketStatusKaryawan").attr('readonly',false)
            $("#ketStatusKaryawan").val('')
            $("#ketStatusKaryawan").focus();
        }else{
            $("#ketStatusKaryawan").attr('readonly',true)
            $("#ketStatusKaryawan").val('')
        }
        $("#checkStatusKaryawanValue").val($(this).val());
    })

    //check jenisKelamin
    $(".jenisKelamin").on('click',function(e){
        $(".jenisKelamin").attr('checked',false);
        $(this).prop('checked',true);
        $("#jenisKelaminValue").val($(this).val());
    })

    //check Pendidikan
    $(".checkPendidikan").on('click',function(e){
        $(".checkPendidikan").attr('checked',false);
        $(this).prop('checked',true);
        if($(this).val()=='Lainnya'){
            $("#pendidikanLainnya").attr('readonly',false)
            $("#pendidikanLainnya").val('')
            $("#pendidikanLainnya").focus();
        }else{
            $("#pendidikanLainnya").attr('readonly',true)
            $("#pendidikanLainnya").val('')
        }
        $("#checkPendidikanValue").val($(this).val());
    })
    
    //check Pengalaman kerja terbagi menjadi 2, lama kerja, dan secara
    //lama kerja
    $(".checkLamaPengalaman").on('click',function(e){
        $(".checkLamaPengalaman").attr('checked',false);
        $(this).prop('checked',true);
        $("#checkLamaPengalamanValue").val($(this).val());
    })
    //secara/in
    $(".secaraIn").on('click',function(e){
        $(".secaraIn").attr('checked',false);
        $(this).prop('checked',true);
        $("#secaraInValue").val($(this).val());
    })

    //penguasaan bahasa
    $(".checkBahasa").on("click",function(e){
        var indexGanti=$( ".checkBahasa" ).index(this);
        if(indexGanti==2){
            $("#checkBahasaValue").val("")
            $(".checkBahasa").attr('checked',false);
            $(this).prop('checked',true);
            $("#checkBahasaValue").val($(this).val()+',')
        }else{
            $("#checkBahasaValue").val("");
            $('.checkBahasa').eq(2).attr('checked',false);
            //alert(document.getElementsByClassName("checkBahasa")[0].checked)
            var isicheckBahasaValue="";
            for(var i =0; i< $(".checkBahasa").length;i++){
                if(document.getElementsByClassName("checkBahasa")[i].checked==true){
                    isicheckBahasaValue+=document.getElementsByClassName("checkBahasa")[i].value+','
                }
            }
            $("#checkBahasaValue").val(isicheckBahasaValue);
        }
    })
    // check penempatan
    $(".checkPenempatan").on('click',function(e){
        var indexGanti=$( ".checkPenempatan" ).index(this);
        $("#checkPenempatanIndex").val("");//get index pilih
        $("#checkPenempatanValue").val("");//get value pilih
        $(".checkPenempatan").attr('checked',false);
        $("#penempatanDetail0").attr('readonly',true);
        $("#penempatanDetail0").val('');
        $("#penempatanDetail1").attr('readonly',true);
        $("#penempatanDetail1").val('');
        $("#penempatanDetail"+indexGanti).attr('readonly',false)
        $("#penempatanDetail"+indexGanti).focus()
        $(this).prop('checked',true)
        $("#checkPenempatanValue").val($(this).val())
        $("#checkPenempatanIndex").val(indexGanti);
    })

    // check keterampilan
    $(".checkKeterampilan").on('click',function(e){
        $(".checkKeterampilan").attr('checked',false);
        $(this).prop('checked',true);
        $("#checkKeterampilanValue").val($(this).val());
        if($(this).val()=='Lainnya'){
            $("#checkKeterampilanLain").attr('readonly',false)
            $("#checkKeterampilanLain").val('')
            $("#checkKeterampilanLain").focus();
        }else{
            $("#checkKeterampilanLain").attr('readonly',true)
            $("#checkKeterampilanLain").val('')
        }
    })

    getData()
})
//ambil data awal user
function getData(){
    url="erfforms/getData";
    $.ajax({
        url:url,
        type: "POST",
		data: ({}),
		dataType: "text",
		success: function(returnedVal){
            //console.log(returnedVal);
            returnedVal=returnedVal.split('~');
            $("#pemohon").val(returnedVal[0]);
            $("#divisi").val(returnedVal[2]);
            $("#jabatan").val(returnedVal[3]);
            $("#atasan").val(returnedVal[4]);
            $("#labelNama").text(returnedVal[1]);
            $("#labelDivisi").text(returnedVal[2]);
            $("#labelJabatan").text(returnedVal[3]);
            //console.log(returnedVal)
        }
    })
}

function simpan(){
    //cek perlu approval
    if($("#perluApproval").val()==0){
        alert("Pilih Dasar Permintaan");
        return;
    }
    //cek dasar permintaan
    if($("#checkDasarPermintaanValue").val()=='Lainnya'){
        //cek DasarPermintaanLainnya
        if($("#DasarPermintaanLainnya").val()==''){
            alert("Isikan Dasar Permintaan Lainnya");
            $("#DasarPermintaanLainnya").focus();
            return
        }

    }
    //cek posisi
    if($("#checkPosisiValue").val()==''){
        alert("Pilih Posisi Permintaan karyawan");
        return;
    }

    //cek tanggal
    if($("#tglDibutuhkan").val()==''){
        alert('Inputkan tanggal dibutuhkan');
        return
    }

    // cek tetap atau kontrak value
    if($("#checkStatusKaryawanValue").val()==''){
        alert('Inputkan status karyawan');
        return;
    }

    if($("#checkStatusKaryawanValue").val()=='Kontrak / Contract'){
        if($("#ketStatusKaryawan").val()==''){
            alert('Isi Keterangan Status Karyawan');
            return
        }
    }

    //cek jenis kelamin
    if($("#jenisKelaminValue").val()==''){
        alert('Inputkan Jenis Kelamin')
        return;
    }

    //cek pendidikan
    if($("#checkPendidikanValue").val()==''){
        alert('Inputkan Pendidikan');
        return;
    }

    if($("#checkPendidikanValue").val()=='Lainnya'){
       if($("#pendidikanLainnya").val()==''){
            alert('Inputkan Pendidikan Lainnya');
            return;
       }
    }

    //cek pengalaman kerja
    if($('#checkLamaPengalamanValue').val()==''){
        alert('Inputkan Pengalaman Kerja');
        return;
    }
    // if($('#secaraInValue').val()==''){
    //     alert('Inputkan Bidang Pengalaman');
    //     return;
    // }
    //cek penguasaan bahasa
    if($('#checkBahasaValue').val()==''){
        alert('Inputkan Penguasaan Bahasa');
        return;
    }

    //cek penempatan
    if($("#checkPenempatanIndex").val()==''){
        alert("Inputkan penempatan kerja");
        return;
    }
    
    if($("#checkPenempatanIndex").val()==0){
        if($("#penempatanDetail0").val()==''){
            alert("Inputkan Penempatan Detail");
            return;
        }
    }
    if($("#checkPenempatanIndex").val()==1){
        if($("#penempatanDetail1").val()==''){
            alert("Inputkan Penempatan Detail");
            return;
        }
    }
    //cek keterampilan
    if($("#checkKeterampilanValue").val()==''){
        alert("Inputkan Keterampilan");
        return;
    }
    if($("#checkKeterampilanValue").val()=='Lainnya'){
        if($("#checkKeterampilanLain").val()==''){
            alert("Inputkan Keterampilan Lainnya");
            return;
        }
    }
    //persyaratan lain persyaratanLain
    if($("#persyaratanLain").val()==''){
        alert("Inputkan Persyaratan Lain");
        return;
    }

    //persyaratan tugas dan tanggung jawan
    if($("#ttjOrlainnya").val()==''){
        alert("Inputkan Tugas Dan Tanggung Jawab / Lainnya");
        return;
    }
    //return
		
	var data=$("#h1form").serializeArray();
	var url = 'Erfforms/simpan';
	$.ajax({
		url: url,
		type: "POST",
		data: data,
		dataType: "text",
		success: function(result){
			//console.log(result);return;
			if(result=='sukses'){
				alert('Data Permohonan Karyawan berhasil disimpan.');
				$("#perluApproval").val(0);
                $("#checkDasarPermintaanValue").val("");
                $("#DasarPermintaanLainnya").val("");
                $("#checkPosisiValue").val("");
                $("#posisiLainnya").val("");
                $("#posisiLainnya").attr('readonly',true);
                $("#tglDibutuhkan").val("");
                $("#ketStatusKaryawan").val("");
                $("#ketStatusKaryawan").attr('readonly',true);
                $("#checkStatusKaryawanValue").val("");
                $("#jenisKelaminValue").val("");
                $("#checkPendidikanValue").val("");
                $("#pendidikanLainnya").val("");
                $("#pendidikanLainnya").attr('readonly',true);
                $("#checkLamaPengalamanValue").val("");
                $("#secaraInValue").val("");
                $("#checkBahasaValue").val("");
                $("#checkPenempatanIndex").val("");
                $("#checkPenempatanValue").val("");
                $("#penempatanDetail0").val("");
                $("#penempatanDetail0").attr('readonly',true);
                $("#penempatanDetail1").val("");
                $("#penempatanDetail1").attr('readonly',true);
                $("#checkKeterampilanValue").val("");
                $("#checkKeterampilanLain").val("");
                $("#checkKeterampilanLain").attr('readonly',true);
                $("#persyaratanLain").val("");
                $("#ttjOrlainnya").val("");
                $("input[type=checkbox]").attr('checked',false);
				//onloadHandler();
				//setSoal(idkry);
				//setSoal(idkry,nikkry,namakry,tgllahirkry)
			}
			
		}
	})
}