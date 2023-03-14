<?php
	echo $this->Html->script('h1paform.js');
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
	.ativetab{background-color: lightblue;background: -webkit-linear-gradient(45deg, cornsilk, Bisque);border-top:1px solid #ddd !important;}
	input[type="radio"]{box-shadow: unset;}
	#tblidentitas tr td{
		padding:5px;
	} 
	.divhead{background-color: lightblue;background: -webkit-linear-gradient(45deg, cornsilk, Bisque);}
	.panel-footer{background-color: lightblue;background: -webkit-linear-gradient(45deg, cornsilk, Bisque);border-top:1px solid #ddd !important;}
	.divFooter div{font-size: 15px; font-weight:700;}
.table-responsive {
	padding:0 !important
}

#tableSikapKerja thead th,#tablePelaksanaanPekerjaan thead th,#tableKebutuhanTraining thead th{font-size: 12px;}
#tableSikapKerja th {position: -webkit-sticky;  position: sticky;  top: 0;  z-index: 2; border-collapse: collapse; }
#tablePelaksanaanPekerjaan th {position: -webkit-sticky;  position: sticky;  top: 0;  z-index: 2;}
#tableKebutuhanTraining th {position: -webkit-sticky;  position: sticky;  top: 0;  z-index: 2;}
#returnValSK .divhead {position: -webkit-sticky;  position: sticky;  top: 0;  z-index: 2; border-collapse: collapse;font-weight: 700; }
#returnValPK .divhead {position: -webkit-sticky;  position: sticky;  top: 0;  z-index: 2; border-collapse: collapse; font-weight: 700; }
/*#tableSikapKerja {  border-spacing: 1;  border-collapse: collapse;  background: white;  border-radius: 10px;  overflow: hidden;  width: 100%;  margin: 0 auto;  position: relative;}*/
#tableSikapKerja *,#tablePelaksanaanPekerjaan *  {  position: relative;}
#tableSikapKerja tbody tr,#tablePelaksanaanPekerjaan tbody tr {font-size: 15px;  line-height: 1.2;  font-weight: unset;}

.LabelPoin{display: none;}
.LabelPK{display: none;}
.trdiv {padding-top:10px;padding-bottom:10px;}

input[type='radio']{
	
	height: 20px !important;cursor: pointer;
}
input[type='radio']:focus{
	box-shadow:unset;
}
#formPenilaian .roundIt{width:100%;}
/* .form-group{margin-bottom:unset;} */

@media (max-width: 992px){
	
	
	.LabelPoin{display: block;}
	.LabelPK{display: block;}

	.divhead{display: none;}
	#returnValSK .tdisi,#returnValPK .tdisi{padding-left: 35% !important;margin-bottom: 24px; margin-top: 20px;font-size: 14px;}
	.tdisi:before{font-weight: unset;position: absolute;width: 40%;left: 30px;}
	.trdiv:nth-child(even){background-color: #f5f5f5;}
	.col-md-1-5{padding-left:15px !important;margin-bottom: 24px; margin-top: 20px;text-align: center;}
	.col-md-1-5:before{font-weight: unset;position: absolute;width: 40%;left: 30px;}
	.column1:nth-child(1):before{content: "No";color: #999999;font-weight: 700;}
	.column2:nth-child(2):before{content: "";color: #999999;font-weight: 700;}
	.column3:nth-child(3):before{content: "Pertanyaan";color: #999999;font-weight: 700;}
	.column4:nth-child(4):before{content: "Bobot";color: #999999;font-weight: 700;}
	.column5:nth-child(5):before{content: "Pertanyaan";color: #999999;font-weight: 700;}
	.column6:nth-child(6):before{content: "Indikator";color: #999999;font-weight: 700;}
	.column7:nth-child(7):before{content: "Target";color: #999999;font-weight: 700;}
	.column8:nth-child(8):before{content: "Bobot";color: #999999;font-weight: 700;}

	.col-md-5{background-color: lightblue;border-radius: 10px; margin: 10px !important;background: -webkit-linear-gradient(45deg, cornsilk, Bisque);box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);}
	
	.col-total{float:left;width:50%;}
	.col-total-text{float:left;}
	/*.panel-body {width: 100%;background: cornsilk;background: -webkit-linear-gradient(45deg, cornsilk, lightblue);background: -o-linear-gradient(45deg, cornsilk, lightblue);background: -moz-linear-gradient(45deg, cornsilk, lightblue);background: linear-gradient(45deg, cornsilk, lightblue);padding: 33px 30px !important;	}*/
	
}
.col-xs-6{width: 20% !important;}
.col-xs-2{width: 16.66666667%;text-align: center;}

@media (min-width: 992px) {
	.col-md-2-5 { width: 40%; }
	.col-md-3-5 { width: 60%; }
	.col-md-4-5 { width: 80%; }
	.col-md-5-5 { width: 100%; }
}
@media (min-width: 1200px) {
	#formPenilaian .roundIt {color:black;}
	.col-md-12.trdiv:hover {
		/* background: linear-gradient(314.65deg, DarkGreen -0.61%, DarkSlateGrey 100%); */
		background-image: linear-gradient(to right, #25aae1, #4481eb, #04befe, #3f86ed) !important;
		/* font-weight: 500; */
		color: white;
	}
	.col-lg-1-5 { width: 20%; }
	.col-lg-2-5 { width: 40%; }
	.col-lg-3-5 { width: 60%; }
	.col-lg-4-5 { width: 80%; }
	.col-lg-5-5 { width: 100%; }
}
@media (min-width: 768px) {
	.col-sm-1-5 { width: 20%; }
	.col-sm-2-5 { width: 40%; }
	.col-sm-3-5 { width: 60%; }
	.col-sm-4-5 { width: 80%; }
	.col-sm-5-5 { width: 100%;}
	
}


</style>
<div class="row">
	<blockquote>FORM PERFORMANCE APPRAISAL</blockquote>
</div>
<div class=''>
<form id="form1" name="form1" method="POST">
<div class="row">
	<div class="col-md-12">
		<div class="">
			
		<span>	 <h4>Periode Penilaian :</span> </h4> <h4><span class="label label-primary" id='txtPeriode'></span></h4><hr>
		</div>
	</div>
	<div class="col-md-12">
		<div class="">
			<div class="col-md-4">
				<div class="row">
					<input type="hidden" name="periode" class='form-control'id='periode' style="display:none" readonly>
					<input type="hidden" name="iduser" id="iduser">
					<input type="hidden" name="nikuser" id="nikuser">
					<input type="hidden" name="namauser" id="namauser">
					<input type="hidden" name="tgllahiruser" id="tgllahiruser">
					<input type="hidden" name="idkry" id="idkry">
					<input type="hidden" name="nikkry" id="nikkry">
					<input type="hidden" name="namakry" id="namakry">
					<input type="hidden" name="tgllahirkry" id="tgllahirkry">
					<h4><i class="fa fa-user"></i> DAFTAR KARYAWAN YANG AKAN DINILAI</h4>
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
					<p class="text-danger"><em>*Pilih karyawan yang akan dinilai dengan klik nama karyawan yang ada di atas</em></p>
				</div>
			</div>
			<div class="col-md-1">
			</div>
			<div class="col-md-6" id="detailSoal">
				<div class="row">
					<div class=''>
						<h4><i class="fa fa-th" aria-hidden="true"></i> DETAIL KARYAWAN </h4>
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
					</div>
					
						
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class=""><hr>
			<div class="panel-group" id="formPenilaian">
				
			</div>
		</div>
	</div>
</div>
</form>
</div>