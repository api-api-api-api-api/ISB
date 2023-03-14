var serial=0;
var curHal=1;
$(document).ready(function (val) {
	$("#detailSoal").hide();
	onloadHandler();
	$("#tblkaryawan tbody").on('click','.tab',function() {
		$("#tblkaryawan tbody tr").removeClass("ativetab");
		var selected = $(this).addClass("ativetab");
		if(!selected)
			$(this).addClass("ativetab");
		var idkry=$(this).find("input[name=tdidkry]").val();
		var nikkry=$(this).find("input[name=tdnikkry]").val();
		var namakry=$(this).find("input[name=tdnamakry]").val();
		var tgllahirkry=$(this).find("input[name=tdtgllahirkry]").val();
		//alert(nik);return
		setSoal(idkry,nikkry,namakry,tgllahirkry);
	});


	$("#form1").on('submit',function(e){
		
	})
	$("#btnsimpan").on('click',function(e){
		
	})


})
function tambahSoal(atr){
	var katid=$(atr).attr('data-katid');
	var kategoriLabel=$(atr).attr('data-kategoriLabel');
	var bobotTable=$(atr).attr('data-bobotTable')
	var trdivKatid=document.getElementsByClassName('trdiv'+katid).length;
	
	var textRoundIt=document.getElementsByClassName('textroundIt').length;
	for(var i=0;i<textRoundIt;i++){
		if(document.getElementsByClassName('textroundIt')[i].value==''){
			alert('harap isi pertanyaan')
			$(".textroundIt")[i].focus();
			return
		}
	}
	var textRoundIt=document.getElementsByClassName('roundIt').length;
	for(var i=0;i<textRoundIt;i++){
		if(document.getElementsByClassName('roundIt')[i].value=='0'){
			alert('harap isi bobot pertanyaan terlebih dahulu')
			$(".roundIt")[i].focus();
			return
		}
	}
	
	var cekRoundIt=document.getElementsByClassName('roundIt'+katid);
	let num=Number(0);
	for(var i=0;i<cekRoundIt.length;i++){
		let val=cekRoundIt[i].value;
		num=num+Number(val);
	}
	if(num==100){
		alert('Jumlah Total Bobot '+kategoriLabel+' \nsudah terpenuhi...');
		return
	}
	//alert(trdivKatid)
	var no=Number(trdivKatid)+1
	var idSoal='T'+no
	$('.trdiv'+katid).last().after(newFunction(katid, no, idSoal, kategoriLabel, bobotTable));
	//
	
}

function newFunction(katid, no, idSoal, kategoriLabel, bobotTable) {
	return `<div class='col-md-12 trdiv trdiv${katid}' style='border-bottom:1px solid #ddd;'><div class='row'><div class='col-md-7'><div class='row'><div class='col-md-1 tdisi column1'>${no}</div><div class='tdisi column2' style='display:none'><input type='text' name='idSoal[]' id='idSoal${idSoal}' value='${idSoal}'/></div><div class='soal col-md-10 tdisi column3'><textarea class='form-control textroundIt' type='text' name='nmsoal${idSoal}' id='nmSoal${idSoal}' ></textarea></div><div class='bobot col-md-1 tdisi column4'><input type='text' name='bobotVal${idSoal}' id='bobotVal${idSoal}' value='0' class='roundIt${katid} roundIt' onKeyUp='upAngka(this),cekTotalBobot(this,${katid});' maxlength='3'></div></div></div><div class='col-md-5'><div class='row'><div class='col-md-1-5 col-xs-2'><label class='LabelPoin'>5</label><input type='radio' name='pilihTp${idSoal}' id='pilihTp${idSoal}' value='5' onclick='tes(this.value,"${idSoal}",${katid})' class='radio form-control aktif${katid}' disabled></div><div class='col-md-1-5 col-xs-2 '><label class='LabelPoin'>4</label><input type='radio' name='pilihTp${idSoal}' id='pilihTp${idSoal}' value='4' onclick='tes(this.value,"${idSoal}",${katid})' class='radio form-control aktif${katid}' disabled></div><div class='col-md-1-5 col-xs-2'><label class='LabelPoin'>3</label><input type='radio'  name='pilihTp${idSoal}' id='pilihTp${idSoal}' value='3' onclick='tes(this.value,"${idSoal}",${katid})' class='radio form-control aktif${katid}' disabled></div><div class='col-md-1-5 col-xs-2'><label class='LabelPoin'>2</label><input type='radio'  name='pilihTp${idSoal}' id='pilihTp${idSoal}' value='2' onclick='tes(this.value,"${idSoal}",${katid})' class='radio form-control aktif${katid}' disabled></div><div class='col-md-1-5 col-xs-2'><label class='LabelPoin'>1</label><input type='radio' name='pilihTp${idSoal}' id='pilihTp${idSoal}' value='1'  onclick='tes(this.value,"${idSoal}",${katid})' class='radio form-control aktif${katid}' disabled></div><div class='col-md-1-5 col-xs-2'><label class='LabelPoin'>Jml Nilai</label><p  id='jmlNilai${idSoal}' class='lpoin${katid}' style='margin:unset;font-size: large;font-weight: 700;'></p></div><div class='col-xs-2 tp' style='display:none;'><input type='text' name='valueTp${idSoal}' id='valueTp${idSoal}'></div><div class='col-xs-2 tp' style='display:none;'><input type='text' name='kategori${idSoal}' id='kategoriTp${idSoal}' value='${kategoriLabel}'></div><div class='col-xs-2 tp' style='display:none;'><input type='text' name='bobotKategori${idSoal}' id='bobotKategoriTp${idSoal}' value='${bobotTable}'></div></div></div></div></div>`;
}

function tes(val,id,katId){
	//alert(val)
	document.getElementById('valueTp'+id).value="";
	document.getElementById('valueTp'+id).value=val;
	var bobot=document.getElementById("bobotVal"+id).value
	var jumNilai=parseFloat(bobot) * parseFloat(val);
	document.getElementById('jmlNilai'+id).innerText=jumNilai

	//mencari total jumlah by katid

	document.getElementById('totalJumNilai'+katId).innerText='';
	$("input[name=valtotalJumNilai"+katId+"]").val('')
	var jmllpoinPerkatId=document.getElementsByClassName('lpoin'+katId).length;
	var jmlTotalNilaiPerKategori=0;
	for(var i=0;i<jmllpoinPerkatId;i++){
		var nilai=document.getElementsByClassName('lpoin'+katId)[i].innerText;
		jmlTotalNilaiPerKategori=Number(jmlTotalNilaiPerKategori)+Number(nilai)
	}
	document.getElementById('totalJumNilai'+katId).innerText=jmlTotalNilaiPerKategori
	$("input[name=valtotalJumNilai"+katId+"]").val(jmlTotalNilaiPerKategori)

	var bobothitungperkategori=$('#bobotHitung'+katId).val();
	var skorAkhirPerKategori=Number(jmlTotalNilaiPerKategori)*0.2*Number(bobothitungperkategori)
	$("#hasilNilai"+katId).val('')
	$("#hasilNilai"+katId).val(skorAkhirPerKategori)

	$("#nilaiKeseluruhan").text('');
	var skorakhir=0
	var jmlClasshasilNilai=document.getElementsByClassName('hasilNilai').length;
	for(var j=0;j<jmlClasshasilNilai;j++){
		skorakhir=Number(skorakhir)+Number(document.getElementsByClassName('hasilNilai')[j].value)
	}
	//alert(jmlClasshasilNilai)
	$("#nilaiKeseluruhan").text(Math.floor(skorakhir));
	//alert(jmlTotalNilaiPerKategori)

	
}
function pilih(val,id){
	//alert(id)
	document.getElementById('soalUraian'+id).value="";
	document.getElementById('soalUraian'+id).value=val;
}
function simpan(){
	var clsTotalBobot = document.getElementsByClassName('clsTotalBobot');
	for(var i=0;i<clsTotalBobot.length;i++){
		if(Number(clsTotalBobot[i].innerText)<100){
			var nextSibling = clsTotalBobot[i].nextElementSibling.innerText;
			alert('Total Bobot untuk kategori "'+nextSibling+'"\nkurang dari 100 !!!');
			return
		}
		
		//console.log(nextSibling);
	}
	//return

	var soal = document.getElementsByName("idSoal[]");
	var jmlClassPanel = document.getElementsByClassName("panelCheck").length;
	if(jmlClassPanel>2){
		var jumSoalUraian=document.getElementsByClassName("idSoalUraian").length;
		for(var i=0;i<jumSoalUraian;i++){
			var idSoalUraian=document.getElementsByClassName('idSoalUraian')[i].value;
			var txtSoalUraianValue=document.getElementById('soalUraian'+idSoalUraian).value
			if(txtSoalUraianValue==''){
				alert("Isian belum lengkap,\nCek kembali Checklish maupun kolom isian anda");
				$("#soalUraian"+idSoalUraian).focus()
				return
			}
		}
	}

	//alert(soal.length);return
		for(var i=0;i<soal.length;i++){
			var id=soal[i].value;
			var valueTp=document.getElementById('valueTp'+id).value
			if(valueTp==""){
				alert("ceklish masih ada yang kosong");return
			}

		}

		var jmlSoalTambah=document.getElementsByClassName('textroundIt').length
		if(jmlSoalTambah>0){
			for(var j=0; j<jmlSoalTambah;j++){
				if($(".textroundIt").eq(j).val()==''){
					alert('Soal masih ada yang kosong')
					$(".textroundIt").eq(j).focus();
					return
				}

			}
		}
		//console.log(jmlSoalTambah);return
		
		
		var data=$("#form1").serializeArray();
		var url = 'paforms/crud';
		$.ajax({
			url: url,
			type: "POST",
			data: data,
			dataType: "text",
			success: function(result){
				//console.log(result);return;
				if(result=='sukses'){
					alert('Data penilaian berhasil disimpan.');
					var idkry=$("#idkry").val();
					var nikkry=$("#nikkry").val();
					var namakry=$("#namakry").val();
					var tgllahirkry=$("#tgllahirkry").val()
					//onloadHandler();
					//setSoal(idkry);
					setSoal(idkry,nikkry,namakry,tgllahirkry)
				}
				
			}
		})
}
function onloadHandler() {
	getData(1)
}
function getData(hal){
	curHal=hal;
	cariData(hal);
}
function cariData(hal){
	var url = 'paforms/getData';

	$.ajax({
		url: url,
		type: "POST",
		data: ({hal:hal}),
		dataType: "text",
		success: function(result){
			if(result=='close'){
				document.getElementById('txtPeriode').innerHTML ='Periode penilaian tahun ini belum dibuka';
				return
			}
			//console.log(result);
			result=result.split("^");
			$('#tblkaryawan').children('thead:first').html(result[0]);
			$('#tblkaryawan').children('tbody:first').html(result[1]);
			if(result[2].trim().length!=0){
				document.getElementById('linkHal').style.display='';
				document.getElementById('linkHal').innerHTML=result[2];
			}else{
				document.getElementById('linkHal').style.display='none';
			}
			document.getElementById('txtPeriode').innerHTML =result[3];
			document.getElementById('periode').value=result[4];
			document.getElementById('nikuser').value=result[5];
			document.getElementById('namauser').value=result[6];
			document.getElementById('iduser').value=result[7];
			document.getElementById('tgllahiruser').value=result[8];
		}
	})
}

function getPeriode(){
	var url = 'paforms/getData';
	$.ajax({
		url: url,
		type: "POST",
		data: ({hal:hal}),
		dataType: "text",
		success: function(result){

		}
	})
}
function setSoal(idkry,nikkry,namakry,tgllahirkry){
	// console.log(idkry)
	// console.log(nikkry)
	// console.log(namakry)
	// console.log(tgllahirkry);return
	var url="paforms/setsoal";
	var periode=$("#periode").val();
	$("#txtNik").text('');
	$("#txtNama").text('');
	$("#txtTglMsk").text('');
	$("#txtJabatan").text('');
	$("#txtStatus").text('');
	$('#formPenilaian').html('');
	$("#nikkry").val('');
	$("#namakry").val('');
	$("#tgllahirkry").val('')
	$.ajax({
		url: url,
		type: "POST",
		data: ({periode:periode,idkry:idkry,namakry:namakry,tgllahirkry:tgllahirkry}),
		dataType: "text",
		success: function(result){
			//console.log(result);return
			if(result==''){
				alert('data masih kosong');
				return
			}
			result = result.split('^');
			var datakaryawan=result[0].split('~');
				$("#txtNik").text(datakaryawan[1]);
				$("#txtNama").text(datakaryawan[2]);
				$("#txtTglMsk").text(datakaryawan[3]);
				$("#txtJabatan").text(datakaryawan[4]);
				$("#txtStatus").text('');
				$('#formPenilaian').html(result[1]);
				$("#idkry").val(datakaryawan[0]);
				$("#nikkry").val(datakaryawan[1]);
				$("#namakry").val(datakaryawan[2]);
				$("#tgllahirkry").val(tgllahirkry)
				$("#detailSoal").show();
		}
	})
}


function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
    return true;
}

function colorin(x) {
    x.style.color = "#00516f";
}

function normalcolor(x) {
    x.style.color = "#66A594";
}

function upAngka(str){
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
		str.value="0"
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
function cekTotalBobot(str,katId){
	//alert(katId)
	var cekRoundIt=document.getElementsByClassName('roundIt'+katId);
	let num=Number(0);
	for(var i=0;i<cekRoundIt.length;i++){
		let val=cekRoundIt[i].value;
		num=num+Number(val);
	}
	$("#totalBobot"+katId).text(num);
	if(num>100){
		alert('Total bobot tidak boleh lebih dari 100');
		$("#totalBobot"+katId).text(num-str);
		str.value="0";
		let num2=Number(0);
		for(var i=0;i<cekRoundIt.length;i++){
			let val=cekRoundIt[i].value;
			num2=num2+Number(val);
		}
		$("#totalBobot"+katId).text(num2);
		return 
	}
	if(num==100){
		var stat=false
		for(var i=0;i<cekRoundIt.length;i++){
			if(cekRoundIt[i].value=='0'){
				alert('Masih ada bobot nilai yang belum di isi, total semua bobot per kategori harus 100');
				str.value="0"
				let num2=Number(0);
				for(var i=0;i<cekRoundIt.length;i++){
					let val=cekRoundIt[i].value;
					num2=num2+Number(val);
				}
				$("#totalBobot"+katId).text(num2);

				return ;
			}else{
				stat=true;
			}
		}
		if(stat==true){
			console.log(stat)
			$(".roundIt").prop('readonly','true')
			$(".aktif"+katId).prop('disabled',false)
		}
	}
	$("#totalBobot"+katId).text(num);
	//console.log(num)
}