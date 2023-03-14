<?php
$this->layout='popup';
echo $this->Html->script('h1popupoutletinput.js');
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
<legend style="margin-left:15px;">Cari Outlet</legend>
<label id="Data"></label>
<input type='hidden' id='divId' value="<?php echo $this->Session->read('dpfdpl_divisiId');?>">

<table width="100%" id="tblData">

<tr><td colspan="4">
<input type="checkbox" id="filterByDM" onchange="getData('1')" checked="checked" value="Filter By Sales">Filter By DM<br>
</td></tr>
<tr>
<td width="27%">Nama Outlet</td>
<td width="1%">:</td>
<td width="61%"><input type="text" id="txtOutlet" name="txtOutlet" class="roundIt">&nbsp;<input type="button" id="cariOutlet" class="tomKcl" value="Cari" onClick="getData('1')"></td>
<td width="11%" align="left"></td>
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
function addToData(data){
	//alert('jalan123')
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
	kodeOutlet=document.getElementById('txtKodeOutlet'+data).innerHTML;
	
	var url = 'popupoutletinputs/cekOutletDist';
	//call jQuery AJAX function

	
	$.ajax({
      url: url,
      type: "POST",
      data: ({kodeDists:kodeDists,cabangDists:cabangDists,kodeOutlet:kodeOutlet}),
      dataType: "text",
      success: function(returnedVal){if(returnedVal=='belumMatch'){alert('Ada outlet yang belum match dengan distributor');return;}
	  obj_caller.document.getElementById('namaOutlet').innerHTML=document.getElementById('txtNama'+data).innerHTML
	obj_caller.document.getElementById('txtAlamatOutlet').innerHTML=document.getElementById('txtAlamat'+data).innerHTML
	obj_caller.document.getElementById('kodeOutlet').innerHTML=document.getElementById('txtKodeOutlet'+data).innerHTML
	obj_caller.document.getElementById('txtKodeOutlet').value=document.getElementById('txtKodeOutlet'+data).innerHTML
	obj_caller.document.getElementById('txtDMId').value=document.getElementById('txtDMId'+data).innerHTML
	obj_caller.document.getElementById('txtSMId').value=document.getElementById('txtSMId'+data).innerHTML
	obj_caller.document.getElementById('txtGSMId').value=document.getElementById('txtGSMId'+data).innerHTML
	obj_caller.document.getElementById('txtFINId').value=document.getElementById('txtFinId'+data).innerHTML
	obj_caller.document.getElementById('txtApprover').innerHTML=document.getElementById('txtApprover'+data).innerHTML
	parent.window.close();
	  
	  }
		});		

	
	
	}

 </script> 
