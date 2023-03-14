<?php
	echo $this->Html->script('h1reportrefreshkaryawan.js');
?>
<style type="text/css">
#gridhide { width:1200px; height:500px}
.aw-header-0 .aw-column-0, .aw-header-0 .aw-column-1, .aw-header-0 .aw-column-2, .aw-header-0 .aw-column-21, .aw-header-0 .aw-column-25 {text-align:center}

.aw-column-0 {width: 30px; text-align:center}
.aw-column-1 {width: 100px; text-align:center}
.aw-column-2 {width: 100px; text-align:center}
.aw-column-3 {width: 200px; text-align:center}
.aw-column-4 {width: 100px; text-align:center}
.aw-column-5 {width: 200px; text-align:left}
.aw-column-6 {width: 100px; text-align:center}
.aw-column-7 {width: 100px; text-align:center}
.aw-column-8 {width: 100px; text-align:center}
.aw-column-9 {width: 100px; text-align:center}
.aw-column-10 {width: 100px; text-align:center}
.aw-column-11 {width: 100px; text-align:center}
.aw-column-12 {width: 100px; text-align:center}
.aw-column-13 {width: 100px; text-align:center}
.aw-column-14 {width: 100px; text-align:center}
.aw-column-15 {width: 100px; text-align:center}
.aw-column-16 {width: 100px; text-align:center}
.aw-column-17 {width: 100px; text-align:center}
.aw-column-18 {width: 100px; text-align:center}
.aw-column-19 {width: 100px; text-align:center}
.aw-column-20 {width: 100px; text-align:center}
.aw-column-21 {width: 100px; text-align:center}
.aw-column-22 {width: 100px; text-align:center}
.aw-column-23 {width: 100px; text-align:center}
.aw-column-24 {width: 100px; text-align:center}
.aw-column-25 {width: 100px; text-align:center}
.aw-column-26 {width: 100px; text-align:center}
.aw-column-27 {width: 100px; text-align:center}
.aw-column-28 {width: 100px; text-align:center}
</style>
<h4>Laporan Upload Refresh Karyawan</h4>

<div id="dialog" style="display:none;"></div>
<form name="h1form" action="" method="POST">
	<table width="1200">
		<tr>
			<td width="120">Periode Upload</td>
			<td width="250">
				<div class='form-inline'>
					<div class='form-group'>
						<select name="bulan" id="bulan" class="form-control" onchange="setUploadKe();">
						<option value="" selected="selected">Pilih Bulan</option>
						<?php for($t=1;$t<=12;$t++){
							if($t==date("8")){
								echo "<option value=$t selected>".$this->Function->monthName($t)."</option>";
							}else{
								echo "<option value=$t>".$this->Function->monthName($t)."</option>";
							}
						}?>
						</select>
					</div>
					<div class='form-group'>
						<select name="tahun" id="tahun" class="form-control" onchange="setUploadke()"  >
						<option value="" selected="selected">Pilih Tahun</option>
						<?php
						for ($t=date("Y")-5;$t<=date("Y")+10;$t++){
							if($t==date("Y")){
								echo "<option value=$t selected>$t</option>\n";
							}else{
								echo "<option value=$t>$t</option>\n";
							}
						}
						?>
						</select>
					</div>
				</div>
			</td>
			<td rowspan="6" valign="top">
					<div class="panel panel-default" style="margin-bottom: 0;">
						<div class="panel-body">
							Keterangan Halaman:
							<ul>
								<li>Halaman ini merepresentasikan,dari hasil setiap file excel yang di upload dari halaman report refresh karyawan</li>
								<li>Seluruh record dari file yang di excel, akan ditampilkan di GRID di bawah ini beserta status eksekusi</li>
							</ul>
							Keterangan Filter:
							<ul>
								<li><strong>Periode Upload</strong> : Menunjukkan bulan dan tahun periode file diupload</li>
								<li><strong>Upload Ke</strong>: Menunjukkan data hasil file upload yang ke berapa, dari periode upload</li>
								<li><strong>Status</strong>: Terdapat 3 pilihan dalam status
									<ul>
										<li><strong>Tampilkan semua</strong>: Akan menampilkan semua record data yang di upload, sesuai dengan <strong>periode dan upload ke</strong></li>
										<li><strong>Sukses</strong>: Akan menampilkan record data dengan status Sukses</li>
										<li><strong>Gagal</strong>: Akan menampilkan record data dengan status Gagal</li>
									</ul>
								</li>
								<li><strong>Keterangan</strong>: keterangan akan muncul berdasarkan pilihan status,dan hanya 2 yang menjadi parameter yaitu Sukses dan Gagal
									<ul>
										<li>Sukses <strong>Tampil Semua</strong> : akan menampilkan semua record yang berhasil di proses</li>
										<li>Sukses <strong>Forced Entry</strong> : hanya akan menampilkan record yang berhasil di proses dengan FORCED ENTRY</li>
										<li>Gagal <strong>Tanggal Lahir Berbeda </strong> : menampilkam record yang gagal diproses karena tanggal lahir yang berbeda</li>
										<li>Gagal <strong>Tanggal Masuk Berbeda (SEMUA DATA)</strong> : menampilkan semua record yang gagal diproses karena Tanggal Masuk Berbeda</li>
										<li><em>Gagal <strong>Tanggal Masuk Berbeda (FORCED ENTRY)</strong> : menampilkan data yang gagal diproses, akan tetapi bisa diproses ulang atau dipakasakan masuk karena di identifikasi merupakan data yang baru</em></li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				
				
			</td>
		</tr>
		<tr>
			<td>Upload ke</td>
			<td>
				<div class='form-inline'>
					<div class='form-group'>
						<select name="filterUploadKe" id="filterUploadKe" class="form-control" >
							<option value="All" selected="selected">Semua</option>
							<option value="1">I</option>
							<option value="2">II</option>
							<option value="3">III</option>
							<option value="4">IV</option>
							<option value="5">V</option>
							<option value="6">VI</option>
						</select>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td>Status</td>
			<td>
				<div class='form-inline'>
					<div class='form-group'>
						<select name="filterStatusUpload" id="filterStatusUpload" class="form-control"  onchange="setKeterangan()">
							<option value="All" selected="selected">Tampilkan Semua</option>
							<option value="Sukses">Sukses</option>
							<option value="Gagal" >Gagal</option>
						</select>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td>
				<div class='form-inline'>
					<div class='form-group'>
						<select name="filterKeterangan" id="filterKeterangan" class="form-control">
							<option value="All" selected="selected">Tampil Semua</option>
							<option value="Forced">Forced Entry</option>
						</select>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="button" value="Proses" class="btn btn-default"  name="Proses" onclick="prosesAmbilData('srch')" /></td>
		</tr>
		<tr height="100" >
			<td></td>
			<td></td>
		</tr>
	</table>
	<script type="text/javascript">
	var header=["","","Status","Ket. Status","nik","nama kry","kode div","kode dept","kode area","kode bagian","kode subarea","kode region","kode lokasi","jabatan","status kry","ket status kry","kode makan","tgl Lahir","tgl coba","tgl masuk","tgl keluar","tgl masuk jst","plafoncuti","j cuti awal","j cuti bulan","qty cuti sdbl","bulan","tahun","Upload Ke"];
	var gridhide = new AW.UI.Grid;
	gridhide.setId("gridhide");
	gridhide.setHeaderHeight(50);
	var check = new AW.Templates.Checkbox;
	gridhide.setCellTemplate(check,0);
	gridhide.setHeaderText(header);
	gridhide.setColumnIndices([0,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28]);
	gridhide.setColumnCount(gridhide.getColumnIndices().length);
	gridhide.setColumnResizable(true);
	gridhide.setCellEditable(true);
	gridhide.setSelectionMode("single-row");
	gridhide.onRowClicked = function(event, row){
		var c = gridhide.getCellValue(2,row);
		var d = gridhide.getCellValue(3,row);
		var e = gridhide.getCellValue(29,row);
		if(c=='Sukses'){
			return  gridhide.setCellValue(false,0,row);
		}
		if(d!='Tanggal Masuk Berbeda'){
			return  gridhide.setCellValue(false,0,row);
		}
		if(e!=''){
			return  gridhide.setCellValue(false,0,row);
		}
		if(this.getCellValue(0,row)==true){
			gridhide.setCellValue(false,0,row);
		}else{
			gridhide.setCellValue(true,0,row);
		}
		document.h1form.bufferset.value='';
		var dataTampung='';
		for(n=0;n<gridhide.getRowCount();n++){
			if(this.getCellValue(0,n)==true){
				dataTampung +=gridhide.getCellValue(1,n)+',';
			}
		}
		document.h1form.bufferset.value=dataTampung
	}
	gridhide.setSelectorVisible(true);
	gridhide.setSelectorWidth(42);
	gridhide.setSelectorText(function(i){return this.getRowPosition(i)+1});
	document.write(gridhide);
	</script>

	<fieldset style='width:500px'>
		<legend><h5>Jika ada data yang tidak masuk, cek kembali dan simpan perubahan</h5></legend>
		<button type='button' id='checkAll' onClick='cekAll()'> Check Semua</button>
		<button type='button' id='uncheckAll' onClick='unCekAll()'> Uncheck Semua</button>
		<button type='button' id='updateIn' onClick='updateInsert()'> Simpan Forced Entry</button>
	</fieldset>
	<input type="button" value="Cetak Laporan" name="Cetak" onClick="cetakLap()" style="display:none"/>
	<input type="button" value="Cetak Excel" name="CetakX" onClick="cetakLap('excel')" />
	<textarea name="buffer" cols="50" rows="10" class="textBuff" style="display:none"></textarea>
	<textarea name="bufferhelper" cols="50" rows="10" class="textBuff" style="display:none"></textarea>
	<textarea name="bufferset" cols="50" rows="10" class="textBuff" style="display:none"></textarea>
</form>

