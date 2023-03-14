<?php
    echo $this->Html->script('h1pahasilpenilaian.js');
    echo $this->Html->script('bundle.min.js');       
?>

<style>
 /* Select Pure Auto complate */
    .select-wrapper {margin: auto; max-width: 500px;width: calc(100% - 40px);}
    .select-pure__select {align-items: center;border-radius: 0;border: 1px solid #ccc;box-sizing: border-box;color: #363b3e;cursor: pointer; display: flex;font-size: 16px;font-weight: 500;justify-content: left;min-height: 34px;padding: 5px 10px; position: relative;transition: 0.2s; width: 100%;}
    .select-pure__options {  border-radius: 4px;border: 1px solid rgba(0, 0, 0, 0.15);box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04); box-sizing: border-box;color: #363b3e; display: none; left: 0; max-height: 221px;
    overflow-y: scroll; position: absolute; top: 35px; width: 100%; z-index: 5;}
    .select-pure__select--opened .select-pure__options { display: block;}
    .select-pure__option { background: #fff; border-bottom: 1px solid #e4e4e4; box-sizing: border-box;/* height: 44px;*/ line-height: 20px; padding: 10px;}
    .select-pure__option--selected { color: #e4e4e4; cursor: initial; pointer-events: none;}
    .select-pure__option--hidden { display: none;}
    .select-pure__selected-label {background: #5e6264;border-radius: 4px;color: #fff;cursor: initial;display: inline-block; margin: 5px 10px 5px 0;padding: 3px 7px;}
    .select-pure__selected-label:last-of-type { margin-right: 0;}
    .select-pure__selected-label i {cursor: pointer;display: inline-block; margin-left: 7px;}
    .select-pure__selected-label i:hover {  color: #e4e4e4;}
    .select-pure__autocomplete {background: #faebcc; border-bottom: 1px solid #e4e4e4;border-left: none; border-right: none;border-top: none; box-sizing: border-box;font-size: 16px;outline: none;padding: 10px; width: 100%; margin-bottom:0 !important}

    @media only screen and (min-width: 650px) {
        #modalDetailPenilaian {
            width: 70%;
            margin-left:15%;
            margin-top:2%;
            margin-bottom:2%;
        }
    }
    .modal-body{height: 90%;}
    /* End Select Pure Auto complate */
</style>
<blockquote>REPORT PENILAIAN</blockquote>
<hr>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <form name="formkartunama" id="formkartunama">
                <div class="row">
                    <div class="col-md-12">
                
                    <div class="row">
                        <div class="form-horizontal">
                            <!--
                             <div class="panel panel-primary">
                              <div class="panel-heading">Panel with panel-default class</div>
                              <div class="panel-body">Panel Content</div>
                            </div>
                            -->
                            <?php if(!empty($this->Session->read('dpfdpl_groupId'))){
                                if($this->Session->read('dpfdpl_groupId')=='37'){$tampilFilter="Style='display:block'";}else{$tampilFilter="style='display:none;'";} 
                                ?>
                                <input type="hidden" nama='userTampil' id='userTampil' value=''>
                            <?php }else{
                                $tampilFilter="style='display:none;'";  ?>
                                <input type="hidden" nama='userTampil' id='userTampil' value=''>
                           <?php }?>
                            <table width="100%" <?php echo $tampilFilter;?>>
                            
                                <tr>
                                     <td width="40%">Filter Periode:
                                           <select class="form-control" id="pilihperiode" onchange="getdata(1)">
                                
                                          </select>
                                    </td>
                                    <td width="5%">
                                         
                                    </td>
                                    <td width="20%"><font>Filter Divisi:</font>
                                       <span class="autocomplete-select" id="filterdivisi" ></span> 
                                       <input type="hidden" id="txtfilterdivisi">
                                    </td>   
                                        <td width="5%">
                                         
                                    </td>

                                    <td width="40%"><font>Filter Nama Karyawan:</font>
                                       <span class="autocomplete-select" id="filternamakry" ></span> 
                                       <input type="hidden" id="txtfilternamakry">
                                    </td>   
                               
                                    <td>
                                        <button  type="button" class="btn btn-primary" id="" onclick="savedata()" style="display: none">
                                    <i class="fa  fa-floppy-o fa-fw" aria-hidden="true"></i> CARI</button>
                                    </td>
                                </tr>
                            </table>
                           

                
                            <table class="table" >
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Periode</th>
                                    <th>Nik-Nama Karyawan</th>
                                    <th>Jabatan</th>
                                    <th>Penilai</th>
                                    <th>Hasil Nilai</th>
                                    <th>Score</th>
                                    <th>Detail</th>
                                    <th></th>
                                    <th style="display: none">Status</th>
                                   <!-- <th>Aksi</th> -->
                                  </tr>
                                </thead>
                                <tbody id="tblhasil">
                                 

                                </tbody>
                            </table>
                            <button type="button" class="btn btn-danger" onclick="cetakpdf('')"><i class='fa fa fa-file-pdf-o' aria-hidden='true'></i> Cetak Semua PDF </button>
                            <div id="linkHal"></div>

                        </div>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal tampil detail -->

<div class="modal fade" id="modalDetailPenilaian" role="dialog" aria-labelledby="modalDetailPenilaian" >
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="border-radius: 6px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span>
				</button>
				<h4 class="modal-title">DETAIL PENILAIAN </h4>
			</div>
			<div class="modal-body" style="overflow-y:auto;">
            <div class="col-md-12" id="detailSoal">
				<div class="row">
					<div class=''>
						
						<div class="panel panel-primary">
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
										<!-- <div class="form-group" style="margin-bottom:0">
											<label for="txtNik" class="col-sm-6 control-label">Status</label>
											<div class="col-sm-6">
												<p class="form-control-static" id='txtStatus'></p>
											</div>
										</div> -->
									</div>
								</div>
							</div>
							
						</div>
						
					</div>
						<div class="panel-group" id="detailPenilaian" role="tablist" aria-multiselectable="true">
						
						</div>
				</div>
			</div>
			</div>
			
		</div>
	</div>
</div>
