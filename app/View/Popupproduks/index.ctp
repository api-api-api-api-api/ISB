<?php
$this->layout='popup';
echo $this->Html->script('h1popupproduk.js');
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
<legend style="margin-left:15px;">Cari Produk</legend>
<label id="Data"></label>
<input type='hidden' id='divId' value="<?php echo $this->Session->read('dpfdpl_divisiId');?>">
<table width="100%" id="tblData">
<tr>
<td width="28%">Nama Produk</td>
<td width="1%">:</td>
<td width="53%"><input type="text" id="txtOutlet" name="txtOutlet" class="roundIt">&nbsp;<input type="button" id="cariOutlet" class="tomKcl" value="Cari" onClick="getData('1')"><input type="checkbox" id="prodDivisiLain" onchange="cekCheck(this.checked)" value="Prod Divisi Lain">Prod Divisi Lain</td>
<td width="18%" align="left"></td>
</tr>
<tr>
<td colspan="3"></td><td></td>
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
	if(obj_caller.document.getElementById('titleForm').innerHTML.indexOf("DPF")>0){
		kodeDist=obj_caller.document.getElementById('groupDist').value;
		cabangDist=obj_caller.document.getElementById('txtCabangDistri').value;
		var kodeDists = kodeDist;
		var cabangDists = cabangDist;
		}
	else if(obj_caller.document.getElementById('titleForm').innerHTML.indexOf("DPL")>0){
		kodeDist1=obj_caller.document.getElementById('txtDistri1').value;
		cabangDist1=obj_caller.document.getElementById('txtCabang1').value;
		kodeDist2=obj_caller.document.getElementById('txtDistri2').value;
		cabangDist2=obj_caller.document.getElementById('txtCabang2').value;
		kodeDist3=obj_caller.document.getElementById('txtDistri3').value;
		cabangDist3=obj_caller.document.getElementById('txtCabang3').value;
		kodeDist4=obj_caller.document.getElementById('txtDistri4').value;
		cabangDist4=obj_caller.document.getElementById('txtCabang4').value;
		var kodeDists =kodeDist1+"-!-"+kodeDist2+"-!-"+kodeDist3+"-!-"+kodeDist4;
		var cabangDists = cabangDist1+"-!-"+cabangDist2+"-!-"+cabangDist3+"-!-"+cabangDist4;
		}
	var jum=document.getElementsByName('pilih').length;	
	var k=0;
	var proId='';
	var namaProd='';
	for (var qq=0; qq<jum ;qq++) {
		if (document.getElementsByName('pilih')[qq].checked) {
			if(k==0){
				proId=document.getElementsByName('proid')[qq].value;
				namaProd=document.getElementById('txtNama'+proId).innerHTML;
				}
			else{	
			proId=proId+"-!-"+document.getElementsByName('proid')[qq].value;
			proIdYbs=document.getElementsByName('proid')[qq].value
				namaProd=namaProd+"-!-"+document.getElementById('txtNama'+proIdYbs).innerHTML;
			}
			k++;
		}
	}
	
	if(proId==''){alert('Belum ada produk yang dipilih');return;}
	
	var url = 'popupproduks/cekProdukDist';
	//call jQuery AJAX function

	
	$.ajax({
      url: url,
      type: "POST",
      data: ({kodeDists:kodeDists,cabangDists:cabangDists,proId:proId,namaProd:namaProd}),
      dataType: "text",
      success: function(returnedVal){
		  returnedVal=returnedVal.split("-!-");
		  if(returnedVal[0]=='belumMatch'){alert('Produk '+returnedVal[1]+' belum dimatch ke dist '+returnedVal[2]);return;}
	 	else{
	 //JIKA SEMUA MATCH, MASUKKAN KE LIST
	 	var url = 'popupproduks/getSetDiscDist';
		var setDiscDist=0;
	//call jQuery AJAX function
	$.ajax({
      url: url,
      type: "POST",
      data: ({}),
      dataType: "text",
	  async:false,
      success: function(returnedVal){
		  setDiscDist=returnedVal
		  }
   	}
	);	
	if(setDiscDist==0){
		txtDiscDistEnabled='disabled';
		txtDiscDistVal=0;
		}
	else{txtDiscDistEnabled='';txtDiscDistVal='';}
	var jum=document.getElementsByName('pilih').length;
	var rowCount = obj_caller.$("#tblDetil tbody tr").closest("tbody").length;
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
			var data=document.getElementsByName('proid')[mm].value;
			no=m+1;
			if(divisiId==1){
				obj_caller.$("#tblDetil").append("<tr><td id='txtProid'"+data+">"+document.getElementById('id'+data).innerHTML+"<input type='hidden' name='proidHid' id='txtProid"+data+"' value='"+data+"'></td><td style=\"text-align:left; width:300px;\">"+document.getElementById('txtNama'+data).innerHTML+"<input type='hidden' name='nama' id='txtNamaPro"+data+"' value='"+document.getElementById('txtNama'+data).innerHTML+"'</td><td>"+document.getElementById('txtHna'+data).innerHTML+"<input type='hidden' name='hna' id='txtHnaHid"+data+"' value='"+document.getElementById('txtHna'+data).innerHTML+"'</td><td><input type='text'  name='estSales' id='estSales"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:75px;'></td><td style='text-align:center'><input type='text' name='diskPrins' id='txtdiskPrins"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:50px;'></td><td style='text-align:center;'><input type='text' name='diskDist' "+txtDiscDistEnabled+" value='"+txtDiscDistVal+"' id='txtDiskDist"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:50px;'></td><td style='text-align:center'><input type='text' name='offFaktur' id='txtOffFaktur"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:50px;'></td><td style='text-align:right' ><label id='lblTotalDiskon"+data+"'></label><input type='hidden' name='totalDiskon' id='txtTotalDiskon"+data+"' style='text-align:right'></td><td><a href='#' onClick='dellToData(this)'>hapus</a></td></tr>");
				}
			else{
				obj_caller.$("#tblDetil").append("<tr><td id='txtProid'"+data+">"+document.getElementById('id'+data).innerHTML+"<input type='hidden' name='proidHid' id='txtProid"+data+"' value='"+data+"'></td><td style=\"text-align:left; width:300px;\">"+document.getElementById('txtNama'+data).innerHTML+"<input type='hidden' name='nama' id='txtNamaPro"+data+"' value='"+document.getElementById('txtNama'+data).innerHTML+"'</td><td>"+document.getElementById('txtHna'+data).innerHTML+"<input type='hidden' name='hna' id='txtHnaHid"+data+"' value='"+document.getElementById('txtHna'+data).innerHTML+"'</td><td><input type='checkbox' id='chkHgJd' onclick='cekhna2("+data+",this.checked)'></td><td><input type='text'  name='hna2' id='txtHna2"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:75px;'  value='"+document.getElementById('txtHna'+data).innerHTML+"' disabled='disabled'></td><td><input type='text' name='unit' id='txtUnit"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:50px;'></td><td style='text-align:right'><label id='lblHargaJadi1"+data+"'></label><input type='hidden' name='hargaJadi1' id='txtHargaJadi1"+data+"' style='text-align:right; width:75px;'></td><td style='text-align:right'><label id='lblHargaJadi"+data+"'></label><input type='hidden' name='hargaJadi' id='txtHargaJadi"+data+"' style='text-align:right; width:75px;'></td><td style='text-align:center'><input type='text' name='diskPrins'  id='txtdiskPrins"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:50px;'></td><td style='text-align:center;'><input type='text' name='diskDist' "+txtDiscDistEnabled+" value='"+txtDiscDistVal+"' id='txtDiskDist"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:50px;'></td><td style='text-align:center'><input type='text' name='offFaktur' id='txtOffFaktur"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:50px;'></td><td style='text-align:right' ><label id='lblTotalDiskon"+data+"'></label><input type='hidden' name='totalDiskon' id='txtTotalDiskon"+data+"' style='text-align:right'></td><td><a href='#' onClick='dellToData(this)'>hapus</a></td></tr>");
				}	
			}}

			
			}else{
				
			for (var m=0; m<jum ;m++) {
				var data=document.getElementsByName('proid')[m].value
				if (document.getElementsByName('pilih')[m].checked) {
				
				for (var n=0;n<rowCount;n++) {
				
				txtB=document.getElementsByName('proid')[m].value.trim();
				txtA1=obj_caller.document.getElementsByName('proidHid')[n].value;
				
				//alert(n+'-'+txtA1+'---'+obj_caller.document.getElementsByName('proid')[n].value+'=='+m+'-'+txtB+'--'+data)
			
				if (txtA1==txtB){
					alert("Produk Sudah Di masukkan");
					return;
				}
				}
		//alert(txtB)
		no=rowCount+1;
	if(divisiId==1){
		obj_caller.$("#tblDetil").append("<tr><td id='txtProid'"+data+">"+document.getElementById('id'+data).innerHTML+"<input type='hidden' name='proidHid' id='txtProid"+data+"' value='"+data+"'></td><td style=\"text-align:left; width:300px;\">"+document.getElementById('txtNama'+data).innerHTML+"<input type='hidden' name='nama' id='txtNamaPro"+data+"' value='"+document.getElementById('txtNama'+data).innerHTML+"'</td><td>"+document.getElementById('txtHna'+data).innerHTML+"<input type='hidden' name='hna' id='txtHnaHid"+data+"' value='"+document.getElementById('txtHna'+data).innerHTML+"'</td><td><input type='text'  name='estSales' id='estSales"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:75px;'></td><td style='text-align:center'><input type='text' name='diskPrins' id='txtdiskPrins"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:50px;'></td><td style='text-align:center;'><input type='text' name='diskDist' "+txtDiscDistEnabled+" value='"+txtDiscDistVal+"'  id='txtDiskDist"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:50px;'></td><td style='text-align:center'><input type='text' name='offFaktur' id='txtOffFaktur"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:50px;'></td><td style='text-align:right' ><label id='lblTotalDiskon"+data+"'></label><input type='hidden' name='totalDiskon' id='txtTotalDiskon"+data+"' style='text-align:right'></td><td><a href='#' onClick='dellToData(this)'>hapus</a></td></tr>");
		}
	else{obj_caller.$("#tblDetil").append("<tr><td id='txtProid'"+data+">"+document.getElementById('id'+data).innerHTML+"<input type='hidden' name='proidHid' id='txtProid"+data+"' value='"+data+"'></td><td style=\"text-align:left; width:300px;\">"+document.getElementById('txtNama'+data).innerHTML+"<input type='hidden' name='nama' id='txtNamaPro"+data+"' value='"+document.getElementById('txtNama'+data).innerHTML+"'</td><td>"+document.getElementById('txtHna'+data).innerHTML+"<input type='hidden' name='hna' id='txtHnaHid"+data+"' value='"+document.getElementById('txtHna'+data).innerHTML+"'</td><td><input type='checkbox' id='chkHgJd'  onclick='cekhna2("+data+",this.checked)'><td><input type='text'  name='hna2' id='txtHna2"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:75px;' value='"+document.getElementById('txtHna'+data).innerHTML+"' disabled='disabled'></td><td><input type='text' name='unit' id='txtUnit"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:50px;'></td><td style='text-align:right'><label id='lblHargaJadi1"+data+"'></label><input type='hidden' name='hargaJadi1' id='txtHargaJadi1"+data+"' style='text-align:right; width:75px;'></td><td style='text-align:right'><label id='lblHargaJadi"+data+"'></label><input type='hidden' name='hargaJadi' id='txtHargaJadi"+data+"' style='text-align:right; width:75px;'></td><td style='text-align:center'><input type='text' name='diskPrins' id='txtdiskPrins"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:50px;'></td><td style='text-align:center;'><input type='text' name='diskDist' "+txtDiscDistEnabled+" value='"+txtDiscDistVal+"'  id='txtDiskDist"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:50px;'></td><td style='text-align:center'><input type='text' name='offFaktur' id='txtOffFaktur"+data+"' onKeyUp=upAngka(this,'"+data+"') style='text-align:right; width:50px;'></td><td style='text-align:right' ><label id='lblTotalDiskon"+data+"'></label><input type='hidden' name='totalDiskon' id='txtTotalDiskon"+data+"' style='text-align:right'></td><td><a href='#' onClick='dellToData(this)'>hapus</a></td></tr>");}
					
				
				
				
	
			}
	
			}	
				
				
				
				
				
				}
			
	parent.window.close();
	 
	 
	 
	 
	 //END INSERT LIST 
		}
	  }
		});		



	
	
	
	
	
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
