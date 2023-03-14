<?php
$this->layout='popup';
echo $this->Html->script('h1popuppermintaan.js');
?>
<script type='text/javascript'>
let obj_caller =parent.opener;
</script>

<style type="text/css">
body{
	padding-left:10px;
	}
.tb { width:950px; font-family:Tahoma, Arial, Helvetica, sans-serif; font-size:14px; }
.tr { width:950px; float:left; }

.item1 { grid-area: header;}
	.item2 { grid-area: main; 
		display: flex;
		flex-direction: column-reverse;
		align-items: center;
  		justify-content: center;}
	.item3 { grid-area: footer; }
	.grid-container{
		display: grid;
		grid-template-areas:
		'header'
		'main'
		'footer';
		grid-gap: 10px;
		grid-template-columns: 400px;
		background-color: #80ced6;
		padding: 10px;
	}
	.grid-container > div {
		background-color: rgba(255, 255, 255, 0.8);
		text-align: center;
		padding: 20px 0;
	}
	.button1 {background-color: white; color: black; border: 1px solid #008CBA;padding: 10px 20px;text-align: center;text-decoration: none;display: inline-block;font-size: 12px;margin: 4px 2px;transition-duration: 0.2s;	border-radius: 5px;	cursor: pointer;}
	.button1:hover {background-color: #008CBA;color: white;}
	#tblDetil {font-family: sans-serif;color: #444;border-collapse: collapse; border: 1px solid #f2f5f7;}
	#tblDetil tr th{background: #35A9DB;color: #fff; font-weight: normal;}
	#tblDetil, th, td { padding: 8px 20px;}
	#tblDetil tr:hover { background-color: #f5f5f5;}
	#tblDetil tr:nth-child(even) {background-color: #f2f2f2;}
</style>
<style type="text/css">
div { font-size: 11px; }
#loading {color: white; background-color: red; padding: 5px 10px; font: 11px sans-serif; width:180px }
</style>

<form name="h1form" method="post">
	<div id="update" align="center" class="grid-container">
		<div class="item1">
			<h1>Cari Permintaan</h1>
			<hr>
			<!-- <label id="Data"></label> -->
			<input type='hidden' id='divId' value="<?php echo $this->Session->read('dpfdpl_divisiId');?>">
			<table width="100%" id="tblData">
				<tr>	
					<td width="80%" align="center">
						<input type="checkbox" id="filterByNama" onchange="getData('1')" checked="checked" value="Filter By Nama" style='display: none'>Filter By Nama
						<input type="text" id="txtNama" name="txtNama" class="roundIt">&nbsp;
						<input type="button" id="cariNama" class="tomKcl" value="Cari" onClick="getData('1')">
						
					</td>
				</tr>
				
			</table>
		</div>
		<div id="tabelUser" class="item2">
			<table width="100%">
				<tr>
					<td><div id="linkHal" style="display:none" ></div></td>
				</tr>
			</table>
			<table id="tblDetil" style="width:90%" >
				<thead></thead>
				<tbody></tbody>
			</table>
		</div>
		<textarea name="buffer_1" cols=50 rows=10 class="textBuff"></textarea>
	</div>
</form>

<br>
<div align="center"><label id="test"></label><br>
</div>
<script>
 $(function() {
	$(document).ajaxStart(function(){ 
		$("#loading").fadeIn();
		//$("#Data").html('Proses Data Sales Sedang Berjalan<br><strong>Silahkan Tunggu</strong><br>&nbsp;');
		//$("#tblData").css('display','none');
	 });
	$(document).ajaxStop(function(){ 
		$("#loading").fadeOut();
		//$("#Data").html('');
		//$("#tblData").css('display','block'); 
		});
});
	function addToData(data){
		obj_caller.document.getElementById('namaNikJabatanUserRequest').innerHTML=document.getElementById('txtUserRequest'+data).innerHTML+'#'+document.getElementById('txtNik'+data).innerHTML+'#'+document.getElementById('txtJabatan'+data).innerHTML
		obj_caller.document.getElementById('txtnikUserRequest').value=document.getElementById('txtNik'+data).innerHTML
		obj_caller.document.getElementById('txtnamaUserRequest').value=document.getElementById('txtUserRequest'+data).innerHTML
		obj_caller.document.getElementById('txtJabatanIdUserRequest').value=document.getElementById('txtJabatanId'+data).innerHTML
		obj_caller.document.getElementById('txtnamaJabatanUserRequest').value=document.getElementById('txtJabatan'+data).innerHTML
		obj_caller.document.getElementById('divisiUserRequest').innerHTML=document.getElementById('txtDivisi'+data).innerHTML
		obj_caller.document.getElementById('txtDivisiUserRequest').value=document.getElementById('txtDivisi'+data).innerHTML
		obj_caller.document.getElementById('groupKaryawanUserRequest').innerHTML=document.getElementById('txtGroupKaryawan'+data).innerHTML
		obj_caller.document.getElementById('txtGroupKaryawanUserRequest').value=document.getElementById('txtGroupKaryawan'+data).innerHTML
		obj_caller.document.getElementById('jenisPermintaan').innerHTML=document.getElementById('txtJenisPermintaan'+data).innerHTML
		obj_caller.document.getElementById('txtJenisPermintaan').value=document.getElementById('txtJenisPermintaan'+data).innerHTML
		obj_caller.document.getElementById('NoTransPermintaan').innerHTML=document.getElementById('txtNoTrans'+data).innerHTML
		obj_caller.document.getElementById('txtNoTransPermintaan').value=document.getElementById('txtNoTrans'+data).innerHTML
		//isi table 
		//data2=document.getElementById('txtMasterBarang'+data).innerHTML
		//var jum = obj_caller.$("#tableBarang>tbody>tr").closest('tbody').length;
		//alert(jum)
		var url='popuppermintaans/getDataIsi';
		$.ajax({
			 url: url,
			 type: "POST",
			 data: ({noTrans:data}),
			 success:function(result){
			 	var no = 0;
			 	//alert(result)
				//$("#purchase").html(result);
				//console.log(JSON.parse(result));
				$.each(JSON.parse(result), function(index, eachRow ) {
					var count = eachRow.length;
					
					idBarang=eachRow['fpb']["masterBarangId"];
					idrow=eachRow['fpb']["id"];
					
					no++;

					obj_caller.$("#tblDetil").append("<tr class='tableBarangItem' id='tb"+idBarang+"'><td width='3%' style='text-align:center';><a href='#'>+</a></td><td width='25%'><input type='hidden' name='txtPermintaanId[]' id='txtPermintaanId"+idBarang+"' value='"+eachRow['fpb']["permintaanId"]+"'/><input type='hidden' name='txtMasterBarang[]' id='txtMasterBarang"+idBarang+"' value='"+idBarang+"'/><div class='tooltip'><label id='namaItem"+idBarang+"'>"+eachRow['fpb']["namaBarang"]+"</label><span class='tooltiptext'>Stok saat ini : "+eachRow['fpb']["stok"]+" </span></div><input type='hidden' name='txtNamaItem[]' id='txtNamaItem"+idBarang+"' value='"+eachRow['fpb']["namaBarang"]+"'></td><td width='5%' style='text-align:center;'><label id='mataUangHarga"+idBarang+"'>"+eachRow['fpb']["mataUang"]+"</label></td><td td width='5%' style='text-align:right;'> <label id='harga"+idBarang+"'>"+eachRow['fpb']["harga"]+"</label> <input type='hidden' name='txtHarga[]' id='txtHarga"+idBarang+"' value='"+eachRow['fpb']["harga"]+"'></td><td width='5%' style='text-align:center;'><label id='jumlah"+idBarang+"'>"+eachRow['fpb']["qtyVerifikasi"]+"</label><input type='hidden' name='txtJumlah[]' id='txtJumlah"+idBarang+"' value='"+eachRow['fpb']["qtyVerifikasi"]+"'></td><td width='10%'  style='text-align:right;'><label id='total"+idBarang+"'>"+eachRow['fpb']["totalDisetujui"]+"</label><input type='hidden' name='txtTotal[]' id='txtTotal"+idBarang+"' value='"+eachRow['fpb']["totalDisetujui"]+"'><input type='hidden' name='txtMataUang1[]' id='mataUang1"+idBarang+"' value='"+eachRow['fpb']["mataUang"]+"'></td><td width='25%' align='left'><label id='KetSpek"+idBarang+"'>"+eachRow['fpb']["spesifikasi"]+"</label><input type='hidden' name='txtKetSpek[]' id='txtKetSpek"+idBarang+"' value='"+eachRow['fpb']["spesifikasi"]+"'></td><td style='text-align:center;' width='24%' id='"+idBarang+"'><input type='hidden' name='txtindexItem' id='indexItem"+idBarang+"' value='"+idBarang+"'/><input type='button' name='hapusItem' value='- hapus' onClick='dellTblData(this)' class='button button1'><input type='button' name='Submit3' value='+ Penawaran' onClick='getSupplier(this,"+idrow+")' class='button button2'/><input type='checkbox' name='cek' value='"+idBarang+"' style='display:none'/></td></tr><tr><td colspan='8'><div id='tabelUser"+idBarang+"' style='width:100%'><table id='tblDetil"+idBarang+"' class='tblSup'><thead><tr><td width='8%' style=\"text-align:center;display:none;\">supid</td><td width='28%' style=\"text-align:center;\">nama supplier</td><td width='10%' style=\"text-align:center;\">mata uang</td><td width=' 12%' style=\"text-align:center;\">harga penawaran</td><td width='34%' style=\"text-align:center;\">keterangan</td><td width='8%' style=\"text-align:center;\">hapus</td></tr></thead><tbody id='body"+idBarang+"'></tbody></table></div></td></tr>");	
					obj_caller.$(".tableBarangItem").closest('tr').nextUntil(".tableBarangItem").hide();	
					parent.window.close();
				});
			 // 	alert(result);
			 // console.log(result)
			 }
		})
		
		// obj_caller.$("#tblDetil").append("<tr class='tableBarangItem' id='tb"+data2+"'><td width='3%' style='text-align:center';><a href='#'>+</a></td><td width='25%'><input type='hidden' name='txtMasterBarang[]' id='txtMasterBarang"+data2+"' value='"+data2+"'/><label id='namaItem"+data2+"'>"+document.getElementById('txtNmBarang'+data).innerHTML+"</label><input type='hidden' name='txtNamaItem[]' id='txtNamaItem"+data2+"' value='"+document.getElementById('txtNmBarang'+data).innerHTML+"'></td><td width='8%' style='text-align:right;'><label id='harga"+data2+"'>"+document.getElementById('txtHarga'+data).innerHTML+"</label><input type='hidden' name='txtHarga[]' id='txtHarga"+data2+"' value='"+document.getElementById('txtHarga'+data).innerHTML+"'></td><td width='5%' style='text-align:center;'><label id='jumlah"+data2+"'>"+document.getElementById('txtJumlah'+data).innerHTML+"</label><input type='hidden' name='txtJumlah[]' id='txtJumlah"+data2+"' value='"+document.getElementById('txtJumlah'+data).innerHTML+"'></td><td width='10%'  style='text-align:right;'><label id='total"+data2+"'>"+document.getElementById('txtTotalAcc'+data).innerHTML+"</label><label id='mataUang"+data2+"'>"+document.getElementById('txtMatauang'+data).innerHTML+"</label><input type='hidden' name='txtTotal[]' id='txtTotal"+data2+"' value='"+document.getElementById('txtTotalAcc'+data).innerHTML+"'><input type='hidden' name='txtMataUang1[]' id='mataUang1"+data2+"' value='"+document.getElementById('txtMatauang'+data).innerHTML+"'></td><td width='25%' align='left'><label id='KetSpek"+data2+"'>"+document.getElementById('txtSpesifikasi'+data).innerHTML+"</label><input type='hidden' name='txtKetSpek[]' id='txtKetSpek"+data2+"' value='"+document.getElementById('txtSpesifikasi'+data).innerHTML+"'></td><td style='text-align:center;' width='24%' id='"+data2+"'><input type='hidden' name='txtindexItem' id='indexItem'"+data2+" value='"+data2+"'/><input type='button' name='hapusItem' value='- hapus' onClick='dellTblData(this)' class='button button1'><input type='button' name='Submit3' value='+ Penawaran' onClick='getSupplier(this)' class='button button2'/><input type='checkbox' name='cek' value='"+data2+"' style='display:none'/></td></tr><tr><td colspan='7'><div id='tabelUser"+data2+"' style='width:100%'><table id='tblDetil"+data2+"' class='roundIt' style='width:97%;margin:1%;'><thead><tr><td width='8%'>supid</td><td width='28%'>nama supplier</td><td width=' 12%'>Penawaran</td><td width='10%'>mata uang</td><td width='34%'>keterangan</td><td width='8%' style=\"text-align:center;\">hapus</td></tr></thead><tbody id='body"+data2+"'></tbody></table></div></td></tr>");

		
		obj_caller.document.getElementById('tablePermintaan').style.display = "block" 
		obj_caller.document.getElementById('cariRequest').style.display = "none" 
		obj_caller.document.getElementById('manualPenawaran').style.display = "none" 
		obj_caller.document.getElementById('clearInputan').style.display = "block" 
		obj_caller.document.getElementById('Submit').style.display = "block" 
		obj_caller.document.getElementById('kolomBarang').style.display = "block" 
		

	}
</script>