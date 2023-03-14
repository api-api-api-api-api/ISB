<?php
     echo $this->Html->script('h1mastertemplatebiaya.js');
     echo $this->Html->script('bundle.min.js');       
?>
<style>
 /* Select Pure Auto complate */
.form-control {font-size: 12px;}
textarea:focus,
select.form-control,
input[type="text"]{   
    background-color: #fcf8e3;
}
    /* End Select Pure Auto complate */
.pagination{margin:0;}
</style>

<blockquote>MASTER TEMPLATE BIAYA</blockquote><hr>

<div class="col-md-12">
    <div class="col-md-4">
        <div class="row">
            <div class="panel panel-default">
                
                <div class="panel-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;" >
                    <div class="row">
                        <table  id='tableMasterTemplate' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;margin-bottom:0;"> 
                            <thead>
                                <tr class="active">
                                    <th width="2%" style="text-align:center;vertical-align:middle">No</th> 
                                    <th width="80%" style="vertical-align:middle">Nama Template</th>         
                                    <th width="18%" style="text-align:center;vertical-align:middle">Edit</th>         
                                </tr>
                            </thead> 
                            <tbody>
                                <tr>
                                    <td colspan="3" style="text-align:center; background-color:#fff !important;"><div class="alert alert-success" role="alert" style="margin-bottom: 0;"><strong>Data Kosong</strong></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-4"><button type="button" class="btn btn-sm btn-default" id="btnShowForm">ADD TEMPLATE BIAYA</button></div>
                        <div class="col-md-8 text-right"><nav aria-label="Page navigation example " id="linkHal1" style="display:block">...</nav></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="panel panel-danger">
                <div class="panel-body" style="overflow-x:auto;" >
                <u><strong>Keterangan Input form</strong></u>
                <ul>
                    <li >Tekan tombol  <button type="button" class="btn btn-xs btn-default">ADD TEMPLATE BIAYA</button> untuk menambah template biaya</li>
                    <li >Tekan tombol  <button type='button' class='btn btn-default btn-xs'><i class='fa fa-pencil-square' style='margin: 3px 3px;'></i></button> Untuk memulai mengedit template biaya yang pernah dibuat</li>
                    <li >Tekan tombol   <button type="button" class="btn btn-xs btn-default"><i class="fa fa-plus" ></i> ADD DIVISI</button> Untuk menambah divisi dan nominal</li>
                    <li >Tekan tombol  <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash " style="margin: 3px 3px;"></i></button> Untuk menghapus data divisi yang diinput sebelumnya</li>
                    <li >Tekan tombol <button type="button" class="btn btn-xs btn-primary"><i class="fa fa-floppy-o"></i> SAVE</button> Untuk melakukan penyimpanan dan/atau perubahan data</li>
                </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-5" id="popUp">
        <form name="formTemplateBiaya" id="formTemplateBiaya">
        <input type="hidden" name="jnsCRUD" id="jnsCRUD">
        <div class="">
            <div class="panel panel-default">
                <div class="panel-heading" >
                    <div class="row">
                        <div class="col-md-12"><h5 class="control-label" id='lableTitle'>FORM TEMPLATE BIAYA:</h5></div>
                        <div class="col-md-12"><input class="form-control" type="text" name="namaTemplate" id="namaTemplate" placeholder="isikan nama template"></div>
                    </div>
                </div>
                <div class="panel-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;" >
                    <div class="row">
                        <table  id='tableMasterTemplateDetail' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;margin-bottom:0;"> 
                            <thead>
                                <tr class="active">
                                    <th width="40%" style="text-align:center;vertical-align:middle">Divisi</th> 
                                    <th width="50%" style="text-align:center;vertical-align:middle">Nominal</th>         
                                    <th width="10%" style="text-align:center;vertical-align:middle"></th>         
                                </tr>
                            </thead> 
                            <tbody><tr class="trTemplate"><td><select name="rowDivisi[]" id="rowDivisi1" class="form-control rowDivisi" onchange="cekExist(this,1)" ><option value="" selected>-Pilih Divisi-</option></select></td><td><input type="text" name="nominalDivisi[]" class="form-control nominalDivisi" id="nominalDivisi1" onKeyUp="upAngka(this)"  style="text-align:right;"></td><td align='center' style='vertical-align:middle;'><button type="button" class="btn btn-default btn-danger btn-xs btnDel"><i class="fa fa-trash fa-lg" style="margin: 5px 5px;"></i></button><input type="hidden" name="idRecord[]" id="idRecord1"></td></tr></tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-sm btn-default btn-block" id="addTr"><i class="fa fa-plus" aria-hidden="true"></i> ADD DIVISI</button>
                        </div>
                        <div class="col-md-8 text-right">
                            <button type="button" class="btn btn-sm btn-primary btn-block" id="btnSave"><i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE</button>
                        </div>       
                    </div>             
                </div>
            </div>
        </div>
        </form>
    </div>
