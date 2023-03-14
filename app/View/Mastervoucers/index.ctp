<?php
     echo $this->Html->script('h1mastervoucer.js');
     echo $this->Html->script('bundle.min.js');       
?>
<style>
.pagination{margin:0}
</style>
<div class="row">
    <blockquote>MASTER VOUCER</blockquote>
</div>
<div class="row">
    <hr>
    <div class='col-md-8'>
        <div class="row">   
            <div class="form-group"><label class="control-label"> <i class="fa fa-search fa-fw"></i> FILTER BY:  </label></div>
                <div class="form-group">
                    <input type="text" name="txtNamaVoucerFilter" id="txtNamaVoucerFilter" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="Nama Voucer" onkeyup="if(event.keyCode === 13){getData(1)}"></div>
                <div class="form-group">
                    <select name="txtStatus" id="txtStatus" class="form-control" onchange="getData(1)" style="width:250px;margin-bottom:0;font-size:11px;">
                        <option value="" selected="selected">Pilih Status</option>
                        <option value="true">Aktif</option>
                        <option value="false">Tidak Aktif</option>
                    </select>
                </div>
            <button type="button"class='btn btn-default btn-sm' style="margin-bottom:0" onclick='getData(1)'> <i class="fa fa-search fa-fw"></i> CARI</button><hr>   
            <button type="button" class='btn btn-default btn-sm'  id="btnAdd"><i class="fa fa-plus-circle"> </i> TAMBAH VOUCER</button><hr>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading" >
                    <div class="row">
                        <div class="col-md-6"><label class="control-label"><i class="fa fa-th-list fa-fw"></i> RECORD DATA VOUCER</label></div>
                    </div>
                </div>
                <div class="panel-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;" >
                    <div class="row">
                        <table  id='tableVoucer' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;margin-bottom:0;"> 
                            <thead>
                                <tr class="active">
                                    <th width="2%" style="text-align:center;vertical-align:middle">No</th> 
                                    <th width="5%" style="text-align:center;vertical-align:middle">Edit</th>
                                    <th width="70%" style="text-align:left;vertical-align:middle">Nama Voucer</th>      
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
                    <nav aria-label="Page navigation example " id="linkHal1" style="display:block">.</nav>
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
                        <dd>Klik tombol <button type="button" class='btn btn-default btn-sm'><i class="fa fa-plus-circle"> </i> TAMBAH VOUCER</button> untuk melakukan penambahan data</dd>
                        <dd>Klik tombol <button type='button' class='btn btn-xs btn-default'><i class='fa fa-edit fa-lg' style='margin: 5px 5px;'></i></button> untuk melakukan perubahan nama  dan/atau status Voucer</dd>
                    </dl>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    
</div>
<!-- Modal Form -->
    <div class="modal fade"  id="modalFormMastervoucer" role="dialog" aria-labelledby="modalFormMastervoucer" style="max-width: 30%; max-height: 50%; margin-left: 35%; margin-top: 2%;outline: 0;">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 6px;min-height: unset;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()"><span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span></button>
                    <h4 class="modal-title" id="myModalLabel">FORM USER</h4>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <form name="maintenanceForm" id="maintenanceForm">
                    <div class="row">
                    <!-- col-md-offset-1 -->
                        <div class="col-md-12 ">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <input type="hidden" name="voucerID" id="voucerID">
                                    <!-- <p class="bg-info" style="padding: 15px;font-weight:bold;font-size:14px;" id="txtNoteReturn">test</p> -->
                                    <div class="form-horizontal">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">NAMA VOUCER</label>
                                                <div class="col-md-8"><input class="form-control" type="text" id="namaVoucer" name="namaVoucer"  style="min-width:200px;"></div>
                                            </div>
                                            <div class="form-group" >
                                                <label class="col-md-4 control-label">STATUS</label>
                                                <div class="col-md-8"> 
                                                    <div class="">
                                                        <label>
                                                            <input type="radio" name="status" id="optionsRadios1" value="true"> <span style="vertical-align: top"> Aktif</span>   
                                                        </label>
                                                    </div>
                                                    <div class="">
                                                        <label>
                                                            <input type="radio" name="status" id="optionsRadios2" value="false"><span style="vertical-align: top"> Tidak Aktif</span>
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
                                    <button type="button" class="btn btn-block btn-lg btn-default" id="buttonSave" ><i class="fa fa-floppy-o"></i> SAVE</button>  
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </form>       
                </div>
                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeModal()"><i class="fa fa-times-circle "> </i> Close</button>
                </div>
            </div>
        </div>
    </div>
    