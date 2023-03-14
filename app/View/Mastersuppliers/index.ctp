<?php
echo $this->Html->script('h1mastersupplier.js');
?>
<style type="text/css">
	header{background-color: #f1f1f1;padding: 20px;text-align: center;	font-family: Titillium Web,Open Sans, sans-serif;font-weight: bold; font-size:14px;}
	#tblDetil thead tr {
   background-color: #d2ccb5;
}
#tblDetil thead a {
	color:#000;
	font-weight:bold;
}
#tblDetil thead a:hover{
	color:#C00;
	font-weight:bold;
}


#tblDetil tbody tr:nth-child(odd) {
   background-color: #E2E2E2;
}

#tblDetil1 tbody tr:nth-child(odd) {
   background-color: #fff;
}

#tblDetil2 tbody tr:nth-child(odd) {
   background-color: #CCC;
}

#tblDetil td{	
	border-bottom:inset 1px #333;
	border-right:inset 1px #333;
	font-style:inherit;
	padding-left:5px;
	padding-right:5px;}
	
#tblDetil2 td{	
	border-bottom:inset 1px #333;
	border-right:inset 1px #333;
	font-style:inherit;
	padding-left:5px;
	padding-right:5px;}
	
#tblDetil tr{
		height:30;}
	
	
	
#tblEvaluasi thead tr {
   background-color: #D2CCB5;
   height:15px;
}
#tblEvaluasi thead a {
	color:#000;
	font-weight:bold;
}
#tblEvaluasi thead a:hover{
	color:#C00;
	font-weight:bold;
}		



#tblEvaluasi tbody tr:nth-child(even) {
   background-color: #E2E2E2;
}
#tblEvaluasi td{	
	border-bottom:inset 1px #333;
	border-right:inset 1px #333;
	font-style:inherit;
	padding-left:5px;
	padding-right:5px;}
#tblEvaluasi tr{
		height:30;}
.tf {border-bottom:1px solid #000}
.pl { padding-left:3px; text-align:left; }
.pc { text-align:center; }
.pr {
	padding-right:3px;
	text-align:right;
}
</style>
<header class="header">MASTER SUPPLIER</header>
<fieldset class="roundIt" style="width:100%;">
	<div id="update" >
		<form name="h1form" method="post">
		<label id="Data"></label>
		<!-- <table width="100%" id="tblData">
			<tr>
				<td width="100%" align="center">
				<input type="checkbox" id="filterBySupplier" name="filterBySupplier" onchange="getData('1')" checked="checked" value="Filter By Supplier">Filter by Supplier
				<input type="text" id="txtSupplier" name="txtSupplier" class="roundIt">
				<input type="button" id="cariSupplier" class="tomKcl" value="Cari" onClick="getData('1')">
				<input type="hidden" name="btnAksi" id="btnAksi">
				<input type="button" id="addSupplier" class="tomKcl" value="Tambah" onClick="addToSupp()">
				</td>
				<td width="20%" align="left"></td>
			</tr>
		</table> -->
		<div id="tabelUser" >
			<table width="100%" >
				<tr>
					<td>
						<div  id="linkHal" style="height:18px; font-weight:bold; alignment-adjust:middle; display:none" ></div>
					</td>
					<td align="right">
					<input type="checkbox" id="filterBySupplier" name="filterBySupplier" onchange="getData('1')" checked="checked" value="Filter By Supplier" style="display: none;">Filter by <select id="getFilter" name="getFilter"><option value="nama">Nama</option><option value="deskripsi">Deskripsi</option></select>
					<input type="text" id="txtSupplier" name="txtSupplier" class="roundIt">
					<input type="button" id="cariSupplier" class="tomKcl" value="Cari" onClick="getData('1')">
					<input type="hidden" name="btnAksi" id="btnAksi">
					<input type="button" id="addSupplier" class="tomKcl" value="Tambah" onClick="addToSupp()">
					</td>
				</tr>

			</table>
			<table id="tblDetil" style="width:100%" >
			<thead></thead>
			<tbody></tbody>
			</table>
		</div>
		</form>
	</div>
	<div align="center">
		<label id="test"></label>
		<label >Catatan : klik pada <strong>[ Nama Supplier ]</strong> diatas untuk melihat detail supplier dan update data </label>
	</div>
</fieldset>
<script>
 $(function() {
	$('#loading').ajaxStart(function(){
		$(this).fadeIn();
	}).ajaxStop(function(){
		$(this).fadeOut();
	});
});
</script>