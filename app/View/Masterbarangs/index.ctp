<?php
echo $this->Html->script('h1masterbarang.js');
//harus ada untuk semua konversi
// echo $this->Html->script('tableExport.js');
// echo $this->Html->script('jquery.base64.js');

//untuk konversi png
//echo $this->Html->script('html2canvas.js');
//untuk konversi pdf
//echo $this->Html->script('jspdf/jspdf.js');
//echo $this->Html->script('jspdf/libs/sprintf.js');
//echo $this->Html->script('jspdf/libs/base64.js');
?>
<style type="text/css">
	body{

	}
	.tb { width:950px; font-family:Tahoma, Arial, Helvetica, sans-serif; font-size:14px; }
	.tr { width:950px; float:left; }
	#tblDetil  tr th{font-family: Arial ; font-weight: normal;height:20px;vertical-align: middle !important;text-align: center;box-shadow: 0 -10px 5px rgba(0,0,0,.1) inset;}
	#tblDetil tbody tr td > a {color: darkslategray !important;font-size: 12px;padding: 2px;margin-right: 4px;}
	#tblDetil a:hover {color: #333 !important}
	header{background-color: #f1f1f1;padding: 20px;text-align: center;	font-family: Titillium Web,Open Sans, sans-serif;font-weight: bold; font-size:14px;}
	.form-group{margin-bottom:8px !important;}
	.form-group label,.form-group input,.form-group span{font-family:Arial !important;font-size:12px; font-weight:500;}
	#tableIsi td,#tableIsi>thead>tr>th{vertical-align: middle;padding: 0px;}
	.form-control{font-size:12px !important;}
</style>
<header class="header">MASTER BARANG</header>
<fieldset class="roundIt" style="width:100%;">
	<div id="update" >
		<form  name="h1form" method="post" class="frmInput">
		<input type="text" name="" id="group" value="<?php if (isset($_GET['jenisPermintaan'])) {echo $_GET['jenisPermintaan']; }else{ echo "";}?>" style="display:none;">
		<label id="Data"></label>
		<!-- <button id="cetak" type="button" >Cetak</button> -->
		<div id="tabelUser" >
			<table width="100%" >
            	<tr>
					<td align="left" style="width:6%;">
                    <!-- <label>Group</label> -->
                    </td>
                    <td align="left">
					<!-- <select class="roundIt"  name="selectGroup" id="selectGroup">
						<option value="ATK">ATK</option>
                        <option value="INVENTARIS">INVENTARIS</option>
						<option value="PROMOSI">PROMOSI</option>
						
					</select> -->
					</td>
                    <td></td>
					<td align="right">
					</td>
				</tr>
            	<tr>
                <td align="left">
                    <input type="checkbox" id="filterByItemBarang" onchange="getData('1')" checked="checked" value="Filter By Item Barang" style="display: none;">
					<select class="roundIt"  name="selectFilter" id="selectFilter">
						<option value="item">Nama Barang</option>
						<option value="kategori">Kategori</option>
						<option value="jenis">Jenis</option>
					</select>
                    </td>
					<td align="left"><input type="text" id="txtItemBarang" name="txtItemBarang" class="roundIt" placeholder="Cari Barang">
					<button type="button"  class="tomKcl" id="cariNama"  onClick="getData('1')"> Cari</button>	
					<input type="hidden" name="btnAksi" id="btnAksi">
					<input type="button" id="addBarang" class="tomKcl" value="Tambah" onClick="addToBrg()">
					</td>
                    <td></td>
					<td align="right">
					
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<div  id="linkHal" style="height:18px; font-weight:bold; alignment-adjust:middle; display:none" ></div>
					</td>
					<td align="right">
					
					</td>
				</tr>

			</table>
			<table id="tblDetil" style="width:100%;margin-top:10px;" class="table table-bordered">
			<thead></thead>
			<tbody></tbody>
			</table>
		</div>
		</form>
	</div>
	<div align="center">
		<label id="test"></label>
		<label >Catatan : klik pada <strong>[ Nama Barang ]</strong> diatas untuk melihat detail barang dan update data </label>
		
	</div>
	<!-- <div align="center">
		<label id="test"></label>
		<label >jika  <strong>[ kategori dan jenis barang ]</strong> belum ada atau perlu perubahan, bisa melakukan maintenance di bawah ini </label>
	</div>
	<div align="center"><label >Maintenance </label>
	<input type="button" name="btnGanti" value="Kategori" onclick="kategoriData()" class="tomStd2" style="border-radius:3px; background-color:#999; color:#000; font-weight:bold">
	<input type="button" name="btnGanti" value="Jenis" onclick="jenisData()" class="tomStd2" style="border-radius:3px; background-color:#999; color:#000; font-weight:bold"></div> -->
</fieldset>


<!-- Small modal -->

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="max-width: 40%; max-height: 90%; margin-left: 30%; margin-top: 2%; overflow-y: hidden;">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Modal title</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<div class="form-horizontal">
							<div class="well has-success">
								<input type="text" name='maintenanceTag' id='maintenanceTag' style="display:none">
								<div class="form-group clsKategori">
									<label for="txtKategoriBrg" class="col-sm-3 control-label">Tambah Kategori *</label>
									<div class="col-sm-7">
										<input type="text" id="txtKategoriBrg" name="txtKategori" class="form-control" placeholder="Isi Kategori">
									</div>
									<div class="col-sm-2">
										<button type="button" class="btn btn-primary" onclick="saveKategori()">Save</button>
									</div>
								</div>
								<div class="form-group clsJenis">
									<label for="txtJenisBrg" class="col-sm-3 control-label">Tambah Jenis *</label>
									<div class="col-sm-7">
										<input type="text" id="txtJenisBrg" name="txtJenis" class="form-control" placeholder="Isi Jenis">
									</div>
									<div class="col-sm-2">
										<button type="button" class="btn btn-primary" onclick="saveJenis()">Save</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
					<div class="well has-success">
						<table id="tableIsi"  class="table">
							<thead></thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
			<center><nav id="linkHal1" style="display:none" ></nav></center>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			</div>
		</div>
	</div>

<script>
 $(function() {
	$('#loading').ajaxStart(function(){
		$(this).fadeIn();
	}).ajaxStop(function(){
		$(this).fadeOut();
	});
});
</script>