<?php
$this->layout='popup';
echo $this->Html->script('h1popupsupplier.js');
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
			<legend style="margin-left:15px;">Cari Supplier</legend>
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
	var supId='';
	var namaSup='';
	for (var qq=0; qq<jum ;qq++) {
		if (document.getElementsByName('pilih')[qq].checked) {
			if(k==0){
				supId=document.getElementsByName('supid')[qq].value;
				namaSup=document.getElementById('txtNama'+supId).innerHTML;
				}
			else{	
			supId=supId+"-!-"+document.getElementsByName('supid')[qq].value;
			supIdYbs=document.getElementsByName('supid')[qq].value
				namaSup=namaSup+"-!-"+document.getElementById('txtNama'+supIdYbs).innerHTML;
			}
			k++;
		}
	}
	if(supId==''){alert('Belum ada supplier yang dipilih');return;}
	var n='';
	var qty='';
	var jumRecord='';
	var jum=document.getElementsByName('pilih').length;
	var n = $("input:checked").length;
	var rowTarget=obj_caller.$("input:checked").val();
	

	//var rowCount = obj_caller.$("#tblDetil tbody tr").closest("tbody").length;
	var rowCountBody= obj_caller.$("#body"+rowTarget+" tr").length;
	//alert(rowCountBody)
	//exit();
	var j=0;
	if(rowCountBody<=0){
		j++
	}else{}
	if(j>0){
		if(n>3){
			alert('inputan max 3')	
			return;
		}else{
			for (var mm=0; mm<jum ;mm++){
			if (document.getElementsByName('pilih')[mm].checked) {
				var data=document.getElementsByName('supid')[mm].value;
				no=mm+1;
				if (obj_caller.$("#txtJumlah"+rowTarget).val()==''){
					qty="<input type='text' name='qty"+rowTarget+"[]' id='txtQty"+rowTarget+data+"' onKeyUp=upAngka(this,'"+rowTarget+data+"') style='width:20px;'>"
				}else{
					qty=obj_caller.$("#txtJumlah"+rowTarget).val()+"<input type='hidden' name='qty"+rowTarget+"[]' id='txtQty"+rowTarget+data+"' value='"+obj_caller.$("#txtJumlah"+rowTarget).val()+"' style='width:20px;'>"
				}	
				obj_caller.$("#body"+rowTarget).append("<tr id='"+rowTarget+data+"' ><td id='txtSupid"+data+"'>"+document.getElementById('id'+data).innerHTML+"<input type='hidden' name='supid"+rowTarget+"[]' id='txtSupid"+data+"' value='"+data+"'><input type='hidden' name='indexId"+rowTarget+"' id='indexId"+data+"' value='"+data+"'></td><td style=\"text-align:left; width:300px;\">"+document.getElementById('txtNama'+data).innerHTML+"<input type='hidden' name='nama"+rowTarget+"[]' id='txtNamaSup"+data+"' value='"+document.getElementById('txtNama'+data).innerHTML+"'</td><td  align='center'><input type='text' name='hargaSatPen"+rowTarget+"[]' id='txtHargaSatPen"+rowTarget+data+"' value='0' onKeyUp=upAngka(this,'"+rowTarget+data+"') style='text-align:right; width:75px;'></td><td  align='center'>"+qty+"</td><td  align='center'><label id='totalPen"+rowTarget+data+"'></label><input type='hidden' name='totalPenawaran"+rowTarget+"[]' id='txtTotalPenawaran"+rowTarget+data+"' style='text-align:right; width:75px;'></td><td  align='center'><select id='txtMataUang"+data+"' name='mataUang"+rowTarget+"[]'><option value='IDR'>IDR</option><option value='EUR'>EUR</option><option value='SGD'>SGD</option><option value='USD'>USD</option></select></td><td ><input type='text'  name='keterangan"+rowTarget+"[]' id='txtKeterangan"+data+"' style='width:150px;'></td><td><a href='#'onClick='dellToData(this)'>hapus</a></td></tr>");			
				}
			}
		}
	}else{
		var newrowCountBody= obj_caller.$("#body"+rowTarget+" tr").length;
		//alert(newrowCountBody)
		//var newrowCount = obj_caller.$("#tblDetil tbody tr").length;
		jumRecord=n+newrowCountBody;
		if(jumRecord>3){alert('inputan max 3')}else
		if (newrowCountBody>=3){
			alert('inputan max 3')
			return;
		}else{
			for (var m=0; m<jum ;m++) {
				var data=document.getElementsByName('supid')[m].value
				if (document.getElementsByName('pilih')[m].checked) 
				{
					for (var n=0;n<newrowCountBody;n++) {
					txtB=document.getElementsByName('supid')[m].value.trim();
					txtA1=obj_caller.document.getElementsByName('indexId'+rowTarget)[n].value;
					//alert(n+'-'+txtA1+'---'+obj_caller.document.getElementsByName('proid')[n].value+'=='+m+'-'+txtB+'--'+data)

						if (txtA1==txtB){
							alert("Produk Sudah Di masukkan");
							return;
						}
					}
					//alert(txtB)
					no=newrowCountBody+1;
					if (obj_caller.$("#txtJumlah"+rowTarget).val()==''){
						qty="<input type='text' name='qty"+rowTarget+"[]' id='txtQty"+rowTarget+data+"' onKeyUp=upAngka(this,'"+rowTarget+data+"') style='width:20px;'>"
					}else{
						qty=obj_caller.$("#txtJumlah"+rowTarget).val()+"<input type='hidden' name='qty"+rowTarget+"[]' id='txtQty"+rowTarget+data+"' value='"+obj_caller.$("#txtJumlah"+rowTarget).val()+"' style='width:20px;'>"
					}	
					obj_caller.$("#body"+rowTarget).append("<tr id='"+rowTarget+data+"' ><td id='txtSupid"+data+"'>"+document.getElementById('id'+data).innerHTML+"<input type='hidden' name='supid"+rowTarget+"[]' id='txtSupid"+data+"' value='"+data+"'><input type='hidden' name='indexId"+rowTarget+"' id='indexId"+data+"' value='"+data+"'></td><td style=\"text-align:left; width:300px;\">"+document.getElementById('txtNama'+data).innerHTML+"<input type='hidden' name='nama"+rowTarget+"[]' id='txtNamaSup"+data+"' value='"+document.getElementById('txtNama'+data).innerHTML+"'</td><td  align='center'><input type='text' name='hargaSatPen"+rowTarget+"[]' id='txtHargaSatPen"+rowTarget+data+"' value='0' onKeyUp=upAngka(this,'"+rowTarget+data+"') style='text-align:right; width:75px;'></td><td  align='center'>"+qty+"</td><td  align='center'><label id='totalPen"+rowTarget+data+"'></label><input type='hidden' name='totalPenawaran"+rowTarget+"[]' id='txtTotalPenawaran"+rowTarget+data+"' style='text-align:right; width:75px;'></td><td  align='center'><select id='txtMataUang"+data+"' name='mataUang"+rowTarget+"[]'><option value='IDR'>IDR</option><option value='EUR'>EUR</option><option value='SGD'>SGD</option><option value='USD'>USD</option></select></td><td ><input type='text'  name='keterangan"+rowTarget+"[]' id='txtKeterangan"+data+"' style='width:150px;'></td><td><a href='#'onClick='dellToData(this)'>hapus</a></td></tr>");		
	
				}
			}
		}
	}
	obj_caller.$('input[type="checkbox"]').prop("checked", false);
	parent.window.close();
}
</script>