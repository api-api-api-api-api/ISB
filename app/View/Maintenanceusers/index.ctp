<?php
    echo $this->Html->script('h1maintenanceuser.js');
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
</style>
<div class="row">
    <blockquote>MAINTENANCE USER</blockquote>
    <div class="form-group"><label class="control-label"> <i class="fa fa-search fa-fw"></i> FILTER BY:  </label></div>
    <div class="col-md-2">
        <div class="row">
        
            <div>
                
                <div class="form-group">
                    <input type="text" name="txtNamaUserFilter" id="txtNamaUserFilter" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="Nama User" onkeyup="if(event.keyCode === 13){getData(1)}"></div>
                <div class="form-group">
                    <input type="text" name="txtPenanggungJawabFilter" id="txtPenanggungJawabFilter" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="Penanggung Jawab" onkeyup="if(event.keyCode === 13){getData(1)}"></div>
                <div class="form-group">
                    <input type="text" name="txtNamaGroupFilter" id="txtNamaGroupFilter" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="Nama Group" onkeyup="if(event.keyCode === 13){getData(1)}"></div>
                <div class="form-group">
                    <input type="text" name="txtNIKFilter" id="txtNIKFilter" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="NIK" onkeyup="if(event.keyCode === 13){getData(1)}"></div>
                <div class="form-group">
                    <input type="text" name="txtNamaKaryawanFilter" id="txtNamaKaryawanFilter" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="NAMA KARYAWAN" onkeyup="if(event.keyCode === 13){getData(1)}"></div>
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
                    <div class="col-md-10 col-md-offset-0 text-right"><button type="button" class='btn btn-danger btn-sm'  id="btnForm"><i class="fa fa-plus-circle"> </i> ADD USER</button></div>
                </div>
            </div>
            <div class="panel-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;" >
                <div class="row">
                    <table  id='tableMaintenanceUser' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;margin-bottom:0;"> 
                        <thead>
                            <tr class="active">
                                <th width="2%" style="text-align:center;vertical-align:middle">No</th> 
                                <th width="12%" style="text-align:center;vertical-align:middle">Nama User</th>
                                <th width="8%" style="text-align:center;vertical-align:middle">Group</th>                  
                                <!-- <th width="8%" style="text-align:center;vertical-align:middle">Status Log</th> -->
                                <th width="12%" style="text-align:center;vertical-align:middle">Penangung Jawab</th>
                                <th width="12%" style="text-align:center;vertical-align:middle">Kantor Cabang</th>
                                <!-- <th width="10%" style="text-align:center;vertical-align:middle">Keterangan</th>
                                <th width="8%" style="text-align:center;vertical-align:middle">Pejabat</th>
                                <th width="8%" style="text-align:center;vertical-align:middle">Perusahaan</th>
                                <th width="8%" style="text-align:center;vertical-align:middle">Divisi</th> -->
                                <th width="8%" style="text-align:center;vertical-align:middle">Nik</th>
                                <th width="12%" style="text-align:center;vertical-align:middle">Nama Karyawan</th>
                                <th width="8%" style="text-align:center;vertical-align:middle">Tgl. Lahir</th>
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
    <div class="modal fade"  id="modalFormMaintenanceUser" role="dialog" aria-labelledby="modalFormMaintenanceUser" style="max-width: 40%; max-height: 91%; margin-left: 30%; margin-top: 2%;outline: 0;">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 6px;min-height: unset;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()"><span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span></button>
                    <h4 class="modal-title" id="myModalLabel">FORM USER</h4>
                </div>
                <div class="modal-body" style="height: 700px;max-height: 700px;overflow-y:auto;">
                    <form name="maintenanceForm" id="maintenanceForm">
                    <div class="row">
                    <!-- col-md-offset-1 -->
                        <div class="col-md-12 ">
                            <div class="panel panel-default" style="min-width:500px;">
                                <div class="panel-body">
                                    <input type="hidden" name="userID" id="userID">
                                    <!-- <p class="bg-info" style="padding: 15px;font-weight:bold;font-size:14px;" id="txtNoteReturn">test</p> -->
                                    <div class="form-horizontal">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">NAMA USER</label>
                                                <div class="col-md-8"><input class="form-control" type="text" id="namaUser" name="namaUser"  style="min-width:200px;"></div>
                                            </div>
                                            <div class="form-group" style='display:none'>
                                                <label class="col-md-4 control-label">PASSWORD</label>
                                                <div class="col-md-8"> <input type="password" class="form-control"  id="password" name="password"  style="min-width:200px;"></div>
                                            </div>
                                            <div class="form-group" style='display:none'>
                                                <label class="col-md-4 control-label">ULANGI PASSWORD</label>
                                                <div class="col-md-8"> <input type="password" class="form-control"  id="repassword" name="repassword" style="min-width:200px;"></div>
                                            </div>
                                            <div class="form-group" style='display:none'>
                                                <label class="col-md-4 control-label"></label>
                                                <div class="col-md-8 row"> <div class='col-md-6'><input type="checkbox"  id="check" name="check"> <em> Show Password</em></div>  <div class='col-md-6 text-right'><span class='label' id='message'></span></div></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">GROUP</label>
                                                <div class="col-md-8"> <select name="group" id="group" class="form-control" style="min-width:200px;"></select></div>
                                            </div>
                                            <div class="form-group"  style='display:none'>
                                                <label class="col-md-4 control-label" >STATUS LOG</label>
                                                <div class="col-md-8"><input type="text" class="form-control" id="statusLog" name="statusLog" style="min-width:200px;"></div>
                                            </div>
                                            <div class="form-group"  style='display:none'>
                                                <label class="col-md-4 control-label">ID USER</label>
                                                <div class="col-md-8"><input type="text" class="form-control" id="idUser" name="idUser" style="min-width:200px;"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">PENGANGGUNG JAWAB</label>
                                                <div class="col-md-8"><input type="text" class="form-control" id="penangggungJawab" name="penangggungJawab" style="min-width:200px;"></div>
                                            </div>
                                            <div class="form-group"  style='display:none'>
                                                <label class="col-md-4 control-label">KETERANGAN</label>
                                                <div class="col-md-8" ><textarea name="keterangan" id="keterangan" class="form-control"  rows="3" style="resize:none"></textarea></div>
                                            </div>
                                            <div class="form-group"  style='display:none'>
                                                <label class="col-md-4 control-label">PEJABAT</label>
                                                <div class="col-md-8"><input type="text" class="form-control" id="pejabat" name="pejabat" style="min-width:200px;"></div>
                                            </div>
                                            <div class="form-group"  style='display:none'>
                                                <label class="col-md-4 control-label">PERUSAHAAN</label>
                                                <div class="col-md-8"><select name="perusahaan" id="perusahaan" class="form-control" style="min-width:200px;"></select></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">KANTOR CABANG</label>
                                                <div class="col-md-8"><select name="com" id="com" class="form-control" style="min-width:200px;"></select></div>
                                            </div>
                                            <div class="form-group"><hr>
                                                <label class="col-md-4 control-label">NIK</label>
                                                <div class="col-md-8"><input class="form-control" type="text" id="nik" name="nik" style="min-width:200px;" readonly></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">NAMA KARYAWAN</label>
                                                <div class="col-md-8"><input class="form-control" type="text" id="namaKaryawan" name="namaKaryawan" style="min-width:200px;" readonly></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">TANGGAL LAHIR</label>
                                                <div class="col-md-8"><input class="form-control" type="text" id="tglLahir" name="tglLahir" style="min-width:200px;" readonly></div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"  style='display:none'>
                                                <label class="col-md-4 control-label">DIVISI</label>
                                                <div class="col-md-8"><select name="divisi" id="divisi" class="form-control" style="min-width:200px;"></select></div>
                                            </div>
                                            
                                            <div class="form-group"  style='display:none'>
                                                <label class="col-md-4 control-label">ARCO</label>
                                                <div class="col-md-8"><input class="form-control" type="text" id="arco" name="arco" style="min-width:200px;"></div>
                                            </div>
                                            <div class="form-group"  style='display:none'>
                                                <label class="col-md-4 control-label">SUB DIVISI</label>
                                                <div class="col-md-8"><input class="form-control" type="text" id="subDivisi" name="subDivisi" style="min-width:200px;"></div>
                                            </div>
                                            <div class="form-group"  style='display:none'>
                                                <label class="col-md-4 control-label">REG</label>
                                                <div class="col-md-8"><input class="form-control" type="text" id="reg" name="reg" style="min-width:200px;"></div>
                                            </div>
                                            <div class="form-group"  style='display:none'>
                                                <label class="col-md-4 control-label">INISIAL</label>
                                                <div class="col-md-8"><input class="form-control" type="text" id="inisial" name="inisial" style="min-width:200px;"></div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="form-horizontal">
                                        
                                       
                                        
                                    </div>
                                </div>
                                <div class='panel-footer'>
                                    <button type="button" class="btn btn-block btn-lg btn-default" id="buttonSave" ><i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE USER</button>  
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