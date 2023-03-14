
$(document).ready(function(){
	
	// function atau prosedur yang berhubungan dengan set karyawan
	// set awal karyawan
	$("#btnCariKry").on('click',function (argument) {
		$("#tentukanMKTnonMKT").val('');
		var idPeriode=document.getElementById('isiPeriode').value;
		if(idPeriode==''){
			//alert('pilih periode terlebih dahulu');return
		}

		$("#buffer").val('');
		var idTd=$('#tableSetNik tbody tr').length;
       	//alert(nikTd)
		var isiId=''
		for(var j=0;j<idTd;j++){
			//alert(j);
			var id=$('.tdId').eq(j).text();
			isiId+=id+',';
		}
		$("#buffer").val(isiId);

		setfilter();
		$('#tampilkaryawan').children('tbody:first').html("");
		$("#modalTampilKaryawan").modal('show');
	})

	//isi tabel pilih karyawan
	$("#btnCariKaryawanModal").on('click',function (e){
		e.preventDefault();
		var divisi=document.getElementById('txtfilterdiv').value;
		var jabatan=document.getElementById('txtfilterjab').value;
		var bagian=document.getElementById('txtfilterbag').value;
		var txttext=document.getElementById('txttext').value;
		if(document.getElementById('tentukanMKTnonMKT').value==""){
			alert('Tentukan terlebih dahulu Marketing atau Non Marketing');
			$("#tentukanMKTnonMKT").focus();
			return
		}		
		$('#tampilkaryawan').children('tbody:first').html("");

		var url='Palinkperuntukansoals/setKaryawan';
		$.ajax({
			url: url,
			type: "POST",
			data:({divisi:divisi,jabatan:jabatan,bagian:bagian,txttext:txttext}),
			dataType:"text",
			async:false,
			success: function(result){
				 // console.log(result);return
				//result=result.split("^");
			$('#tampilkaryawan').children('tbody:first').html(result);
			return
			if(result[2].trim().length!=0){
					document.getElementById('linkHal1').style.display='';
					document.getElementById('linkHal1').innerHTML=result[2];
				}else{
					document.getElementById('linkHal1').style.display='none';
				}
				// /periodeisi=result;
			}
		})
	})
	
	$('#tableSetNik tbody').on('click', '.btn-del', function(e){
		e.preventDefault();
		$(this).parent().parent().remove(); 
		var table=document.getElementById("tableSetNik")
		for (var i = 1, row; row = table.rows[i]; i++) {
			//alert(row)
			var col=row.cells[0];
			col.innerHTML=i;
		}
		$("#buffer").val('');
		var idTd=$('.tdId').length;
       
		var isiId=''
		for(var j=0;j<idTd;j++){
			//alert(j);
			var id=$('.tdId').eq(j).text();
			isiId+=id+',';
		}
		$("#buffer").val(isiId);

	});

	//end function atau procedur karyawan

	//function atau prosedur yang berhubungan dengan list peruntukan soal 
	//delete link soal
	$("#tableperuntukansoal tbody").on('click','.btnDel',function(e){
		e.preventDefault();
		var idKry=$(this).attr('data-idkry');
		// /alert(idKry);
		var url="Palinkperuntukansoals/deletedata";
		$.ajax({
			url:url,
			type:"POST",
			data:({idKry:idKry}),
			success: function(result){
				//console.log(result);return
				if(result=='sukses'){
					alert('data berhasil dihapus');	
					getData(1);
				}
				//console.log(result)
			}
		})
	})

	//coppy link soal
	$("#tableperuntukansoal tbody").on('click','.btnCopy',function(e){
		setAutocomplateForm();
		var idKry=$(this).attr('data-idkry');
		var kodenik=$(this).attr('data-kodenik');
		var nmkry=$(this).attr('data-nmkry');
		var tgllahir=$(this).attr('data-tgllahir');

		
		//alert(idKry)
		$("#txtKaryawanCopy").text(kodenik+'-'+nmkry);
		$("#karyawanCopy").val(kodenik+'~'+nmkry+'~'+idKry+'~'+tgllahir);
		$("#txtKaryawan").val('');
		$("#nikkaryawan").val('');
		$("#modalCopy").modal('show');
	})
	//simpan copy soal dari list peruntukan soal yang sudah diset
	$("#btnCopySimpan").on('click',function(e){
		var karDataCopyDari=$("#karyawanCopy").val();
		var karTujuan=$("#nikkaryawan").val();
		if(karTujuan==''){
			alert('Copy tujuan soal masih kosong');
			return;
		}
		
		var url='Palinkperuntukansoals/copyData';
		$.ajax({
			url: url,
			type: "POST",
			data:({karDataCopyDari:karDataCopyDari,karTujuan:karTujuan}),
			dataType:"text",
			async:false,
			success: function(result){
				//console.log(result);return
				result=result.split("~");
				if(result[0]=='sukses'){
					if(result[1]!=''){
						alert('Data tujuan copy'+result[1]+' sudah ada');
						getData(1);
						$("#cekSoal").val('')
						$("#panelSoal").html('')
						$("#modalCopy").modal('hide');
					}else{
						alert('Data linksoal berhasil di copy');
						getData(1);
						$("#cekSoal").val('')
						$("#panelSoal").html('')
						$("#modalCopy").modal('hide');
					}
				}				
			}
		})
	})

	// simpan peruntukan soal
	
	$("#btnSimpan").on('click',function(e){
		e.preventDefault();
		var setsoal=$("#cekSoal").val();
		if(setsoal==''){
			alert('soal belum dipilih');return
		}
		var buffer=$("#buffer").val();
		if(buffer==''){
			alert('karyawan belum dipilih');return
		}

		var cekbobot='';
		$(".bobottotal").each(function(){
			var nilaitotalbobot=parseInt($(this).text())
			if(nilaitotalbobot<100){
				alert('nilai bobot total salah satu parameter kurang dari 100 ');
				cekbobot='isi'				
			}
			if(nilaitotalbobot>100){
				alert('nilai bobot total salah satu parameter Lebih dari 100 ');
				cekbobot='isi'
			}
		})
		if(cekbobot=='isi'){
			
			return
		}
		//return
		var data = $("form[name=formlinksoal]").serializeArray();
		var buffNik=$("#buffer").val();
		data.push({name:'buffNik',value:buffNik})

		var url="Palinkperuntukansoals/simpan";
		$.ajax({
			url:url,
			type:"POST",
			data:data,
			success: function(result){
				//console.log(result);return
				alert('data berhasil disimpan');
				getData(1);
				$("#cekSoal").val('')
				$("#panelSoal").html('')
				$("#panelCariKaryawan").hide();
				//console.log(result)
			}
		})
		//alert($("#buffer").val())
	})
	


	$("#modalDetail").on('click','.btnSimpanEdit',function(e){
		e.preventDefault();
		var cekbobot='';
		$(".bobotedit").each(function(){
			var kategori=$(this).attr('data-kategori');
			//alert(kategori);
			var nilaitotalbobot=parseInt($(this).val())
			if(nilaitotalbobot<100){
				alert('nilai bobot total dari '+kategori+' kurang (<) dari 100 ');
				cekbobot='isi'				
			}
			if(nilaitotalbobot>100){
				alert('nilai bobot total dari '+kategori+' Lebih (>) dari 100 ');
				cekbobot='isi'
			}
		})
		if(cekbobot=='isi'){
			
			return
		}

		var data = $("form[name=formEdit]").serializeArray();
		var url="Palinkperuntukansoals/simpanEdit";
		$.ajax({
			url:url,
			type:"POST",
			data:data,
			success: function(result){
				//console.log(result);return
				if(result=='sukses'){
					alert('data berhasil diubah');
					getData(1);
				}
				$('#modalDetail').modal('hide');
				//console.log(result)
			}
		})
	})

	// funtion atau prosedur yang berhubungan dengan setting soal
	$("#btnSetSoal").on('click',function(e){
		e.preventDefault();
		
		var mktNonMkt=document.getElementById('mktNonMkt').value;
		if(mktNonMkt==''){
			alert('Tentukan karyawan terlebih dahulu')
			return
		}
		var idPeriode=document.getElementById('isiPeriode').value;
		if(idPeriode==''){
			//alert('pilih periode');
		}
		var divisisoal=document.getElementById('txtdivisiInput').value;
		if(divisisoal=='0' || divisisoal=='' ){
			alert("pilih divisi peruntukan soal");
			return;
		}
		  
		var jabatanSoal=document.getElementById('txtjabatanInput').value;
		if(jabatanSoal=='0' || jabatanSoal==''){
			alert("pilih jabatan peruntukan soal");
			return;
		}
		setSoal()
	})
	onLoadHandler();
})
// function get divisi dan jabatan soal
function getDivisi(){
	var url = 'pabanksoals/getDivisi';
	var dataCallback;
		$.ajax({
			url: url,
			type: "POST",
			dataType:"text",
			data:({}),
			async:false,
			success: function(result){
			//console.log(result);return
			dataCallback=result;
			
		}
  });   
   return dataCallback; 
  }
  
  function setAutocomplateDivisi(event){
	  var kodeDivisi=JSON.parse(getDivisi());
	  if(event=='input'){
		var select="#divisiInput";
		var divisiIsi='';
	  }

	  $(select).html('');
	  var autocomplete=new SelectPure(select,{
			options:kodeDivisi,
			icon: "fa fa-times",
			autocomplete: true,
			//placeholder: false,
			value: divisiIsi,
			//multiple: false,
			onChange:value=>{
			  	if(event=='input'){
					$('#txtdivisiInput').val('');
					$('#txtdivisiInput').val(value);
					$('#txtjabatanInput').val('');
					$("#cekSoal").val('')				
					$("#panelSoal").html("")
					setAutocomplateJabatan('input')
			  	}			  
			}
		})
	}
  
	//jabatan diambil setelah divisi di click
	function getJabatan(divisiId){
	  var url = 'pabanksoals/getJabatan';
	  var dataCallback;
		  $.ajax({
			  url: url,
			  type: "POST",
			  dataType:"text",
			  data:({divisi:divisiId}),
			  async:false,
			  success: function(result){
			  //console.log(result);return
			  dataCallback=result;
			  
		  }
	});   
	 return dataCallback; 
	}
	function setAutocomplateJabatan(event){
	  if(event=='input'){
		var divisisoal=$('#txtdivisiInput').val()
		var divisiId;
		if(divisisoal!='' && divisisoal!='0'){divisiId=divisisoal.split('~')[1];}else{divisiId='0';}
		//alert(divisiId);return
		var jabatanIsi='';
		var select="#jabatanInput";
		
	  } 
	  
	  $(select).html("");
		
		var Jabatan=JSON.parse(getJabatan(divisiId));
		//$("#jabatan").html('');
		var autocomplete=new SelectPure(select,{
			  options:Jabatan,
			  icon: "fa fa-times",
			  autocomplete: true,
			  placeholder: false,
			  value: jabatanIsi,
			  onChange:value=>{
				if(event=='input'){
					$('#txtjabatanInput').val('');
					$('#txtjabatanInput').val(value);  
					$("#cekSoal").val('')				
					$("#panelSoal").html("")
				}
				
			  }
		  })
	  }
  
// end function divisi dan jabatan soal 

//function diluar document
function getData(hal){
    curHal=hal;
    var periode=document.getElementById('isiPeriode').value;
    // if(periode==''){
	// 	$("#setForm").hide();
    // 	$('#tableperuntukansoal').children('tbody:first').html('');
    // 	document.getElementById('linkHal1').style.display='none';
    // 	$(".btnCariKry").prop('disabled', true);
	// 	$(".btnSetSoal").prop('disabled', true);
    // 	$("#panelSetSoal").hide()
	// 	$("#panelCariKaryawan").hide()

    // 	//setSoal()
    // 	$("#buffer").val('');
   	//  	$("#tableSetNik tbody").html('');
	// 	$("#cekSoal").val('')
	// 	$("#panelSoal").html('')
    // 	 return
    // }
    $("#setForm").show()
    // $(".btnCariKry").prop('disabled', false);
	// $(".btnSetSoal").prop('disabled', false);
	$("#panelSetSoal").show()
	//$("#panelCariKaryawan").show()
    $("#buffer").val('');
	$("#cekSoal").val('')
	$("#panelSoal").html('')
   	$("#tableSetNik tbody").html('');
    cariData(periode,hal);
}
function cariData(periode,hal){
	var statusPeriode=$("#statusPeriode").val();
	//alert(statusPeriode)
    var url = 'Palinkperuntukansoals/getData';
	var filter=$("#filter").val();
    //call jQuery AJAX function
    $.ajax({
        url: url,
        type: "POST",
        data: ({filter:filter,periode:periode,hal:hal}),
        dataType: "text",
		async:false,
        success: function(result){
        //console.log(result);return
        result=result.split("^");
            $('#tableperuntukansoal').children('tbody:first').html(result[0]);
            if(result[1].trim().length!=0){
                    document.getElementById('linkHal1').style.display='';
                    document.getElementById('linkHal1').innerHTML=result[1];
            }else{
                    document.getElementById('linkHal1').style.display='none';
            }
			if(statusPeriode!="EDITABLE"){
				$(".btnCariKry").prop('disabled', true);
				$(".btnSetSoal").prop('disabled', true);
				$(".btnDel").prop('disabled',true);
				$(".btnCopy").prop('disabled',true);
				$("#buttonEdit").prop('disabled',true)
				$("#panelSetSoal").hide()
				$("#panelCariKaryawan").hide()
				$("#showHidePeruntukanSoal").hide()
			}else{
				$(".btnDel").prop('disabled',false)
				$(".btnCopy").prop('disabled',false);
				$("#buttonEdit").prop('disabled',false)
				$("#showHidePeruntukanSoal").show()
			}
        }
    }); 
}


function onLoadHandler() {
	var isiFilterPeriode=getPeriode('');
	//alert(isiFilterPeriode)
	isiFilterPeriode=isiFilterPeriode.split('|');
	var statusPeriode=isiFilterPeriode[1]
	if(statusPeriode!='EDITABLE'){
		$(".btnCariKry").prop('disabled', true);
		$(".btnSetSoal").prop('disabled', true);
	}
	$("#statusPeriode").val(statusPeriode)
	setAutocomplateDivisi('input');
	setAutocomplateJabatan('input');
	getData(1);
	

	
	
}
function getPeriode(data){

	var url = 'Palinkperuntukansoals/getPeriode';
	var id=data
	var periodeisi
	$.ajax({
		url: url,
		type: "POST",
		data:({id:id}),
		dataType:"text",
		async:false,
		success: function(result){
		//console.log(result);
			periodeisi=result;
		}
	});	
	return periodeisi;
}

function setSoalTop(){
	//$("#modalTentukansoal").modal('show');
	
}
function setSoal(){
	var idPeriode=document.getElementById('isiPeriode').value;
	var mktNonMkt=document.getElementById('mktNonMkt').value;
	var txtdivisiInput=document.getElementById('txtdivisiInput').value;
	var txtjabatanInput=document.getElementById('txtjabatanInput').value;
	//alert(idPeriode)
	var url='Palinkperuntukansoals/setSoal';
	$("#panelSoal").html('');
	$.ajax({
		url: url,
		type: "POST",
		data:({id:idPeriode,mktNonMkt:mktNonMkt,txtdivisiInput:txtdivisiInput,txtjabatanInput:txtjabatanInput}),
		dataType:"text",
		async:false,
		success: function(result){
			//console.log(result)
			result=result.split('^');
			if(result[1]=='kosong'){
				$("#cekSoal").val('')
			}else{
				$("#cekSoal").val('isi')
			}
			
			$("#panelSoal").html(result[0])
			
			// /periodeisi=result;
		}
    })
}

function setfilter(){
	document.getElementById('txtfilterdiv').innerHTML="";
	document.getElementById('txtfilterbag').innerHTML="";
	document.getElementById('txtfilterjab').innerHTML="";
	
	var url = 'Palinkperuntukansoals/setfilter';
	$.ajax({
		url: url,
		type: "POST",
		dataType:"text",
		data:({}),
		async:false,
		success: function(result){
			//console.log(result);
			result=result.split('~');
			var divisi=result[0];
			var bagian=result[1];
			var jabatan=result[2];
			document.getElementById('txtfilterdiv').innerHTML=divisi
			document.getElementById('txtfilterbag').innerHTML=bagian
			document.getElementById('txtfilterjab').innerHTML=jabatan
			
		}
	})
}

function checkAll(){
	//var numCheck=document.getElementsByClassName('checkid')
	var buffNik = $("#buffer").val();
	if(buffNik==''){
		$('input[name="checkid"]').prop("checked", true);
	}else{
		buffNik=buffNik.substring(0,buffNik.length-1)
		buffNik=buffNik.split(',')
		var numCheck=document.getElementsByClassName('checkid')
		for(var ii=0;ii<numCheck.length;ii++){
			var x=true
			var nik=document.getElementsByName('checkid')[ii].value;
			for(var jj=0;jj<buffNik.length;jj++){
				if(nik==buffNik[jj]){x=false}
			}
			if(x==true){document.getElementsByName('checkid')[ii].checked=true}
		}
	}

}
function uncheckAll (){
	$('input[name="checkid"]').prop("checked", false);
}
function checkthis(val){
	var nikthis=val;
	var buffNik = $("#buffer").val();
	if(buffNik!=''){
		buffNik=buffNik.substring(0,buffNik.length-1)
		buffNik=buffNik.split(',')
		for(var cnik=0;cnik<buffNik.length;cnik++){
			if(nikthis==buffNik[cnik]){
				alert('Data sudah dipilih\nHapus terlebih dahulu data yang sudah dipilih')
				document.getElementById('checkid'+nikthis).checked=false
			}
		}
	}
	
}
function settableSetNik() {
	var numCheck=document.getElementsByClassName('checkid');
	var tentukanMktNonMkt=document.getElementById('tentukanMKTnonMKT').value;
	var mktNonMkt=document.getElementById("mktNonMkt").value
	
	if(tentukanMktNonMkt==''){
		alert("Tentukan Pilihan Marketing / Non Marketing");
		$("#tentukanMKTnonMKT").focus();
		return
	}
	if(tentukanMktNonMkt!=$("#mktNonMkt").val()){
		
		$("#buffer").val('');
		$("#tableSetNik tbody ").html("")
		document.getElementById("mktNonMkt").value=tentukanMktNonMkt
		$("#panelSoal").html("")
	}
	if(tentukanMktNonMkt=='marketing'){}
	document.getElementById('lblmktnonmkt').innerText=tentukanMktNonMkt=='marketing'?'Marketing':'Non Marketing';
	var hasChecked=false;
	var isiId='';
	var buffNik = $("#buffer").val();
	
	var noUrut=$("#tableSetNik tbody tr").length;
	for(var i=0;i<numCheck.length;i++){
		if (document.getElementsByName('checkid')[i].checked) {
			noUrut++;
			var id=document.getElementsByName('checkid')[i].value;
			var nik=$('#tdNik'+id).text();
			var nama=$('#tdNama'+id).text();
			isiId+=id+',';
			hasChecked=true;
			//console.log(nama);return
			$("#tableSetNik tbody").append("<tr><td width='5%'>"+noUrut+"</td><td width='15%' class='tdId' style='display:none;'>"+id+"</td><td width='15%' class='tdNik'>"+nik+"</td><td width='65%'>"+nama+"</td><td><button type='button' class='btn btn-default btn-sm btn-del'><i class='fa fa-trash' aria-hidden='true'></i></button></td></tr>");
		}
	}
	$("#buffer").val(buffNik+isiId);
	//console.log(isiNik)
	if(hasChecked==false){alert('Belum ada yang di pilih');return;}
	$("#panelCariKaryawan").show();
	$("#modalTampilKaryawan").modal('hide');

}

function detail(idkry){
$("#setiddetail").val('')	
$("#setiddetail").val(idkry)

var url = 'Palinkperuntukansoals/detail';
	$.ajax({
		url: url,
		type: "POST",
		dataType:"text",
		data:({idkry:idkry}),
		async:false,
		success: function(result){
			
			//console.log(result);return
			result=result.split('~');
			var nik=result[0];
			var nama=result[1];
			$("#myModalLabelDetail").text('DETAIL SOAL NIK : '+nik+' NAMA : '+nama)
			
			document.getElementById('tampilDetail').innerHTML=result[2];

			var jmlHead=$(".headkategori").length;
			for(var i=1;i<=jmlHead;i++){
		
				var nomor=1;
				$('.nomor'+i).each(function(){
					if($(this).next().find('.pilihedit').is(":checked")){
						$(this).text(nomor);
							nomor++;
					}
					
				 	
				 	//console.log(nomor)
				 
				})

			}
			//alert(jmlHead);
			$("#buttonBatal").hide();
			$("#buttonEdit").show();
			$('#modalDetail').modal('show');
		}
	})


}
function edit(){
	var jmlHead=$(".headkategori").length;
	for(var i=1;i<=jmlHead;i++){
		
		var nomor=1;
		$('.nomor'+i).each(function(){
		 	$(this).text(nomor);
		 	//console.log(nomor)
		 	nomor++;
		})

	}
	//alert(jmlHead);
	$(".btnSimpanEdit").show();
	$(".ceklist").show();
	$(".hideEdit").show();
	$("#buttonBatal").show();
	$("#buttonEdit").hide();
}
function batalEdit(){
var idkry=$("#setiddetail").val()
detail(idkry)
}

function pilih(val,param){
	//param 1 proses tambah, param 2 proses edit
	if(param==1){
		$("#bobottotal"+val).text('')
		var i=1;
		var bobot=0;
		$(".pilih"+val).each(function(){
			if($(this).is(":checked")){
				bobot =parseInt(bobot)+parseInt($(this).next().val())
				i++;
			}
		})
		$("#bobottotal"+val).text(bobot)
	}
	if(param==2){
		$("#bobotedit"+val).val('');
		var i=1;
		var bobot=0;
		$(".pilihedit"+val).each(function(){
			//console.log($(this).val());return
			if($(this).is(":checked")){
				bobot =parseInt(bobot)+parseInt($(this).next().val())
				i++;
				//console.log(bobot);return
			}
		})
		$("#bobotedit"+val).val(bobot)
	}
}

function filterName(argument,indexkolom) {
	//console.log(argument);
    var filter = argument.toUpperCase();
    var rows = document.querySelector("#tampilkaryawan tbody").rows;
    
    for (var i = 0; i < rows.length; i++) {
        var Col = rows[i].cells[indexkolom].textContent.toUpperCase();
        var secondCol = rows[i].cells[1].textContent.toUpperCase();
        if (Col.indexOf(filter) > -1) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }      
    }
}

function getDtKaryawan(){
	
    var url = 'Palinkperuntukansoals/getDtKaryawan';
    var dataCallback;
        $.ajax({
            url: url,
            type: "POST",
            dataType:"text",
            async:false,
            success: function(result){
            //console.log(result);
            dataCallback=result;
            jsonVal=JSON.parse(result);
            //console.log(jsonVal);return
        }
  });	
   return dataCallback; 
}

function setAutocomplateForm(val){
    var arrkar=[];
    var isiVal=val;
    //var isiValKry=$("#nikkaryawan").val();
    var getData=JSON.parse(getDtKaryawan());

    var datakaryawan = getData;
    $("#txtKaryawan").html('');
   
    var karyawan = new SelectPure("#txtKaryawan",{
        options:datakaryawan,
        value:arrkar,
        //placeholder: "-Please select-",
        icon: "fa fa-times",
        multiple: true,
        autocomplete: true,
        onChange:function(value){
            //console.log(value);
            $('#nikkaryawan').val('');
            $('#nikkaryawan').val(value);
            
        },
    })

    
}
