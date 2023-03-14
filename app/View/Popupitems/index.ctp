<?php
$this->layout='popup';
echo $this->Html->script('h1popupitem.js');
?>
<script type='text/javascript'>
	var obj_caller =parent.opener;
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
<br><br>
<div id="update" align="center">
	<form name="h1form" method="post">

			<legend style="margin-left:15px;">Master Item / Barang</legend>
			<label id="Data"></label>
			<input type='hidden' id='divId' value="<?php echo $this->Session->read('dpfdpl_divisiId');?>">
			<table width="100%" id="tblData">
				<tr>
					<td width="100%"><input type="hidden" id="txtOutlet" name="txtOutlet" class="roundIt">&nbsp;
						
					</td>
					<td width="18%" align="left"></td>
				</tr>
				<tr>
					<td colspan="3"></td><td></td>
				</tr>
			</table>

		<div id="tabelUser">
			<table width="100%">
				<tr><td>
					<div id="linkHal" style="height:18px; font-weight:bold; alignment-adjust:middle; display:none" ></div>
				</td></tr>
			</table>
			<table id="tblDetil" style="width:90%" >
			<thead></thead>
			<tbody></tbody>
			</table>
		</div>
		<!-- <input type="button" value="Check All" onClick="checkAll()" class="tomStd">&nbsp;
		<input type="button" value="Clear" onClick="unCheckAll()" class="tomStd">&nbsp; -->
		<input type="button" value="Masukkan" onClick="addToText()" class="tomStd">
		<textarea name="buffer_1" cols=50 rows=10 class="textBuff"></textarea>
	</form>
</div>
<br>
<div align="center">
	<label id="test"></label><br>
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
function addToText(){
	var jum=document.getElementsByName('pilih').length;	
	var k=0;
	var itemId='';
	var namaItem='';
	for (var qq=0; qq<jum ;qq++) {
		if (document.getElementsByName('pilih')[qq].checked) {
			if(k==0){
				itemId=document.getElementsByName('itemId')[qq].value;
				namaItem=document.getElementById('txtNama'+itemId).innerHTML;
				}
			else{	
			itemId=itemId+"-!-"+document.getElementsByName('itemId')[qq].value;
			itemIdYbs=document.getElementsByName('itemId')[qq].value
				namaItem=namaItem+"-!-"+document.getElementById('txtNama'+itemIdYbs).innerHTML;
			}
			k++;
		}
	}
	if(itemId==''){alert('Belum ada barang yang dipilih');return;}
	var n='';
	var jumRecord=""
	var jum=document.getElementsByName('pilih').length;
	var n = $("input:checked").length;
	var rowCount = obj_caller.$("#tableBarang tbody tr").closest('tbody').length;
	
	var j=0;
	if(rowCount<=0){
		j++
	}else{}
	if(j>0){
		for (var mm=0; mm<jum ;mm++){
		if (document.getElementsByName('pilih')[mm].checked) {
			var data=document.getElementsByName('itemId')[mm].value;
			no=mm+1;	
				obj_caller.$("#tableBarang").append("<tr class='tableBarangItem'><td style=\"padding-top:15px;\"><table><tr><td width='10%'>Nama Barang</td><td width='1%'>:</td><td width='23%'><input type='hidden' name='txtMasterBarang[]' id='txtMasterBarang"+data+"' value='"+data+"'/><label id='namaItem"+data+"'>"+document.getElementById('txtNama'+data).innerHTML+"</label><input type='hidden' name='txtNamaItem[]' id='txtNamaItem"+data+"' value='"+document.getElementById('txtNama'+data).innerHTML+"'></td><td width='6%'>&nbsp;</td><td width='1%'>&nbsp;</td><td width='8%'><input type='hidden' name='txtHarga[]' id='txtHarga"+data+"' value=''></td><td width='7%'>&nbsp;</td><td width='1%'>&nbsp;</td><td width='5%'><input type='hidden' name='txtJumlah[]' id='txtJumlah"+data+"' value=''></td><td width='6%'>&nbsp;</td><td width='1%'>&nbsp;</td><td width='13%'><input type='hidden' name='txtTotal[]' id='txtTotal"+data+"' value=''></td><td width='10%' align='right'><input type='hidden' name='txtindexItem' id='indexItem"+data+"' value='"+data+"'/><input type='button' name='hapusItem' value='- hapus' onClick='dellTblData(this)'></td><td width='10%' id='"+data+"'><input type='button' name='Submit3' value='+ Penawaran' onClick='getSupplier(this)' /><input type='checkbox' name='cek' value='"+data+"' style='display:none'/></td></tr><tr><td colspan='14'><fieldset class='roundIt'><div id='tabelUser"+data+"' style='width:100%'><table width='100%'><tr><td><div id='linkHal' style=\"height:18px; font-weight:bold; alignment-adjust:middle; display:none\" ></div></td></tr></table><table id='tblDetil'"+data+" style='width:100%'><thead><tr><td width='7%' style=\"text-align:center;\">supid</td><td width='25%' style=\"text-align:center;\">nama supplier</td><td width='8%' style=\"text-align:center;\">harga @</td><td width='5%' style=\"text-align:center;\">qty</td><td width='12%' style=\"text-align:center;\">total</td><td width='8%' style=\"text-align:center;\">mata uang</td><td width='27%' style=\"text-align:center;\">keterangan</td><td width='6%' style=\"text-align:center;\"></td></tr></thead><tbody id='body"+data+"'></tbody></table></div></fieldset></td></tr></table></td></tr>");		
				}
			}
		}else{
			var newrowCount = obj_caller.$(".tableBarangItem").length;
			//alert(newrowCount)
			//exit()
			for (var m=0; m<jum ;m++) {
				var data=document.getElementsByName('itemId')[m].value
				if (document.getElementsByName('pilih')[m].checked) 
				{
					for (var n=0;n<newrowCount;n++) {
					txtB=document.getElementsByName('itemId')[m].value.trim();
					txtA1=obj_caller.document.getElementsByName('txtindexItem')[n].value;
					//alert(n+'-'+txtA1+'---'+obj_caller.document.getElementsByName('proid')[n].value+'=='+m+'-'+txtB+'--'+data)
					if (txtA1==txtB){
						alert("Produk Sudah Di masukkan");
						return;
					}
				}
			//alert(txtB)
			no=newrowCount+1;
			obj_caller.$("#tableBarang").append("<tr class='tableBarangItem'><td style=\"padding-top:15px;\"><table><tr><td width='10%'>Nama Barang</td><td width='1%'>:</td><td width='23%'><input type='hidden' name='txtMasterBarang[]' id='txtMasterBarang"+data+"' value='"+data+"'/><label id='namaItem"+data+"'>"+document.getElementById('txtNama'+data).innerHTML+"</label><input type='hidden' name='txtNamaItem[]' id='txtNamaItem"+data+"' value='"+document.getElementById('txtNama'+data).innerHTML+"'></td><td width='6%'>&nbsp;</td><td width='1%'>&nbsp;</td><td width='8%'><input type='hidden' name='txtHarga[]' id='txtHarga"+data+"' ></td><td width='7%'>&nbsp;</td><td width='1%'>&nbsp;</td><td width='5%'><input type='hidden' name='txtJumlah[]' id='txtJumlah"+data+"' ></td><td width='6%'>&nbsp;</td><td width='1%'>&nbsp;</td><td width='13%'><input type='hidden' name='txtTotal[]' id='txtTotal"+data+"' value=''></td><td width='10%' align='right'><input type='hidden' name='txtindexItem' id='indexItem"+data+"' value='"+data+"'/><input type='button' name='hapusItem' value='- hapus' onClick='dellTblData(this)'></td><td width='10%' id='"+data+"'><input type='button' name='Submit3' value='+ Penawaran' onClick='getSupplier(this)' /><input type='checkbox' name='cek' value='"+data+"' style='display:none'/></td></tr><tr><td colspan='14'><fieldset class='roundIt'><div id='tabelUser"+data+"' style='width:100%'><table width='100%'><tr><td><div id='linkHal' style=\"height:18px; font-weight:bold; alignment-adjust:middle; display:none\" ></div></td></tr></table><table id='tblDetil'"+data+" style='width:100%'><thead><tr><td width='7%' style=\"text-align:center;\">supid</td><td width='25%' style=\"text-align:center;\">nama supplier</td><td width='8%' style=\"text-align:center;\">harga @</td><td width='5%' style=\"text-align:center;\">qty</td><td width='12%' style=\"text-align:center;\">total</td><td width='8%' style=\"text-align:center;\">mata uang</td><td width='27%' style=\"text-align:center;\">keterangan</td><td width='6%' style=\"text-align:center;\"></td></tr></thead><tbody id='body"+data+"'></tbody></table></div></fieldset></td></tr></table></td></tr>");		
	
				}
			}
		}
		obj_caller.document.getElementById('cariRequest').style.display = "none" 
		obj_caller.document.getElementById('manualPenawaran').style.display = "none" 
		obj_caller.document.getElementById('clearInputan').style.display = "block" 
		obj_caller.document.getElementById('Submit').style.display = "block" 
		obj_caller.document.getElementById('kolomBarang').style.display = "block" 
		parent.window.close();

}

</script>

