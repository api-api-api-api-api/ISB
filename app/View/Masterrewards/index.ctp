<?php
     echo $this->Html->script('h1masterreward.js');
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
    .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {width: 49%;color:black;height:20px;}
   
    /* End Select Pure Auto complate */
.pagination{margin:0;}
</style>
<div class="row">
    <blockquote>MASTER REWARD</blockquote>
</div>
<div class="row">
    <hr>
    <div class='col-md-8'>
        <div class="row">
            <div class="form-group"><label class="control-label"> <i class="fa fa-search fa-fw"></i> FILTER BY:  </label></div>
                <div class="form-group" style="display:none">
                    <input type="text" name="txtNamaMastermarketplacefilter" id="txtNamaMastermarketplacefilter" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="Nama Marketplace" onkeyup="if(event.keyCode === 13){getData(1)}">
                </div>
                <div class="form-group">
                    <input type="text" name="txtNamaMasterrewardfilter" id="txtNamaMasterrewardfilter" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="Nama Reward" onkeyup="if(event.keyCode === 13){getData(1)}"></div>
                <div class="form-group">
                    <select name="txtStatus" id="txtStatus" class="form-control" onchange="getData(1)" style="width:250px;margin-bottom:0;font-size:11px;">
                        <option value="" selected="selected">Pilih Status</option>
                        <option value="true">Aktif</option>
                        <option value="false">Tidak Aktif</option>
                    </select>
                </div>
                <button type="button"class='btn btn-default btn-sm' style="margin-bottom:0" onclick='getData(1)'> <i class="fa fa-search fa-fw"></i> CARI</button><hr>  
            <button type="button" class='btn btn-default btn-sm' id="btnAdd"><i class="fa fa-plus-circle"> </i> TAMBAH REWARD</button>
            <hr>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading" >
                    <div class="row">
                        <div class="col-md-6"><label class="control-label"><i class="fa fa-th-list fa-fw"></i> RECORD DATA REWARD</label></div>
                    </div>
                </div>
                <div class="panel-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;" >
                    <div class="row">
                        <table  id='tableMasterreward' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;margin-bottom:0;"> 
                            <thead>
                                <tr class="active">
                                    <th width="2%" style="text-align:center;vertical-align:middle">No</th> 
                                    <th width="5%" style="text-align:center;vertical-align:middle">Edit</th>
                                    <th width="70%" style="text-align:left;vertical-align:middle">Nama Reward</th>
                                    <th width="15%" style="text-align:left;vertical-align:middle">Jenis Saldo</th>
                                    <th width="8%" style="text-align:center;vertical-align:middle">Status</th>                  
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
    <div class="col-md-4">
        <div class="">
            <div class="panel panel-default">
                <div class="panel-body">
                    <dl>
                        <dt>Keterangan</dt>
                        <dd>Klik tombol <button type="button" class='btn btn-default btn-sm'><i class="fa fa-plus-circle"> </i> TAMBAH REWARD</button> untuk melakukan penambahan data</dd>
                        <dd>Klik tombol <button type='button' class='btn btn-xs btn-default'><i class='fa fa-edit fa-lg' style='margin: 5px 5px;'></i></button> untuk melakukan perubahan nama dan/atau status Reward</dd>
                    </dl>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    
</div>
<!-- Modal Form -->
    <div class="modal fade"  id="modalFormMasterreward" role="dialog" aria-labelledby="modalFormMasterreward" style="margin-top: 2%;outline: 0;">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 6px;min-height: unset;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()"><span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span></button>
                    <h4 class="modal-title" id="myModalLabel">FORM</h4>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <form name="maintenanceForm" id="maintenanceForm">
                    <div class="row">
                    <!-- col-md-offset-1 -->
                        <div class="col-md-12 ">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                <input type="hidden" name="rewardID" id="rewardID">
                                    <!-- <p class="bg-info" style="padding: 15px;font-weight:bold;font-size:14px;" id="txtNoteReturn">test</p> -->
                                    <div class="form-horizontal">
                                        <div class="col-md-12">
                                            <div class="form-group" style="display:none">
                                                <label class="col-md-4 control-label">PILIH MARKETPLACE</label>
                                                <div class="col-md-8"> 
                                                    <input id="nmMarketplace" name="nmMarketplace" class="form-control" type="hidden" style="min-width:200px;">
                                                    <span class="autocomplete-select" id="txtMarketplace"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">NAMA REWARD</label>
                                                <div class="col-md-8"><input class="form-control" type="text" id="namaReward" name="namaReward"  style="min-width:200px;"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">JENIS SALDO</label>
                                                <div class="col-md-8">
                                                    <select name="txtJenisSaldo" id="txtJenisSaldo" class="form-control" style="min-width:200px;font-size:11px;">
                                                        <option value="" selected="selected">Pilih Jenis Saldo</option>
                                                        <option value="single">Singgle</option>
                                                        <option value="akumulatif">Akumulatif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <label class="col-md-4 control-label">STATUS</label>
                                                <div class="col-md-8"> 
                                                    <div class="">
                                                        <label>
                                                            <input type="radio" name="status" id="optionsRadios1" value="true">Aktif
                                                        </label>
                                                    </div>
                                                    <div class="">
                                                        <label>
                                                            <input type="radio" name="status" id="optionsRadios2" value="false">Tidak Aktif
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div class="form-horizontal">
                                        
                                    </div>
                                </div>
                                <div class='panel-footer'>
                                    <button type="button" class="btn btn-block btn-lg btn-default" id="buttonSave" ><i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE</button>  
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