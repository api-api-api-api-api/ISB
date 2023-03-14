<?php
    echo $this->Html->script('h1maintenancegroupuser.js');
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
<blockquote>MAINTENANCE GROUP USER</blockquote>

<div class="row">
        <div class="col-md-5">
           
                <div class="form-group"><label class="control-label"> <i class="fa fa-search fa-fw"></i> Cari Data:  </label></div>
                <div class="row">
                
                    <div class="col-md-8">
                        <div  class="form-inline" style="margin-bottom:12px;">
                            <div class="form-group">
                                <input type="text" name="txtNamaGroup" id="txtNamaGroup" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="Cari Group" onkeyup="if(event.keyCode === 13){getData(1)}">
                            </div>
                            <button type="button"class='btn btn-default' style="margin-bottom:0" onclick='getData(1)'> <i class="fa fa-search fa-fw"></i> CARI</button>
                        </div>
                    </div>
                    <div class="col-md-4 col-md-offset-0 text-right">
                        
                    </div>
                
                </div>
                <div class="col-md-12">
                    <div class="row">
                    <div class="panel panel-default" >
                        <div class="panel-heading" >
                            <div class="row">
                                <div class="col-md-12">
                                <label class="control-label"><i class="fa fa-th-list fa-fw"></i>DATA GROUP</label>
                                <div class="input-group">
                                        <input type="text" id="txtInputGroup" class="form-control"  placeholder="Input Nama Group" style="font-size:12px;">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default addGroup" type="button"><i class="fa fa-plus-circle" aria-hidden="true"> </i> ADD GROUP</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;" >
                            <div class="row">
                                <table  id='tableMasterGroup' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;margin-bottom:0;"> 
                                    <thead>
                                        <tr class="active">
                                            <th width="3%" style="text-align:center;vertical-align:middle">No</th> 
                                            <th width="50%"  style="vertical-align:middle">Nama Group</th>                  
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

