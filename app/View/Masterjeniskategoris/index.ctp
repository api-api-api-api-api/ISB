<?php
echo $this->Html->script('h1masterjenisketegori.js');
?>
<style type="text/css">
	header{background-color: #f1f1f1;padding: 20px;text-align: center;	font-family: Titillium Web,Open Sans, sans-serif;font-weight: bold; font-size:14px;}
	table.scroll {width: 100%; /* Optional */  /* border-collapse: collapse; */ border-spacing: 0; border: 2px solid red;}
	table.scroll tbody,table.scroll thead { display: block; }
	table.scroll thead tr th { height: 30px; line-height: 30px; /*text-align: left;*/background-color:#f3e0be}
	table.scroll tbody { height: 150px; overflow-y: auto; overflow-x: hidden;}
	/*tbody { border-top: 2px solid black; }*/
	table.scroll tbody td,table.scroll thead th { border-right: 1px solid black;padding:5px 0px}
	tbody td:last-child, thead th:last-child { border-right: none;}

</style>
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
<header class="header">Maintenence Jenis Kategori Barang</header>
	<fieldset class="roundIt" style="width:100%;">
		<table style="width:100%">
			<tr>
				<td style="width:50%">
					<table style="width:100%">
						<tr>
							<td><strong> Jenis Item</strong></td>
							<td align="right">
								<input type="checkbox" id="filterByJenis" onchange="getData('1')" checked="checked" value="Filter By Jenis Item" style="display: none;">
							Filter By Jenis
							<input type="text" id="txtJenis" name="txtJenis" class="roundIt" placeholder="Cari Item Jenis">	
							<button type="button"  class="tomKcl" id="btnCariJenis"  onClick="getData('1')">Cari</button>	
							</td>
						</tr>
					</table>
					<table id="tableA"  class="scroll" style="width:100%;">
						<thead></thead>
						<tbody></tbody>
					</table>
					<table style="width:100%">
						<tr>
							<td><div id="linkHal" style="height:18px; font-weight:bold; alignment-adjust:middle; display:none" ></div>	</td>
							<td align="right">
							<button type="button"  id="tblAdd"  onClick="add()">add</button>
							<button type="button"  id="tblEdit"  onClick="edit()">Edit</button>
							<button type="button"  id="tblDel"  onClick="del()">Del</button>
							<button type="button"  id="tblBtl"  onClick="btl()" style="display:none;">Batal</button>
							</td>
						</tr>
					</table>
				</td>
				<td style="width:50%;" >
					<table align="center" style="width: 60%;display:none" id="h1form">
						<tr><td>
								<form name="h1form"  >
								<fieldset class="roundIt" style="width:100%;padding:5%;box-shadow:0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19) !important;" >	
									<table align="center"  style="width:100%;">
										<tr><td width="30%" style="padding-top:5%"><label >Jenis Item</label></td><td width="3%">:</td><td width="67%">
										<input type="text" id="txtJnsId" name="txtJnsId" class="form-control" style="display:none">
										<input type="text" id="txtJenisInput" name="txtJenisInput" class="form-control" style="margin-top:2%;margin-bottom:2%;font-size:10px;"></td></tr>
										<tr><td ><label style="margin-top:2%">Kategori</label></td><td>:</td><td>
										<select name="txtKategoriInput" id="txtKategoriInput" class="form-control" style="margin-bottom:2%;font-size:10px;"><option></option></select></td></tr>
										<tr><td colspan="3" align="center"><button type="button" class="form-control" id="tblSave" onClick="simpan()" style="margin-top:2%;font-size:10px;">Simpan</button></td></tr>
									</table>
								</fieldset>
								</form>
						</td></tr>
					</table>
				</td>
			</tr>
		</table>
	</fieldset>
	<!-- table kategori -->
	<fieldset class="roundIt" style="width:100%; margin-top:2%">
		<table style="width:100%">
			<tr>
				<td style="width:50%">
					<table style="width:100%">
						<tr>
							<td><strong> Kategori Barang</strong></td>
							<td align="right">
								<input type="checkbox" id="filterByKategori" onchange="getData2('1')" checked="checked" value="Filter By Kategori" style="display: none;">
							Filter By Kategori
							<input type="text" id="txtKategori" name="txtKategori" class="roundIt" placeholder="Cari Kategori Barang">	
							<button type="button"  class="tomKcl" id="btnCariKategori"  onClick="getData2('1')">Cari</button>	
							</td>
						</tr>
					</table>
					<table id="tblDetil1" style="width:100%;" >
						<thead></thead>
						<tbody></tbody>
					</table>
					<table style="width:100%">
						<tr>
							<td><div id="linkHal1" style="height:18px; font-weight:bold; alignment-adjust:middle; display:none" ></div>	</td>
							<td align="right">
							<button type="button"  id="tblAddKat"  onClick="addKat()">add</button>
							<button type="button"  id="tblEditKat"  onClick="editKat()">Edit</button>
							<button type="button"  id="tblDelKat"  onClick="delKat()">Del</button>
							<button type="button"  id="tblBtlKat"  onClick="btlKat()" style="display:none;">Batal</button>
							</td>
						</tr>
					</table>
				</td>
				<td style="width:50%;" >
					<table align="center" style="width: 60%;display:none" id="h2form">
						<tr><td>
								<form name="h2form"  >
								<fieldset class="roundIt" style="width:100%;padding:5%;box-shadow:0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19) !important;" >	
									<table align="center"  style="width:100%;">
										<tr><td width="30%" style="padding-top:5%"><label >Kategori Barang</label></td><td width="3%">:</td><td width="67%">
										<input type="text" id="txtKatId" name="txtKatId" class="form-control" style="display:none">
										<input type="text" id="txtKatInput" name="txtKatInput" class="form-control" style="margin-top:2%;margin-bottom:2%;font-size:10px;"></td></tr>
										<tr><td colspan="3" align="center"><button type="button" class="form-control" id="tblSaveKat" onClick="simpanKat()" style="margin-top:2%;font-size:10px;">Simpan</button></td></tr>
									</table>
								</fieldset>
								</form>
						</td></tr>
					</table>
				</td>
			</tr>
		</table>
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