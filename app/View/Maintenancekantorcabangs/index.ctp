<?php
    echo $this->Html->script('h1maintenancekantorcabang.js');
    //echo $this->Html->script('bundle.min.js');       
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

    .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {width: 49%;color:black;height:20px;}
   
    /* End Select Pure Auto complate */
</style>
<div class="row">
    <blockquote>MAINTENANCE KANTOR CABANG</blockquote>
    <div class="form-group"><label class="control-label"> <i class="fa fa-search fa-fw"></i> FILTER BY:  </label></div>
    <div class="col-md-2">
        <div class="row">
        
            <div>
                
                <div class="form-group">
                    <input type="text" name="txtNamaCabangFilter" id="txtNamaCabangFilter" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="Nama Cabang" onkeyup="if(event.keyCode === 13){getData(1)}"></div>
                <div class="form-group">
                    <input type="text" name="txtAlamatCabangFilter" id="txtAlamatCabangFilter" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="Alamat Cabang" onkeyup="if(event.keyCode === 13){getData(1)}"></div>
                <div class="form-group">
                    <input type="text" name="txtKotaCabangFilter" id="txtKotaCabangFilter" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="Kota Cabang" onkeyup="if(event.keyCode === 13){getData(1)}"></div>
                <div class="form-group">
                    <input type="text" name="txtKodeFilter" id="txtKodeFilter" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="Kode" onkeyup="if(event.keyCode === 13){getData(1)}"></div>
                <div class="form-group">
                    <input type="text" name="txtKontakFilter" id="txtKontakFilter" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="Contact Person" onkeyup="if(event.keyCode === 13){getData(1)}"></div>
                    <button type="button"class='btn btn-default btn-sm' style="margin-bottom:0" onclick='getData(1)'> <i class="fa fa-search fa-fw"></i> CARI</button>
            </div>
        </div>
    </div> 
</div>
<div class="row">
    <hr>
    <div class="col-md-8">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading" >
                <div class="row">
                    <div class="col-md-2"><label class="control-label"><i class="fa fa-th-list fa-fw"></i> RECORD</label></div>
                    <div class="col-md-10 col-md-offset-0 text-right"><button type="button" class='btn btn-danger btn-sm'  id="btnForm"><i class="fa fa-plus-circle"> </i> ADD CABANG</button></div>
                </div>
            </div>
            <div class="panel-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;" >
                <div class="row">
                    <table  id='tableMaintenanceCabang' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;margin-bottom:0;"> 
                        <thead>
                            <tr class="active">
                                <th width="2%" style="text-align:center;vertical-align:middle">No</th> 
                                <th width="12%" style="text-align:center;vertical-align:middle">Nama Cabang</th>
                                <th width="12%" style="text-align:center;vertical-align:middle">Alamat</th>
                                <th width="12%" style="text-align:center;vertical-align:middle">Kota</th>
                                <th width="12%" style="text-align:center;vertical-align:middle">Kode Cabang</th>
                                <th width="8%" style="text-align:center;vertical-align:middle">Contact Person</th>
                                <th width="8%" style="text-align:center;vertical-align:middle">Kantor Cabang ID</th>
                                <th width="4%" style="text-align:center;vertical-align:middle">EDIT DATA</th>
                            </tr>
                        </thead> 
                        <tbody>
                            <tr>
                                <td colspan="13" style="text-align:center; background-color:#fff !important;"><div class="alert alert-success" role="alert" style="margin-bottom: 0;"><strong>Data Kosong</strong></div></td>
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

<!-- Modal Form -->
<div class="modal fade"  id="modalFormMaintenanceKantorCabang" role="dialog" aria-labelledby="modalFormMaintenanceKantorCabang" style="max-width: 40%; max-height: 91%; margin-left: 30%; margin-top: 2%;outline: 0;">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 6px;min-height: unset;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()"><span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span></button>
                    <h4 class="modal-title" id="myModalLabel">FORM CABANG</h4>
                </div>
                <div class="modal-body" style="height: 700px;max-height: 700px;overflow-y:auto;">
                    <form name="maintenanceForm" id="maintenanceForm">
                    <div class="row">
                    <!-- col-md-offset-1 -->
                        <div class="col-md-12 ">
                            <div class="panel panel-default" style="min-width:500px;">
                                <div class="panel-body">
                                <div class="col-md-8"><input type="hidden" name="crud" id="crud"></div>
                                    <!-- <p class="bg-info" style="padding: 15px;font-weight:bold;font-size:14px;" id="txtNoteReturn">test</p> -->
                                    <div class="form-horizontal">
                                        <div class="col-md-12">
                                            <div class="form-group" style="display:none;">
                                                <label class="col-md-4 control-label">NOMOR CABANG</label>
                                                <div class="col-md-8"><input type="text" class="form-control" name="idCabang" id="idCabang" style="min-width:200px;">
                                                <span class='form-control' id='txtnoCabangSet' style="display:none" readonly></span></div>
                                            </div>     
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">NAMA CABANG</label>
                                                <div class="col-md-8"><input class="form-control" type="text" id="namaCabang" name="namaCabang"  style="min-width:200px;"></div>
                                            </div>                                           
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">ALAMAT</label>
                                                <div class="col-md-8"> <input class="form-control" type="text" id="alamat" name="alamat" style="min-width:200px;"></div>
                                            </div>
                                           
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">KOTA</label>
                                                <div class="col-md-8"><input type="text" class="form-control" id="kota" name="kota" style="min-width:200px;"></div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">KODE CABANG</label>
                                                <div class="col-md-8"><input class="form-control" type="text" id="kodeCabang" name="kodeCabang" style="min-width:200px;"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">CONTACT PERSON</label>
                                                <div class="col-md-8"><input class="form-control" type="text" id="kontakPerson" name="kontakPerson" style="min-width:200px;"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">KANTOR CABANG ID</label>
                                                <div class="col-md-8"><input class="form-control" type="text" id="kantorCabangId" name="kantorCabangId" style="min-width:200px;">
                                                <span class='form-control' id='txtkantorCabangId' style="display:none" readonly></span></div>

                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class='panel-footer'>
                                    <button type="button" class="btn btn-block btn-lg btn-default" id="buttonSave" ><i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE CABANG</button>  
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