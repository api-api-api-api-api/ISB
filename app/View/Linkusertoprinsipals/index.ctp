<?php
    echo $this->Html->script('h1linkusertoprinsipal.js');
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
    /* End Select Pure Auto complate */
</style>
<blockquote>MAINTENANCE LINK USER TO PRINCIPAL</blockquote>

<div class="row">
        <div class="col-md-6">
           
                <div class="form-group"><label class="control-label"> <i class="fa fa-search fa-fw"></i> Cari Data:  </label></div>
                <div class="row">
                <form name="formlinkusertoprincipal" id="formlinkusertoprincipal">
                    <div class="col-md-8">

                        <div  class="form-inline">
                            <div class="form-group">
                                <input type="text" name="txtNamaPenanggungaJawab" id="txtNamaPenanggungaJawab" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="Penanggung Jawab" onkeyup="if(event.keyCode === 13){getData(1)}">
                            </div>
                            <button type="button"class='btn btn-default' style="margin-bottom:0" onclick='getData(1)'> <i class="fa fa-search fa-fw"></i> CARI</button>
                        </div>
                    </div>
                    <div class="col-md-4 col-md-offset-0 text-right">
                        <div class="form-group">
                            <button type="button" id="btnADD" class="btn  btn-danger"><i class="fa fa-plus-circle fa-fw" aria-hidden="true"></i> ADD DATA</button>	
                        </div>
                    </div>
                </form>
                </div>
                <div class="col-md-12">
                    <div class="row">
                    <div class="panel panel-default" >
                        <div class="panel-heading" >
                            <div class="row">
                                <div class="col-md-4"><label class="control-label"><i class="fa fa-th-list fa-fw"></i>RECORD DATA</label></div>
                                <div class="col-md-8"></div>
                            </div>
                        </div>
                        <div class="panel-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;" >
                            <div class="row">
                                <table  id='tablePrincipal' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;margin-bottom:0;"> 
                                    <thead>
                                        <tr class="active">
                                            <th width="3%" style="text-align:center;vertical-align:middle">No</th> 
                                            <th width="25%"  style="vertical-align:middle">Penanggung Jawab</th>
                                            <th width="25%" style="vertical-align:middle">Principal</th>                  
                                            <th width="12%" style="text-align:center;vertical-align:middle">Action</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        <tr>
                                            <td colspan="5" style="text-align:center; background-color:#fff !important;"><div class="alert alert-success" role="alert" style="margin-bottom: 0;"><strong>Data Kosong</strong></div></td>
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
</div>

<div class="modal fade" id="modalCRUD" role="dialog" aria-labelledby="modalCRUD" style="max-width: 30%; max-height: 91%; margin-left: 35%; margin-top: 2%;outline: 0;">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 6px;min-height: unset;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeUncheck()"><span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" style="height: 350px;max-height: 350px;overflow-y:auto;">
                    <div class="form-horizontal">
                        <input type="hidden" id="txtIdPrincipal" name="txtIdPrincipal" >
                        <div class="form-group">
                            <label class="col-md-4 control-label">Penanggung Jawab</label>
                            <div class="col-md-8">
                                <div class="input-group"><span class="input-group-addon"><i class="fa fa-users" aria-hidden="true"></i></span>
                                    <input id="txtUserID" name="txtUserID" class="form-control" required="true" type="hidden">
                                    <span class="autocomplete-select" id="autocompleteUser"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Pilih Principal</label>
                            <div class="col-md-8">
                                <div class="input-group"><span class="input-group-addon"><i  class="fa fa-list" aria-hidden="true"></i></span>
                                    <select name="txtPrincipal" id="txtPrincipal" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <label class="col-md-4 control-label"></label>
                        <div class="col-md-8">
                        <button style="font-family:Arial !important;font-size:16px; font-weight:500;" type="button" class="btn btn-block btn-default " id="tmblCRUD" onclick="saveCURD()"><i class="fa  fa-floppy-o fa-fw" aria-hidden="true"></i> SAVE DATA</button></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeUncheck()"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
                </div>
            </div>
        </div>
    </div>