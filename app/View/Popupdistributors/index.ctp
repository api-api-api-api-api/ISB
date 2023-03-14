<?php
$this->layout='popup';
echo $this->Html->script('h1popupdistributor.js');
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
<fieldset style="width:90%;" class="roundIt" >
<legend style="margin-left:15px;">Cari Distributor</legend>
<label id="Data"></label>
<input type='hidden' id='divId' value="<?php echo $this->Session->read('dpfdpl_divisiId');?>">
<table width="100%" id="tblData">
<tr><td colspan=4><input type="checkbox" id="filterBySales" onchange="getData(1)" checked="checked" value="Filter By Sales">Filter By Sales<br></td></tr>
<tr class="">
<td width="28%">Group Dist</td>
<td width="1%">:</td>
<td width="53%">

<select name="groupDist" id="groupDist" onChange="cariData(this.value,1)"></select>
</td>
<td width="18%" align="left"></td>
</tr>
<tr class="">
<td width="28%">Alamat</td>
<td width="1%">:</td>
<td width="53%">
<input type="text" id="alamat" name="alamat" />
</td>
<td width="18%" align="left"><input type="button" value="Cari" onclick="cariData(document.getElementById('groupDist').value,1);"/></td>
</tr>
<tr>
<td colspan="4"></td><td></td>
</tr>
</table>
</fieldset>
<div id="tabelUser">
<table width="100%"><tr><td><div id="linkHal" style="height:18px; font-weight:bold; alignment-adjust:middle; display:none" ></div></td></tr></table>
<table id="tblDetil" style="width:90%" >
<thead></thead>
<tbody></tbody>
</table></div>
<input type="button" value="Check All" onClick="checkAll()" class="tomStd">&nbsp;
<input type="button" value="Clear" onClick="unCheckAll()" class="tomStd">&nbsp;
<input type="button" value="Masukkan" onClick="addToText()" class="tomStd">
<textarea name="buffer_1" cols=50 rows=10 class="textBuff"></textarea>
</form>
</div><br>
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
	
	function cetakLap(format){
	if(document.getElementById('txtPrinter').value==''){
		alert('Pilih Printer Sharing')
		return;
		}
		document.h1form.action='../tesPrint0.php';
		document.h1form.target='';
		document.h1form.submit();
		parent.window.close();
			
	
}
function addToText(){
	var jum=document.getElementsByName('pilih').length;
	
	var rowCount = obj_caller.$("#tblDetil tbody tr").length;
	var produk=obj_caller.document.getElementById('produk').innerHTML;
	produk=produk.split("|");
	produkId=produk[0].trim();
	namaProduk=produk[1].trim();
	var j=0;
	//alert(rowCount)
	if(rowCount<=0){
		j++
	}else{}
	divisiId=<?php echo  $this->Session->read('dpfdpl_divisiId');?>;
	//jika kolom obj caller belum ada - masukkan semua produk terchecklist
	if(j>0){
	for (var mm=0; mm<jum ;mm++) {
		if (document.getElementsByName('pilih')[mm].checked) {
		
			var data=document.getElementsByName('kodeDist')[mm].value;
			
			no=m+1;
			
			obj_caller.$("#tblDetil tbody").append("");

	if(obj_caller.document.getElementById('namaForm').innerHTML=='FORECAST'){	
	obj_caller.$("#tblDetil").append("<tr  id='baris"+data+produkId+"'><td></td><td class='textBuff'><input type='hidden' name='produkIdHid' id='txtKodeDist"+data+produkId+"' value='"+produkId+"'>"+produkId+"</td><td id='txtNamaProduk"+data+produkId+"'>"+namaProduk+"</td><td class='textBuff'><input type='hidden' name='kodeDistHid' id='txtKodeDist"+data+produkId+"' value='"+data+"'>"+data+"</td><td class='' id='txtGroupDist"+data+produkId+"'>"+document.getElementById('txtNama'+data).innerHTML+"</td><td id='txtCabangDist"+data+produkId+"'>"+document.getElementById('txtNamaCabang'+data).innerHTML+"</td><td><input type='text' id='txtEstimasiSales"+data+produkId+"' value=0  onKeyUp=upAngka2(this,'"+data+"','"+produkId+"')   style='text-align:right; width:36px;'></td><td  id='rjp"+data+produkId+"'>0</td><td  id='rk"+data+produkId+"'>0</td><td><input type='text' id='txtEstBulan1"+data+produkId+"' value=0  onKeyUp=upAngka(this,'"+data+"','"+produkId+"')  style='text-align:right; width:36px;'></td><td><input type='text' id='txtEstBulan2"+data+produkId+"'  value=0 onKeyUp=upAngka(this,'"+data+"','"+produkId+"')  style='text-align:right; width:36px;'></td><td><input type='text' id='txtEstBulan3"+data+produkId+"'   value=0 onKeyUp=upAngka(this,'"+data+"','"+produkId+"')  style='text-align:right; width:36px;'></td><td align='right' id='txtTW1"+data+produkId+"'>0</td><td><input type='text' id='txtEstBulan4"+data+produkId+"'  value=0 onKeyUp=upAngka2(this,'"+data+"','"+produkId+"')  style='text-align:right; width:36px;'></td><td><input type='text' id='txtEstBulan5"+data+produkId+"'  value=0 onKeyUp=upAngka2(this,'"+data+"','"+produkId+"')  style='text-align:right; width:36px;'></td><td><input type='text' id='txtEstBulan6"+data+produkId+"'  value=0  onKeyUp=upAngka2(this,'"+data+"','"+produkId+"')  style='text-align:right; width:36px;'></td><td align='right' id='txtTW2"+data+produkId+"'>0</td><td id='txtAvg12"+data+produkId+"' align='right'>0</td><td id='txtAvg9"+data+produkId+"' align='right'>0</td><td id='txtAvg6"+data+produkId+"' align='right'>0</td><td id='txtAvg3"+data+produkId+"' align='right'>0</td><td id='txtAvg1"+data+produkId+"' align='right'>0</td><td id='txtTotalStok"+data+produkId+"' align='right'>0</td><td class='textBuff' id='view'><a style='cursor: pointer'  title='Average Sales' data-toggle='popover' data-trigger='click'  data-placement='left' data-poload=\""+data+produkId+"\"  >view</a></td><td><a href='#' onClick='dellToData(this,\""+data+produkId+"\")'>hapus</a></td><td>open</td></tr>");
	}
	else if(obj_caller.document.getElementById('namaForm').innerHTML=='PESTA'){
		obj_caller.$("#tblDetil").append("<tr  id='baris"+data+produkId+"'><td class='textBuff'><input type='hidden' name='produkIdHid' id='txtKodeDist"+data+produkId+"' value='"+produkId+"'>"+produkId+"</td><td id='txtNamaProduk"+data+produkId+"'>"+namaProduk+"</td><td class='textBuff'><input type='hidden' name='kodeDistHid' id='txtKodeDist"+data+produkId+"' value='"+data+"'>"+data+"</td><td class='' id='txtGroupDist"+data+produkId+"'>"+document.getElementById('txtNama'+data).innerHTML+"</td><td id='txtCabangDist"+data+produkId+"'>"+document.getElementById('txtNamaCabang'+data).innerHTML+"</td><td><input type='text' id='txtUsulanPesta"+data+produkId+"' value=0  onKeyUp=upAngka2(this,'"+data+"','"+produkId+"')   style='text-align:right; width:36px;'></td><td><input type='text' id='txtEstimasiSales"+data+produkId+"' value=0  onKeyUp=upAngka2(this,'"+data+"','"+produkId+"')   style='text-align:right; width:36px;'></td><td><input disabled='disabled' type='text' id='txtEstimasiBulanYbs"+data+produkId+"' value=0  onKeyUp=upAngka(this,'"+data+"','"+produkId+"')  style='text-align:right; width:36px;'></td><td id='txtAvg12"+data+produkId+"' align='right'>0</td><td id='txtAvg9"+data+produkId+"' align='right'>0</td><td id='txtAvg6"+data+produkId+"' align='right'>0</td><td id='txtAvg3"+data+produkId+"' align='right'>0</td><td id='txtAvg1"+data+produkId+"' align='right'>0</td><td id='txtTotalStok"+data+produkId+"' align='right'>0</td><td class='textBuff' id='view'><a style='cursor: pointer'  title='Average Sales' data-toggle='popover' data-trigger='click'  data-placement='left' data-poload=\""+data+produkId+"\"  >view</a></td><td><a href='#' onClick='dellToData(this,\""+data+produkId+"\")'>hapus</a></td></tr>");
		}
	obj_caller.cariFCSebelumnya(document.getElementById('txtNama'+data).innerHTML,data,produkId);
	obj_caller.callDetailSales(data,produkId);
		    	   
	
	
	
			}}

			
			}else{
				
			for (var m=0; m<jum ;m++) {
				var data=document.getElementsByName('kodeDist')[m].value
				if (document.getElementsByName('pilih')[m].checked) {
				
				for (var n=0;n<rowCount;n++) {
				
				txtB=document.getElementsByName('kodeDist')[m].value.trim();
				txtA1=obj_caller.document.getElementsByName('kodeDistHid')[n].value;
				produkIdA=obj_caller.document.getElementsByName('produkIdHid')[n].value;
				//alert(n+'-'+txtA1+'---'+obj_caller.document.getElementsByName('proid')[n].value+'=='+m+'-'+txtB+'--'+data)
				//alert(txtA1 +'---'+ txtB)
				
				if (txtA1==txtB && produkIdA==produkId){
					alert("Distributor Sudah Di masukkan");
					return;
				}
				}
		//alert(txtB)
		no=rowCount+1;
	if(obj_caller.document.getElementById('namaForm').innerHTML=='FORECAST'){	
	obj_caller.$("#tblDetil").append("<tr  id='baris"+data+produkId+"'><td></td><td class='textBuff'><input type='hidden' name='produkIdHid' id='txtKodeDist"+data+produkId+"' value='"+produkId+"'>"+produkId+"</td><td id='txtNamaProduk"+data+produkId+"'>"+namaProduk+"</td><td class='textBuff'><input type='hidden' name='kodeDistHid' id='txtKodeDist"+data+produkId+"' value='"+data+"'>"+data+"</td><td class='' id='txtGroupDist"+data+produkId+"'>"+document.getElementById('txtNama'+data).innerHTML+"</td><td id='txtCabangDist"+data+produkId+"'>"+document.getElementById('txtNamaCabang'+data).innerHTML+"</td><td><input type='text' id='txtEstimasiSales"+data+produkId+"' value=0  onKeyUp=upAngka2(this,'"+data+"','"+produkId+"')   style='text-align:right; width:36px;'></td><td  id='rjp"+data+produkId+"'>0</td><td  id='rk"+data+produkId+"'>0</td><td><input type='text' id='txtEstBulan1"+data+produkId+"' value=0  onKeyUp=upAngka(this,'"+data+"','"+produkId+"')  style='text-align:right; width:36px;'></td><td><input type='text' id='txtEstBulan2"+data+produkId+"'  value=0 onKeyUp=upAngka(this,'"+data+"','"+produkId+"')  style='text-align:right; width:36px;'></td><td><input type='text' id='txtEstBulan3"+data+produkId+"'   value=0 onKeyUp=upAngka(this,'"+data+"','"+produkId+"')  style='text-align:right; width:36px;'></td><td align='right' id='txtTW1"+data+produkId+"'>0</td><td><input type='text' id='txtEstBulan4"+data+produkId+"'  value=0 onKeyUp=upAngka2(this,'"+data+"','"+produkId+"')  style='text-align:right; width:36px;'></td><td><input type='text' id='txtEstBulan5"+data+produkId+"'  value=0 onKeyUp=upAngka2(this,'"+data+"','"+produkId+"')  style='text-align:right; width:36px;'></td><td><input type='text' id='txtEstBulan6"+data+produkId+"'  value=0  onKeyUp=upAngka2(this,'"+data+"','"+produkId+"')  style='text-align:right; width:36px;'></td><td align='right' id='txtTW2"+data+produkId+"'>0</td><td id='txtAvg12"+data+produkId+"' align='right'>0</td><td id='txtAvg9"+data+produkId+"' align='right'>0</td><td id='txtAvg6"+data+produkId+"' align='right'>0</td><td id='txtAvg3"+data+produkId+"' align='right'>0</td><td id='txtAvg1"+data+produkId+"' align='right'>0</td><td id='txtTotalStok"+data+produkId+"' align='right'>0</td><td class='textBuff' id='view'><a style='cursor: pointer'  title='Average Sales' data-toggle='popover' data-trigger='click'  data-placement='left' data-poload=\""+data+produkId+"\"  >view</a></td><td><a href='#' onClick='dellToData(this,\""+data+produkId+"\")'>hapus</a></td><td>open</td></tr>");
	}
	else if(obj_caller.document.getElementById('namaForm').innerHTML=='PESTA'){
		obj_caller.$("#tblDetil").append("<tr  id='baris"+data+produkId+"'><td class='textBuff'><input type='hidden' name='produkIdHid' id='txtKodeDist"+data+produkId+"' value='"+produkId+"'>"+produkId+"</td><td id='txtNamaProduk"+data+produkId+"'>"+namaProduk+"</td><td class='textBuff'><input type='hidden' name='kodeDistHid' id='txtKodeDist"+data+produkId+"' value='"+data+"'>"+data+"</td><td class='' id='txtGroupDist"+data+produkId+"'>"+document.getElementById('txtNama'+data).innerHTML+"</td><td id='txtCabangDist"+data+produkId+"'>"+document.getElementById('txtNamaCabang'+data).innerHTML+"</td><td><input type='text' id='txtUsulanPesta"+data+produkId+"' value=0  onKeyUp=upAngka2(this,'"+data+"','"+produkId+"')   style='text-align:right; width:36px;'></td><td><input type='text' id='txtEstimasiSales"+data+produkId+"' value=0  onKeyUp=upAngka2(this,'"+data+"','"+produkId+"')   style='text-align:right; width:36px;'></td><td><input disabled='disabled' type='text' id='txtEstimasiBulanYbs"+data+produkId+"' value=0  onKeyUp=upAngka(this,'"+data+"','"+produkId+"')  style='text-align:right; width:36px;'></td><td id='txtAvg12"+data+produkId+"' align='right'>0</td><td id='txtAvg9"+data+produkId+"' align='right'>0</td><td id='txtAvg6"+data+produkId+"' align='right'>0</td><td id='txtAvg3"+data+produkId+"' align='right'>0</td><td id='txtAvg1"+data+produkId+"' align='right'>0</td><td id='txtTotalStok"+data+produkId+"' align='right'>0</td><td class='textBuff' id='view'><a style='cursor: pointer'  title='Average Sales' data-toggle='popover' data-trigger='click'  data-placement='left' data-poload=\""+data+produkId+"\"  >view</a></td><td><a href='#' onClick='dellToData(this,\""+data+produkId+"\")'>hapus</a></td></tr>");
		}
	obj_caller.cariFCSebelumnya(document.getElementById('txtNama'+data).innerHTML,data,produkId);
	obj_caller.callDetailSales(data,produkId);
			}
	
			}	
				
				}
			
	parent.window.close();
	
	}
function checkAll(){
	var jum=document.getElementsByName('pilih').length;
	for (n=0; n<jum ;n++) {
	document.getElementsByName('pilih')[n].checked='true';
	}
	
	}
function unCheckAll(){
	var jum=document.getElementsByName('pilih').length;
	for (n=0; n<jum ;n++) {
	document.getElementsByName('pilih')[n].checked='';
	}
	
	}
	

 </script> 
