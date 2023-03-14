<?php
	echo $this->Html->script('h1papersetujuan.js');
	echo $this->Html->script('bundle.min.js');
?>
<style>
	.select-wrapper {margin: auto; max-width: 500px;width: calc(100% - 40px);}
	.select-pure__select {align-items: center;border-radius: 0;border: 1px solid #ccc;box-sizing: border-box;color: #363b3e;cursor: pointer; display: flex;font-size: 16px;font-weight: 500;justify-content: left;min-height: 34px;padding: 5px 10px; position: relative;transition: 0.2s; width: 100%;}
	.select-pure__options {  border-radius: 4px;border: 1px solid rgba(0, 0, 0, 0.15);box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04); box-sizing: border-box;color: #363b3e; display: none; left: 0; max-height: 221px;overflow-y: scroll; position: absolute; top: 35px; width: 100%; z-index: 5;}
	.select-pure__select--opened .select-pure__options { display: block;}
	.select-pure__option { background: #fff; border-bottom: 1px solid #e4e4e4; box-sizing: border-box;/* height: 44px;*/ line-height: 20px; padding: 10px;}
	.select-pure__option--selected { color: #e4e4e4; cursor: initial; pointer-events: none;}
	.select-pure__option--hidden { display: none;}
	.select-pure__selected-label {background: #5e6264;border-radius: 4px;color: #fff;cursor: initial;display: inline-block; margin: 5px 10px 5px 0;padding: 3px 7px;}
	.select-pure__selected-label:last-of-type { margin-right: 0;}
	.select-pure__selected-label i {cursor: pointer;display: inline-block; margin-left: 7px;}
	.select-pure__selected-label i:hover {  color: #e4e4e4;}
	.select-pure__autocomplete {background: #faebcc; border-bottom: 1px solid #e4e4e4;border-left: none; border-right: none;border-top: none; box-sizing: border-box;font-size: 16px;outline: none;padding: 10px; width: 100%; margin-bottom:0 !important}
	.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {width: 49%;color:black;height:20px;}
	.tab{transition: transform .2s;}
	.tab:hover {cursor:pointer;transform: scale(1.03);}
	.table th {position: -webkit-sticky;  position: sticky;  top: 0;  z-index: 2;}
	.ativetab{background-color: lightblue;background: -webkit-linear-gradient(45deg, cornsilk, Bisque);border-top:1px solid #ddd !important;}
</style>
<div class="row">
	<blockquote>INFORMASI PENILAIAN PRESTASI KERJA  (PERFORMANCE APPRAISAL)</blockquote><hr>
</div>
<form id="form1" name="form1" method="POST">
<div class="row">
	<div class="col-md-12">
		<div class="">
			<div class="col-md-4">
				<div class="row">
					<h4>Periode Penilaian : <span class="label label-primary" id='txtPeriode'></span></h4><hr>
					<input type="hidden" name="periode" class='form-control'id='periode' style="display:block" readonly>
					<input type="hidden" name="iduser" id="iduser">
					<input type="hidden" name="nikuser" id="nikuser">
					<input type="hidden" name="namauser" id="namauser">
					<input type="hidden" name="tgllahiruser" id="tgllahiruser">
					<input type="hidden" name="sebagai" id="sebagai">
					<input type="hidden" name="idkry" id="idkry">
					<input type="hidden" name="nikkry" id="nikkry">
					<input type="hidden" name="namakry" id="namakry">
					<input type="hidden" name="tgllahirkry" id="tgllahirkry">
					<h4>Daftar karyawan yang dinilai</h4>
					<div class="panel panel-default">

						<table  id='tblkaryawan' cellpadding="0" cellspacing="0" width="100%" class="table " style="border-radius: 5px;margin-bottom:0;" > 
							<thead>
							</thead> 
							<tbody>

							</tbody>
						</table>
						<div class="panel-footer">
							<nav aria-label="Page navigation example " id="linkHal" style="display:block"></nav>
						</div>
					</div>
					<p class="text-danger"><em>*Pilih karyawan dengan klik nama karyawan yang ada di atas</em></p>
				</div>
			</div>
			<div class="col-md-1">
			</div>
			<div class="col-md-7" id="detailSoal">
				<div class="row">
					<div class=''>
						<h4>Informasi Detail Penilaian</h4><hr>
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6 form-horizontal">
										<div class="form-group" style="margin-bottom:0">
											<label for="txtNik" class="col-sm-6 control-label">NIK (Identification number)</label>
											<div class="col-sm-6">
												<p class="form-control-static" id='txtNik'></p>
											</div>
										</div>
										<div class="form-group" style="margin-bottom:0">
											<label for="txtNik" class="col-sm-6 control-label">Nama (Employee's name)</label>
											<div class="col-sm-6">
												<p class="form-control-static" id='txtNama'></p>
											</div>
										</div>
										<div class="form-group" style="margin-bottom:0">
											<label for="txtNik" class="col-sm-6 control-label">Tanggal masuk (Date of entry)</label>
											<div class="col-sm-6">
												<p class="form-control-static" id='txtTglMsk'></p>
											</div>
										</div>
									</div>
									<div class="col-md-6 form-horizontal">
										<div class="form-group" style="margin-bottom:0">
											<label for="txtNik" class="col-sm-6 control-label">Jabatan</label>
											<div class="col-sm-6">
												<p class="form-control-static" id='txtJabatan'></p>
											</div>
										</div>
										<div class="form-group" style="margin-bottom:0">
											<label for="txtNik" class="col-sm-6 control-label">Status</label>
											<div class="col-sm-6">
												<p class="form-control-static" id='txtStatus'></p>
											</div>
										</div>
									</div>
								</div>
							</div>
							
						</div>
						<!-- <div class="form-group">
							<table width="100%">
								<tr>
									<td width="200"><label>NIK (Identification number)<label></td>
									<td>:</td>
									<td  width="200" id="txtNik"></td>
									<td width="100"><label>Jabatan</label></td>
									<td>:</td><td  width="200" id="txtJabatan"></td>
								</tr>
								<tr>
									<td><label>Nama (Employee's name)</label></td>
									<td>:</td><td id="txtNama"></td><td><label>Status</label></td>
									<td>:</td><td id="txtStatus"></td>
								</tr>
								<tr><td><label>Tanggal masuk (Date of entry)</label></td><td>:</td><td id="txtTglMsk"></td><td></td><td></td><td></td></tr>
							</table>
						</div> -->
					</div>
						<div class="panel-group" id="detailPenilaian" role="tablist" aria-multiselectable="true">
						
						</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>