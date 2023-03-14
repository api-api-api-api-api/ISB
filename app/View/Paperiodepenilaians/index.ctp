<?php
    echo $this->Html->script('h1paperiodepenilaian.js');
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
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<blockquote>PERIODE PENILAIAN</blockquote>
<hr>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <form name="formkartunama" id="formkartunama">
                <div class="row">
                    <div class="col-md-9">
                   
                    
                    <div class="row">
                        <div class="form-horizontal">
                        <div class="alert alert-info" role="alert"><h5 style='margin:0'>form input Periode Penilaian:</h5></div>
                            
                            <div class="form-group">
                                 <label class="col-md-2 control-label">Nama Periode</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="namaperiode" name="">
                                    <br>
                                </div>
                                
                                <label class="col-md-2 control-label">Periode Start *</label>
                                <div class="col-md-3">
                                    <input type="date" class="form-control" id="tglstart" name="">
                                </div>
                                <label class="col-md-2 control-label">Periode End *</label>
                                <div class="col-md-3 ">
                                    <input type="date" class="form-control" id="tglend" name="">
                                   
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-8">
                                <button  type="button" class="btn btn-primary" id="" onclick="savedata()">
                                    <i class="fa  fa-floppy-o fa-fw" aria-hidden="true"></i> SUBMIT</button></div>
                                </div>
                            </div>
                          
                            <table class="table table-bordered" >
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Nama Periode</th>
                                    <th>Periode Start</th>
                                    <th>Periode End</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                  </tr>
                                </thead>
                                <tbody id="tblperiode">
                                 

                                </tbody>
                            </table>
                            <div id="linkHal"></div>


                            <div class="modal fade" id="modaledit" role="dialog" style="width: 40%;height: 50%; margin-left: 30%; margin-top: 10%; overflow-x: auto; overflow-y: auto;">
                        <div class="modal-dialog">
                        
                          <!-- Modal content-->
                          <div class="modal-content" >
                            <div class="modal-header" >
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"><b>Edit Periode</h4></b>
                            </div>
                            <div class="modal-body">
                                Nama Periode<br>
                                <input type="hidden" class="form-control" id="xtxtid" name="" style="width: 100%">
                                <input type="text" class="form-control" id="xtxtnamaperiode" name="" style="width: 100%">
                                Periode <br>
                                <table><tr><td><input type="date" class="form-control" id="xtxttglstart" name="" style="width: 100%"></td><td><font color="white">.</font></td><td><input type="date" class="form-control" id="xtxttglend" name="" style="width: 100%"></td></tr></table>
                                Status
                                <div id="xtxtstatus">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary stsperiode" onclick="updateperiode()" data-dismiss="modal">UPDATE</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                      
                    </div>


                        </div>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>