<?php
    echo $this->Html->script('h1maintenancetelegramstok.js');
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
<h2>MAINTENANCE TELEGRAM STOK</h2><hr>
<form name="maintenancetelestokReport" id="maintenancetelestokReport" method="post">
    <div class="panel panel-primary" style="max-width: 40rem;border-color: #696969;">
        <div class="panel-heading" style="background-color:#696969;color:#fff;border-color: #696969;">FILTER PENCARIAN DATA:</div>
        <div class="panel-body" >
            <table width="100%">
                <tr><td>NAMA</td><td>:</td><td><input class="form-control form-control-sm" name="filterNama" id="filterNama" onkeyup="convertToUpperCase(this)"  type="text" ></td></tr>
                <tr><td>DEPARTEMEN</td><td>:</td><td><input class="form-control form-control-sm" name="filterDepartemen"  id="filterDepartemen" type="text" ></td></tr>
                <tr><td>TELEGRAM ID</td><td>:</td><td><input class="form-control form-control-sm" name="filterTeleID"  id="filterTeleID" onkeypress='return hanyaAngka(event)' type="text" ></td></tr>
                <tr><td>STATUS</td><td>:</td><td>
                        <select name="filterStatus" id="filterStatus" class="form-control" onchange="getData(1)">
                            <option value="" selected>- SET PILIHAN AKTIF -</option>
                            <option value="true">Aktif</option>
                            <option value="false">Tidak Aktif</option>
                        </select></td></tr>
            </table>
            
        </div>
        <div class="panel-footer"><button type="button" class="btn btn-info" id="btnSrch"><i class="fa fa-search" aria-hidden="true"></i> Cari</button></div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading" >
                    <div class="row">
                        <div class="col-md-2"><label class="control-label"><i class="fa fa-th-list fa-fw"></i> RECORD</label></div>
                        <div class="col-md-10 col-md-offset-0 text-right"><button type="button" class='btn btn-danger btn-sm'  id="btnForm"><i class="fa fa-plus-circle"> </i> TAMBAH DATA</button></div>
                    </div>
                </div>
                <div class="panel-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;" >
                    <div class="row">
                        <table  id='tableMaintenancetelegramstok' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;margin-bottom:0;"> 
                            <thead>
                                <tr class="active">
                                    <th width="2%" style="text-align:center;vertical-align:middle">NO</th> 
                                    <th width="20%" style="text-align:center;vertical-align:middle">NAMA</th>
                                    <th width="25%" style="text-align:center;vertical-align:middle">DEPARTEMEN</th>
                                    <th width="12%" style="text-align:center;vertical-align:middle">TELEGRAM ID</th>
                                    <th width="12%" style="text-align:center;vertical-align:middle">STATUS AKTIF</th>
                                    <th width="18%" style="text-align:center;vertical-align:middle"><i class="fa fa-pencil-square fa-lg" aria-hidden="true"></i></th>
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
    </div>
</form>
<!-- MODAL ADD DATA -->
<div class="modal fade"  id="modalMaintenaceTelegramstoks" role="dialog" aria-labelledby="modalMaintenaceTelegramstoks">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 6px;min-height: unset;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()"><span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span></button>
                    <h4 class="modal-title" id="myModalLabel">FORM INPUT</h4>
                </div>
                <div class="modal-body">
                    <form name="maintenanceTSForm" id="maintenanceTSForm">
                    <input type="hidden" name="idTelegramStok" id="idTelegramStok">
                    <div class="row">
                    <!-- col-md-offset-1 -->
                        <div class="col-md-12 ">
                            <div class="panel panel-default" style="min-width:500px;">
                                <div class="panel-body">
                                <div class="col-md-8"><input type="hidden" name="crud" id="crud"></div>
                                    <!-- <p class="bg-info" style="padding: 15px;font-weight:bold;font-size:14px;" id="txtNoteReturn">test</p> -->
                                    <div class="form-horizontal">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">NAMA</label>
                                                <div class="col-md-8"><input type="text" class="form-control" name="nama" id="nama" onkeyup="convertToUpperCase(this)" style="min-width:200px;"></div>
                                            </div>     
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">DEPARTEMEN</label>
                                                <div class="col-md-8">
                                                    <span class="autocomplete-select" id="txtDepartemen" style="min-width:200px;width:50%"></span>
                                                    <input type="hidden" id="divisiDipilih" name="divisiDipilih">
                                                    <!-- <input class="form-control" type="text" id="departemen" name="departemen"  style="min-width:200px;"> -->
                                                </div>
                                            </div>                                                                                      
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">TELEGRAM ID</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="telegramID" name="telegramID" onkeypress='return hanyaAngka(event)' style="min-width:200px;">
                                                    <span  class="text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 control-label"></label>
                                                <div class="col-sm-8">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="status" class="custom-control-input" id="status">
                                                        <label class="custom-control-label" for="status"> aktifkan <i class="fa fa-check-square" aria-hidden="true"></i> jika aktif</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class='panel-footer'>
                                    <button type="button" class="btn btn-block btn-lg btn-default" id="btnSimpan" ><i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE DATA</button>  
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </form>       
                </div>
                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeModal()"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
                </div>
            </div>
        </div>
    </div>