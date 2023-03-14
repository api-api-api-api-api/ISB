<?php
    echo $this->Html->script('h1maintenancenametagkaryawan.js');
    echo $this->Html->script('bundle.min.js');       
?>

<style type="text/css">
    /* Select Pure Auto complate */
.select-wrapper {margin: auto; max-width: 500px;width: calc(100% - 40px);}
.select-pure__select {align-items: center;border-radius: 4px;border: 1px solid #ccc;box-sizing: border-box;color: #363b3e;
  cursor: pointer; display: flex;font-size: 16px;font-weight: 500;justify-content: left;min-height: 44px;padding: 5px 10px; position: relative;transition: 0.2s; width: 100%;}
.select-pure__options {  border-radius: 4px;border: 1px solid rgba(0, 0, 0, 0.15);box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04); box-sizing: border-box;color: #363b3e; display: none; left: 0; max-height: 221px;
  overflow-y: scroll; position: absolute; top: 50px; width: 100%; z-index: 5;}
.select-pure__select--opened .select-pure__options { display: block;}
.select-pure__option { background: #fff; border-bottom: 1px solid #e4e4e4; box-sizing: border-box;/* height: 44px;*/ line-height: 20px; padding: 10px;}
.select-pure__option--selected { color: #e4e4e4; cursor: initial; pointer-events: none;}
.select-pure__option--hidden { display: none;}
.select-pure__selected-label {background: #5e6264;border-radius: 4px;color: #fff;cursor: initial;display: inline-block; margin: 5px 10px 5px 0;padding: 3px 7px;}
.select-pure__selected-label:last-of-type { margin-right: 0;}
.select-pure__selected-label i {cursor: pointer;display: inline-block; margin-left: 7px;}
.select-pure__selected-label i:hover {  color: #e4e4e4;}
.select-pure__autocomplete {background: #f9f9f8; border-bottom: 1px solid #e4e4e4;border-left: none; border-right: none;border-top: none; box-sizing: border-box;font-size: 16px;outline: none;padding: 10px; width: 100%; margin-bottom:0 !important}
</style>

<h2>MAINTENANCE CETAK NAMETAG KARYAWAN</h2><hr>
<form name="formcetaknametagkaryawan" id="formcetaknametagkaryawan" method="post">
    <div class="panel panel-primary" style="max-width: 40rem;border-color: #696969;">
        <div class="panel-heading" style="background-color:#696969;color:#fff;border-color: #696969;">FILTER PENCARIAN DATA:</div>
        <div class="panel-body" >
            <table width="100%">
                <tr><td>TAHUN</td><td>:</td><td><select name="filterTahun" id="filterTahun" class="form-control" onchange="getData(1)"  style='font-size:11px !important;margin-bottom: 0;'>
                                <option value="" selected="selected">All</option>
                                <?php
                                    for ($t=date("Y")-5;$t<=date("Y")+10;$t++){
                                    if($t==date("Y")){
                                            echo "<option value=$t >$t</option>\n";
                                            }
                                        else{echo "<option value=$t>$t</option>\n";}
                                    }
                                ?>
                                </select>
                            </td></tr>
                <tr><td>NAMA</td><td>:</td><td><input class="form-control form-control-sm" name="filterNama"  id="filterNama" onkeyup="convertToUpperCase(this)"  type="text" ></td></tr>
                <tr><td>Tampilkan data per</td><td>:</td><td>
                	<select name="filterLimit" id="filterLimit" class="form-control" onchange="getData(1)"  style='font-size:11px !important;margin-bottom: 0;'>
                              <option value="" selected="selected">UNSET</option>
			                	<?php
					                		for ($i= 1; $i <= 100; $i++) { 
										if ( $i % 10 == 0 ) {
										
											echo  "<option value='".$i."'>$i</option>";
										}
									}
					              ?>
		              	<option value="ALL" >TAMPILKAN SEMUA</option>
                </td></tr>
                
            </table>
            
        </div>
        <div class="panel-footer"><button type="button" class="btn btn-info" id="btnSrch"><i class="fa fa-search" aria-hidden="true"></i> Cari</button></div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading" >
                    <div class="row">
                        <div class="col-md-2"><label class="control-label"><i class="fa fa-th-list fa-fw"></i> RECORD</label></div>
                        <div class="col-md-10 col-md-offset-0 text-right"></div>
                    </div>
                </div>
                <div class="panel-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;" >
                    <div class="row">
                        <table  id='tableMaintenancetelegramstok' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;margin-bottom:0;"> 
                            <thead>
                                <tr class="active">
                                    <th width="2%" style="text-align:center;vertical-align:middle">NO</th> 
                                    <th width="2%" style="text-align:center;vertical-align:middle"><input type="checkbox" name="elementID" id="elementID"></th>
                                    <th width="10%" style="text-align:left;vertical-align:middle">NIK</th>
                                    <th width="25%" style="text-align:center;vertical-align:middle">NAMA</th>
                                    <th width="15%" style="text-align:center;vertical-align:middle">DEPARTEMEN</th>
                                    <th width="15%" style="text-align:center;vertical-align:middle">DIVISI</th>
                                    <th width="15%" style="text-align:center;vertical-align:middle">JABATAN</th>
                                    <th width="15%" style="text-align:center;vertical-align:middle">AREA</th>
                                </tr>
                            </thead> 
                            <tbody>
                                <tr>
                                    <td colspan="13" style="text-align:center;"><div><strong>Data Kosong</strong></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                    <nav aria-label="Page navigation example " id="linkHal1" style="display:block">...</nav>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-danger btn-sm btnCetak"><i class="fa fa-print fa-lg"></i> CETAK</button>
</form>
<form id="frmCetak" name="frmCetak" method="post">
<input type="hidden" id="pilihHidden" name="pilihHidden">
<input type="hidden" id="idpilihHidden" name="idpilihHidden">
</form>


