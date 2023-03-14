var serial=0;
var curHal=1;
$(document).ready(function(){
    onLoadHandler();
    $('#check').on('click',function(e){
        var pass,repass
        pass=document.getElementById('password')
        repass=document.getElementById('repassword')
        if(pass.type==='password' && repass.type==='password'){
            pass.type='text'
            repass.type='text'
        }else{
            pass.type='password'
            repass.type='password'
        }
    })

    $('#password,#repassword').on('keyup', function () {
        if ($('#password').val() == '' && $('#repassword').val()==''){
            $('#message').html('')
        }else if($('#password').val() == $('#repassword').val()) {
            $('#message').html('Matching').css('color', 'green');
        } else 
            $('#message').html('Not Matching').css('color', 'red');
    });
    $('#group').on('change',function(e){
        var id=$(this).val()
        if(id==2){
            document.getElementById("nik").readOnly = false;
            document.getElementById("namaKaryawan").readOnly = false;
            document.getElementById("tglLahir").readOnly = false;
        }else{
            document.getElementById("nik").readOnly = true;
            document.getElementById("namaKaryawan").readOnly = true;
            document.getElementById("tglLahir").readOnly = true;
            $('#nik,#namaKaryawan,#tglLahir').val('')
        }
    })
    // add form maintenance user
    $("#btnForm").on('click',function(e){
        e.preventDefault();
        //$("#canvas__").signaturePad().clear();
        $("#userID").val('')
        $("#namaUser").val('');
        $("#password").val('');
        $("#repassword").val('');
        $("#message").html('');
        $("#check").val('');
        $("#group").html('<option value="">Pilih Group</option>'+getGroup(''));
        $("#statusLock").val(''); 
        $("#idUser").val('');
        $("#penangggungJawab").val('');
        $("#keterangan").val('');
        $("#pejabat").val('');
        // $("#perusahaan").html('<option value="">Pilih Perusahaan</option>'+getPerusahaan(''));
        // $("#divisi").html('<option value="">Pilih Divisi</option>'+getDivisi(''));
        $("#com").html('<option value="">Pilih Kantor Cabang</option>'+getComid(''));
        $("#arco").val('');
        $("#subDivisi").val('');
        $("#reg").val('');
        $("#inisial").val('');
        $("#nik").val('');
        $("#namaKaryawan").val('');
        $("#tglLahir").val('');

        document.getElementById("nik").readOnly = true;
        document.getElementById("namaKaryawan").readOnly = true;
        document.getElementById("tglLahir").readOnly = true;
        // $("#divisi").html('<option value="">Select Divisi</option>'+getDivisi(''))
        // $("#jalurReg").html('<option value="">Select Jalur Registrasi</option>'+getJalurRegistrasi(''))
       
        $("#tglLahir").datepicker({
            setDate: new Date(),
            defaultDate: "d",
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            onSelect: function( selectedDate ) {}
        });  
        $("#myModalLabel").text('FORM USER: TAMBAH')
        $("#buttonSave").html('<i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE USER')
        //SetAutoComplete();
        $("#modalFormMaintenanceUser").modal('show');
        // $("#companyAdd tbody").html('');
    })

    $("#tableMaintenanceUser tbody").on('click','.edtBtn',function(e){
        e.preventDefault();
        var id=$(this).parent().next().text();
        $("#userID").val(id)
        $("#namaUser").val($("#tdNamaUser"+id).text());
        $("#password").val($("#tdpword"+id).text());
        $("#repassword").val($("#tdpword"+id).text());
        $("#group").html('<option value="">Pilih Group</option>'+getGroup($("#tdgroup"+id).text()));
        $("#statusLog").val($("#tdstatusLog"+id).text()); 
        $("#idUser").val($("#tdidUser"+id).text());
        $("#penangggungJawab").val($("#tdpenanggungJawab"+id).text());
        $("#keterangan").val($("#tdketerangan"+id).text());
        $("#pejabat").val($("#tdpejabatId"+id).text());
        // $("#perusahaan").html('<option value="">Pilih Perusahaan</option>'+getPerusahaan($("#tdperusahaanId"+id).text()));
        // $("#divisi").html('<option value="">Pilih Divisi</option>'+getDivisi($("#tddivisi"+id).text()));
        $("#com").html('<option value="">Pilih Kantor Cabang</option>'+getComid($("#tdcomId"+id).text()));
        
        $("#arco").val($("#tdarcoId"+id).text());
        $("#subDivisi").val($("#tdsubDivisi"+id).text());
        $("#reg").val($("#tdreg"+id).text());
        $("#inisial").val($("#tdinisial"+id).text());
        $("#nik").val($("#tdnik"+id).text());
        $("#namaKaryawan").val($("#tdnamaKary"+id).text());
        var tglLhr =$("#tdtglLahir"+id).text();
        // if(tglLhr!==''){
        //     tglLhr=tglLhr.split("-");
        //     tglLhr=tglLhr[2]+"-"+tglLhr[1]+"-"+tglLhr[0];
        //     $("#tglLahir").val(tglLhr);
        // }else{
        //     $("#tglLahir").val('');
        // }
        $("#tglLahir").val(tglLhr);
        
        $("#tglLahir").datepicker({
            setDate: new Date(),
            defaultDate: "d",
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            onSelect: function( selectedDate ) {}
        });  
        if($("#group").val()==2){
            document.getElementById("nik").readOnly = false;
            document.getElementById("namaKaryawan").readOnly = false;
            document.getElementById("tglLahir").readOnly = false;
        }else{
            document.getElementById("nik").readOnly = true;
            document.getElementById("namaKaryawan").readOnly = true;
            document.getElementById("tglLahir").readOnly = true;
        }
        $("#myModalLabel").text('FORM USER: EDIT')
        $("#modalFormMaintenanceUser").modal('show');

    })

    $("#buttonSave").on('click',function(e){
        e.preventDefault();
       
        var crud
        var userID=$("#userID").val();
        if(userID==""){
            crud='add';
        }else{
            crud='edit';
        }
        
        var namaUser=$("#namaUser").val();
        var password=$("#password").val();
        var group=$("#group").val();
        var statusLog=$("#statusLog").val(); 
        var idUser=$("#idUser").val();
        var penanggungJawab=$("#penangggungJawab").val();
        var keterangan=$("#keterangan").val();
        var pejabat=$("#pejabat").val();
        var perusahaan=$("#perusahaan").val();
        var divisi=$("#divisi").val();
        var com=$("#com").val();
        var arco=$("#arco").val();
        var subDivisi=$("#subDivisi").val();
        var reg=$("#reg").val();
        var inisial=$("#inisial").val();
        var nik=$("#nik").val();
        var namaKaryawan=$("#namaKaryawan").val();
        var tglLahir=$("#tglLahir").val();
        if(namaUser==''){
            alert('Username harus diisi')
            $("#namaUser").focus();
            return
        }
        // if(password==''){
        //     alert('Password harus diisi')
        //     $("#password").focus();
        //     return
        // }
        // if(password!==$("#repassword").val()){
        //     alert('Password Not Matching')
        //     return
        // }
        if(group==''){
            alert('Group harus diisi')
            $("#group").focus();
            return
        }
        if(penanggungJawab==''){
            alert('Penanggung jawab harus diisi')
            $("#penanggungJawab").focus();
            return
        }
        if(com==''){
            alert('Kantor cabang harus diisi')
            $("#com").focus();
            return
        }
        if(group==2){
            if(nik==''){
                alert('NIK harus diisi')
                $("#nik").focus();
                return
            }
            if(namaKaryawan==''){
                alert('Nama harus diisi')
                $("#namaKaryawan").focus();
                return
            }
            if(tglLahir==''){
                alert('Tanggal Lahir harus diisi')
                $("#tglLahir").focus();
                return
            }
        }
        
       // alert('test');return
        var url='Maintenanceusers/saveCRUD';
        $.ajax({
            url:url,
            type:"POST",
            data:({
                userID:userID,
                namaUser:namaUser,
                password:password,
                group:group,
                statusLog:statusLog,
                idUser:idUser,
                penanggungJawab:penanggungJawab,
                keterangan:keterangan,
                pejabat:pejabat,
                perusahaan:perusahaan,
                divisi:divisi,
                com:com,
                arco:arco,
                subDivisi:subDivisi,
                reg:reg,
                inisial:inisial,
                nik:nik,
                namaKaryawan:namaKaryawan,
                tglLahir:tglLahir,
                CRUD:crud
            }),
            success:function(result){
                //console.log(result);return
                result=result.split("~");
                //console.log(result);return
                var hal=result[0];
                //console.log(hal);return
                if(result[1]=='sukses' && crud=='add'){
                    alert('Data user berhasil ditambah')
                    getData(hal);
                    $("#modalFormMaintenanceUser").modal('hide');
                }else if(result[1]=='sukses' && crud=='edit'){
                    alert('Data user berhasil diubah');
                    getData(hal);
                    $("#modalFormMaintenanceUser").modal('hide');
                }
            }
        })
    })
   
})

function onLoadHandler(){
    getData(1);
}


function getData(hal){
    curHal=hal;
    var txtNamaUserFilter=document.getElementById('txtNamaUserFilter').value;
    var txtPenanggungJawabFilter=document.getElementById('txtPenanggungJawabFilter').value;
    var txtNamaGroupFilter=document.getElementById('txtNamaGroupFilter').value;
    var txtNIKFilter=document.getElementById('txtNIKFilter').value;
    var txtNamaKaryawanFilter=document.getElementById('txtNamaKaryawanFilter').value;

    var url="Maintenanceusers/getData";

    $.ajax({
        url:url,
        type:"POST",
        data:({hal:hal,
            txtNamaUserFilter:txtNamaUserFilter,
            txtPenanggungJawabFilter:txtPenanggungJawabFilter,
            txtNamaGroupFilter:txtNamaGroupFilter,
            txtNIKFilter:txtNIKFilter,
            txtNamaKaryawanFilter:txtNamaKaryawanFilter,
            fungsi:'getData'
        }),
        dataType: "text",
        success:function(result){
            //console.log(result);return
            result=result.split("!");
            $('#tableMaintenanceUser').children('tbody:first').html(result[0]);
            if(result[1].trim().length!=0){
                document.getElementById('linkHal1').style.display='';
                document.getElementById('linkHal1').innerHTML=result[1];
            }else{
                document.getElementById('linkHal1').style.display='block';
            }
        }
    })
}
function getGroup(data){
    var url = 'Maintenanceusers/getGroup';
    var id=data
    var group
    $.ajax({
        url: url,
        type: "POST",
        data:({id:id}),
        dataType:"text",
        async:false,
        success: function(result){
            group=result;
        //console.log(divisiIsi);
        }
    })
    return group;
}

function getPerusahaan(data){
    var url = 'Maintenanceusers/getPerusahaan';
    var id=data
    var perusahaan
    $.ajax({
        url: url,
        type: "POST",
        data:({id:id}),
        dataType:"text",
        async:false,
        success: function(result){
            perusahaan=result;
        //console.log(divisiIsi);
        }
    })
    return perusahaan;
}
function getDivisi(data){
    var url = 'Maintenanceusers/getDivisi';
    var id=data
    var divisi
    $.ajax({
        url: url,
        type: "POST",
        data:({id:id}),
        dataType:"text",
        async:false,
        success: function(result){
            divisi=result;
        //console.log(divisiIsi);
        }
    })
    return divisi;
}
function getComid(data){
    var url = 'Maintenanceusers/getComid';
    var id=data
    var comid
    $.ajax({
        url: url,
        type: "POST",
        data:({id:id}),
        dataType:"text",
        async:false,
        success: function(result){
            //console.log(result);return
            comid=result;
        //console.log(divisiIsi);
        }
    })
    return comid;
}
