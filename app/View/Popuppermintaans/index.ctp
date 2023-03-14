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
</style>
<style type="text/css">
div { font-size: 11px; }
#loading {color: white; background-color: red; padding: 5px 10px; font: 11px sans-serif; width:180px }
</style>
<div id="update" align="center">
	<form name="h1form" method="post">
			<legend style="margin-left:15px;">Cari Permintaan</legend>
			<label id="Data"></label>
			<input type='hidden' id='divId' value="<?php echo $this->Session->read('dpfdpl_divisiId');?>">
			<table width="100%" id="tblData">
				<tr>
					<td colspan="4">
					<!-- <input type="checkbox" id="filterByDM" onchange="getData('1')" checked="checked" value="Filter By Sales">Filter By DM -->
					</td>
				</tr>
				<tr>
					<td width="27%"></td>
					<td width="1%"></td> 
					<td width="61%">
						<input type="hidden" id="txtOutlet" name="txtOutlet" class="roundIt">&nbsp;
						<!-- <input type="button" id="cariOutlet" class="tomKcl" value="Cari" onClick="getData('1')"> -->
					</td>
					<td width="11%" align="left"></td>
				</tr>
				<tr>
					<td colspan="3"></td><td></td>
				</tr>
			</table>
		<div id="tabelUser">
			<table width="100%">
				<tr>
					<td><div id="linkHal" style="height:18px; font-weight:bold;display:none"></div></td>
				</tr>
			</table>
			<table id="tblDetil" style="width:90%" >
				<thead></thead>
				<tbody></tbody>
			</table>
		</div>
		<textarea name="buffer_1" cols=50 rows=10 class="textBuff"></textarea>
	</form>
</div>
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
		obj_caller.document.getElementById('txtPermintaanId').value=document.getElementById('id'+data).innerHTML
		obj_caller.document.getElementById('namaUserRequest').innerHTML=document.getElementById('txtUser'+data).innerHTML
		obj_caller.document.getElementById('txtnamaUserRequest').value=document.getElementById('txtUser'+data).innerHTML
		obj_caller.document.getElementById('NoTransPermintaan').innerHTML=document.getElementById('txtNoTrans'+data).innerHTML
		obj_caller.document.getElementById('txtNoTransPermintaan').value=document.getElementById('txtNoTrans'+data).innerHTML
		obj_caller.document.getElementById('jenisPermintaan').innerHTML=document.getElementById('txtJenPer'+data).innerHTML
		obj_caller.document.getElementById('txtJenisPermintaan').value=document.getElementById('txtJenPer'+data).innerHTML
		//isi table 
		data2=document.getElementById('txtMasterBarang'+data).innerHTML
		//var jum = obj_caller.$("#tableBarang>tbody>tr").closest('tbody').length;
		//alert(jum)

		obj_caller.$("#tableBarang").append("<tr class='tableBarangItem'><td><table><tr><td width='10%'>Nama Barang</td><td width='1%'>:</td><td width='23%'><input type='hidden' name='txtMasterBarang[]' id='txtMasterBarang"+data2+"' value='"+data2+"'/><label id='namaItem"+data2+"'>"+document.getElementById('txtNmBarang'+data).innerHTML+"</label><input type='hidden' name='txtNamaItem[]' id='txtNamaItem"+data2+"' value='"+document.getElementById('txtNmBarang'+data).innerHTML+"'></td><td width='6%'>Harga</td><td width='1%'>:</td><td width='8%'><label id='harga"+data2+"'>"+document.getElementById('txtHarga'+data).innerHTML+"</label><input type='hidden' name='txtHarga[]' id='txtHarga"+data2+"' value='"+document.getElementById('txtHarga'+data).innerHTML+"'></td><td width='7%'>Jumlah</td><td width='1%'>:</td><td width='5%'><label id='jumlah"+data2+"'>"+document.getElementById('txtJumlah'+data).innerHTML+"</label><input type='hidden' name='txtJumlah[]' id='txtJumlah"+data2+"' value='"+document.getElementById('txtJumlah'+data).innerHTML+"'></td><td width='6%'>Total</td><td width='1%'>:</td><td width='13%'><label id='total"+data2+"'>"+document.getElementById('txtTotal'+data).innerHTML+"</label><input type='hidden' name='txtTotal[]' id='txtTotal"+data2+"' value='"+document.getElementById('txtTotal'+data).innerHTML+"'></td><td width='10%' align='right'><input type='hidden' name='txtindexItem' id='indexItem'"+data2+" value='"+data2+"'/><input type='button' name='hapusItem' value='- hapus' onClick='dellTblData(this)'></td><td width='10%' id='"+data2+"'><input type='button' name='Submit3' value='+ Penawaran' onClick='getSupplier(this)'/><input type='checkbox' name='cek' value='"+data2+"' style='display:none' /></td></tr><tr><td colspan='14'><fieldset class='roundIt'><div id='tabelUser'"+data2+" style='width:100%'><table width='100%'><tr><td><div id='linkHal' style=\"height:18px; font-weight:bold; alignment-adjust:middle; display:none\" ></div></td></tr></table><table id='tblDetil' style='width:100%'><thead><tr><td width='7%' style=\"text-align:center;\">supid</td><td width='25%' style=\"text-align:center;\">nama supplier</td><td width='8%' style=\"text-align:center;\">harga @</td><td width='5%' style=\"text-align:center;\">qty</td><td width='12%' style=\"text-align:center;\">total</td><td width='8%' style=\"text-align:center;\">mata uang</td><td width='27%' style=\"text-align:center;\">keterangan</td><td width='6%' style=\"text-align:center;\"></td></tr></thead><tbody id='body"+data2+"'></tbody></table></div></fieldset></td></tr></table></td></tr>");
		//obj_caller.document.getElementById('txtMasterBarang').value=document.getElementById('txtMasterBarang'+data).innerHTML
		//obj_caller.document.getElementById('namaItem').innerHTML=document.getElementById('txtNmBarang'+data).innerHTML
		//obj_caller.document.getElementById('txtNamaItem').value=document.getElementById('txtNmBarang'+data).innerHTML
		//obj_caller.document.getElementById('harga').innerHTML=document.getElementById('txtHarga'+data).innerHTML
		//obj_caller.document.getElementById('txtHarga').value=document.getElementById('txtHarga'+data).innerHTML
		//obj_caller.document.getElementById('jumlah').innerHTML=document.getElementById('txtJumlah'+data).innerHTML
		//obj_caller.document.getElementById('txtJumlah').value=document.getElementById('txtJumlah'+data).innerHTML
		//obj_caller.document.getElementById('total').innerHTML=document.getElementById('txtTotal'+data).innerHTML
		//obj_caller.document.getElementById('txtTotal').value=document.getElementById('txtTotal'+data).innerHTML
		//obj_caller.document.getElementById('total').innerHTML=document.getElementById('txtTotal'+data).innerHTML
		//obj_caller.document.getElementById('txtTotal').value=document.getElementById('txtTotal'+data).innerHTML
		
		obj_caller.document.getElementById('tablePermintaan').style.display = "block" 
		obj_caller.document.getElementById('cariRequest').style.display = "none" 
		obj_caller.document.getElementById('manualPenawaran').style.display = "none" 
		obj_caller.document.getElementById('clearInputan').style.display = "block" 
		obj_caller.document.getElementById('Submit').style.display = "block" 
		obj_caller.document.getElementById('kolomBarang').style.display = "block" 
		parent.window.close();

	}
</script>