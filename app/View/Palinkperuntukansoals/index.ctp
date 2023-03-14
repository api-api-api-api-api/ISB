<?php
	echo $this->Html->script('h1palinkperuntukansoal.js');
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
	#tampilkaryawan tbody {display:block;height:400px;overflow:auto;}
	#tampilkaryawan thead, #tampilkaryawan tbody tr {display:table;	width:100%;	table-layout:fixed;	}
	#tampilkaryawan thead {width: calc( 100% - 1em )}
	#tableSetNik thead, #tableSetNik tbody tr {display:table;	width:100%;	table-layout:fixed;	}
	#tableSetNik tbody{display:block;max-height:350px;overflow:auto;}

	/* #tampilkaryawan th {position: -webkit-sticky;  position: sticky;  top: 0;  z-index: 2;}
	#tampilkaryawan tr:nth-child(even) th[scope=row] {}
	#tampilkaryawan th[scope=row] {position: -webkit-sticky;  position: sticky;  left: 0;  z-index: 1;}*/
	/*  #tampilkaryawan th[scope=row] {vertical-align: top;  color: inherit; }
	#tampilkaryawan th:not([scope=row]):nth-child(2){left: 0;z-index: 3;}*/
	.pagination{margin:0;}

	@media only screen and (min-width: 650px) {
        #modalCopy {
            width: 40%;
            margin-left:25%;
            margin-top:2%;
            margin-bottom:2%;
        }
    }
    .modal-body{height: 90%;}
    /* #modalPA {           
        padding:1%;
    } */
</style>
<div class="row">
	<blockquote>SETTING PERUNTUKAN SOAL PERFORMANCE APPRAISAL</blockquote><hr>
</div>

<form name="formlinksoal" id="formlinksoal">
	
<input type='hidden' id='statusPeriode' name='statusPeriode'>

<div class="row">
	<div class="col-md-12" style="display:none;"> 
		<fieldset style="padding:10px; width:100%" class="roundIt">
			<table id='filterSoal'>
				<tr>
					<td width="82">Periode</td>
					<td><select class='form-control' name='isiPeriode' id='isiPeriode' onchange="getData(1)"></select></td>
				</tr>
			</table>
		</fieldset>
	</div>
</div>
<div id="setForm" style="display: none">
	<div class="row">
		<div class="col-md-12">
		
			<h4>List karyawan yang sudah diset</h4>
			
			<div class="form-group"><label class="control-label">  FILTER <i class="fa fa-search fa-fw"></i>:  </label></div>
			<div class="form-group"><input type="text" name="filter" id="filter" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="NIK / NAMA KARYAWAN" onkeyup="if(event.keyCode === 13){getData(1)}" ></div>
			<div class="form-group" style="display:none;"><input type="text" name="nofungsi" id="nofungsi" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" ></div>
			<div class="form-group" style=""><button type="button" class='btn btn-default btn-sm' style="margin-bottom:0" onclick='getData(1)'> <i class="fa fa-search fa-fw"></i> CARI</button></div>
			<div class="panel panel-default">
				<div class="panel-body"  style="overflow-y:auto;">
					<table class="table" id="tableperuntukansoal">
						<thead>
							<tr>
								<th>No.</th>
								<th>NIK</th>
								<th>Nama</th>
								<th>Bagian</th>
								<th>Jabatan</th>
								<th>Divisi</th>
								<th style='text-align:center'>Detail</th>
								<th style='text-align:center'>Del/Copy</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
					
				</div>
				<div class='panel-footer'>
					
					<nav aria-label="Page navigation example " id="linkHal1" style="display:block"></nav>

				</div>
			</div>
		</div>
	</div>
	<div class="row">
	<hr>
	</div>
	<div class='row'>
		
		<div class="col-md-6">
			<!-- Tampilkan Soal -->
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default" id="showHidePeruntukanSoal">
						<div class="panel-body">
							<div class="col-md-12">
								<div class="form-group">
									<label for="fordivisi">#PELAKSANAAN PEKERJAAN (JOB IMPLEMENTATION) - SOAL</label><HR>
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<label for="fordivisi">Pilih Divisi peruntukan soal</label>
									<div class="input-group"><span class="input-group-addon"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i></span> 
										<input type="hidden" class="form-control" id="txtdivisiInput" name="" width="98%">
										<span class="autocomplete-select " id="divisiInput" ></span>  
									</div>
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<label for="forlabel" >Pilih Jabatan peruntukan soal</label>
									<div class="input-group"><span class="input-group-addon"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i></span> 
										<input type="hidden" class="form-control" id="txtjabatanInput" name="" width="98%">
										<span class="autocomplete-select " id="jabatanInput" ></span> 
									</div>
								</div>
							</div>
							<div class="col-md-5 ">
								<div class="form-group">
								
								<button  type='button' class='btn btn-success btn-sm btnSetSoal' id="btnSetSoal" ><i class="fa fa-plus-square" aria-hidden="true"></i> Tentukan Soal</button>
								<input type="hidden" id='cekSoal' name='cekSoal' />
								</div>
							</div>
						</div>
						<div class="panel-footer">
							<label><em> Klik Tentukan Soal untuk menampilkan dan memilih soal</em></label>
						</div>					
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12" id='panelSetSoal'>	
					<div class="panel-group" id="panelSoal" role="tablist" aria-multiselectable="true">
											
					</div>
				</div>
			</div>
		</div>

		<!-- End Tampil Soal -->
		<!-- Tampil Karyawan -->
		<div  class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="form-group">
								<div class="col-xs-8"><label for="forlabel"><span><em> Klik Cari Karyawan untuk mencari dan memilih karyawan</em></span></label></div>
								<div class="col-xs-4 text-right"><button type="button" class="btn btn-success btn-sm btnCariKry" id="btnCariKry">Cari Karyawan</button></div>
								
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12" id='panelCariKaryawan' style="display:none">
					 <div class="panel panel-primary">
					 	<div class="panel-heading">
					 		Set karyawan <label id="lblmktnonmkt"></label> 
							<input type="hidden" name="mktNonMkt" id="mktNonMkt" value="" >
							<input type="hidden" name="divisiSet" id="divisiSet" value="" >
							<input type="hidden" name="jabatanSet" id="jabatanSet" value="" >
					 	</div>
						<div class="panel-body"  style="overflow-y:auto;">
							<table class='table' id='tableSetNik'>
								<thead>
									<tr>
										<th width="5%">no</th>
										<th width="15%">nik</th>
										<th width="65%">nama</th>
										<th></th>
									</tr>
								</thead>
								<tbody style="height:230px;max-height: 230px;overflow-y:auto;"></tbody>
							</table>
						</div>
						<div class="panel-footer">
							<button type="button" class="btn btn-primary btn-block" id="btnSimpan"> Simpan Peruntukan Soal</button>
						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- End Tampil karyawan -->
		
	</div>
</div>



</form>
<!-- modal form add -->
<div class="modal fade"  id="modalTampilKaryawan" role="dialog" aria-labelledby="modalTampilKaryawan" style="margin-top: 2%;outline: 0;">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="border-radius: 6px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
				<span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span></button>
				<h4 class="modal-title" id="myModalLabel">TENTUKAN KARYAWAN YANG AKAN DI SET SOALNYA</h4>
			</div>
			<div class="modal-body" style="overflow-y:auto;">
				<form name="formsetkaryawan" id="formsetkaryawan">
					<div class="row">
					<!-- col-md-offset-1 -->
						<div class="col-md-12 ">
							<div class="panel panel-default">
								<textarea id="buffer" style='display:none;'></textarea>
								<div class="panel-body" >
									<table>
										<tr style="display:none;">
											<td>divisi</td>
											<td>:</td>
											<td>
												<select class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" id="txtfilterdiv"><option value="">Cari Divisi</option></select>
											</td>
										</tr>
										<tr style="display:none;">
											<td>jabatan</td>
											<td>:</td>
											<td><select class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" id="txtfilterjab"><option value="">Cari Jabatan</option></select></td>
										</tr>
										<tr style="display:none">
											<td>bagian</td>
											<td>:</td>
											<td>
												<select class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" id="txtfilterbag"><option value="">Cari Bagian</option></select>
											</td>
										</tr>
										<tr>
											<td>Tentukan Marketing / Non Marketing</td>
											<td>:</td>
											<td><select class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" id="tentukanMKTnonMKT">
												<option value="">Tentukan Marketing / Non Marketing</option>
													<option value="marketing">Marketing</option>
													<option value="nonmarketing">Non Marketing</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>NIK / Nama</td>
											<td>:</td>
											<td><input type="text" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" name="txttext" placeholder="Cari NIK / NAMA" id="txttext"></td>
										</tr>
										
										<tr><td></td><td></td><td><button type="button" id="btnCariKaryawanModal" class='btn btn-default btn-sm'>cari / tampilkan karyawan</button></td></tr>
										<tr><td></td><td></td><td><em>*Klik cari untuk memunculkan list karyawan</em></td></tr>
										
									</table>
									
									</hr>
								   <table id='tampilkaryawan' class='table table-bordered'>
										<thead>
											<!-- <tr><td>no</td><td>nik</td><td>nama</td><td>jabatan</td><td>bagian</td><td>divisi</td></tr> -->
											<tr>
												<th width="30px">no</th>
												<th width="30px"></th>
												<th>nik  <input class='roundIt' type="text" onkeyup="filterName(this.value,2)" placeholder="filter nik"></th>
												<th>nama    <input class='roundIt' type="text" onkeyup="filterName(this.value,3)" placeholder="filter nama"></th>
												<th>jabatan   <input class='roundIt'type="text" onkeyup="filterName(this.value,4)" placeholder="filter jabatan"></th>
												<th>bagian   <input class='roundIt' type="text" onkeyup="filterName(this.value,5)" placeholder="filter bagian"></th>
												<th>divisi   <input class='roundIt' type="text" onkeyup="filterName(this.value,6)" placeholder="filter divisi"></th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
								</div>
								<div class='panel-footer'>
									<button type="button" class="btn btn-sm btn-default" id="btnUncheck" onclick="checkAll()">Check All</button>  
									<button type="button" class="btn btn-sm btn-default" id="btnCheck" onclick="uncheckAll()">Uncheck All</button>  
									<button type="button" class="btn btn-sm btn-default" id="btnSetKaryawan" onclick="settableSetNik()">Pilih Karyawan</button>  
								</div>
							</div>
						</div>
					</div>
			   </form>
			</div>
		</div>
	</div>
</div>

<!-- modal detail -->
<div class="modal fade"  id="modalDetail" role="dialog" aria-labelledby="modalDetail" style="margin-top: 2%;outline: 0;">
	<div class="modal-dialog" role="document">
		<form name="formEdit">
		<div class="modal-content" style="border-radius: 6px;min-height: unset;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()"><span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span></button>
				<h4 class="modal-title" id="myModalLabelDetail">DETAIL SOAL</h4>
				<button type="button" class='btn btn-primary' id='buttonEdit' onclick="edit()"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>
				<button type="button" class='btn btn-danger' id='buttonBatal'  onclick="batalEdit()" style="display:none"><i class='fa fa-ban' aria-hidden='true'></i> Batal</button>
				<input type="hidden" name="setiddetail" id="setiddetail" />
			</div>

			<div class="modal-body" style="height:750px;max-height: 750px;overflow-y:auto;" id='tampilDetail'>


			</div>
			<div class="modal-footer"></div>
		</div>
		</form>
	</div>
</div>

<div class="modal fade" id="modalCopy" role="dialog" aria-labelledby="modalCopy" >
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="border-radius: 6px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span>
				</button>
				<h4 class="modal-title">Copy peruntukan soal</h4>
				
			</div>
			<div class="modal-body" style="overflow-y:auto;">
				<form name="maintenanceForm" id="maintenanceForm">
					<div class="row">
					<!-- col-md-offset-1 -->
						<div class="col-md-12 ">
                            <div class="panel panel-default">
                                <div class="panel-body form-horizontal">
                                    <input type="hidden" name="mode" id="mode">
                                    <div class="form-group" >
                                        <label class="col-md-3 control-label">Copy soal dari</label>
                                        <div class="col-md-9 inputGroupContainer" style='margin-bottom:8px;'>
                                            <div class="input-group"><span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                            <span class="form-control" id="txtKaryawanCopy" readonly style="height: unset;"></span>
                                            <input id="karyawanCopy" name="karyawanCopy" class="form-control"  type="hidden" readonly>
                                        	</div>
                                        </div>
                                    </div>

                                    <div class="form-group" >
                                    	<label class="col-md-3 control-label">Ke</label>
                                    	<div class="col-md-9 inputGroupContainer">
                                        	<div class="input-group"><span class="input-group-addon"><i class="fa fa-users" aria-hidden="true"></i></span>
                                            <input id="nikkaryawan" name="nikkaryawan" class="form-control" required="true" type="hidden">
                                            <span class="autocomplete-select" id="txtKaryawan"></span>
                                        	</div>
                                        	 <label><em>Copy karyawan bisa lebih dari 1(satu)</em></label>
                                    	</div>
                                    </div>
                                </div>
                                <div class='panel-footer'>
                                    <button type="button" class="btn btn-block btn-lg btn-default" id="btnCopySimpan" ><i class="fa fa-floppy-o" aria-hidden="true"></i> SIMPAN</button>  
                                </div>
                            </div>
                        </div>
                    </div>
               </form>
			</div>
			<div class="modal-footer">
				<!-- <button type="button" class="btn btn-primary" id="btnCopySimpan">Simpan</button> -->
				<button type="button" class="btn btn-default btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>