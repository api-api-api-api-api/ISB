<?php 

echo $this->Html->script('jquery.signaturepad.min.js');
echo $this->Html->script('h1fupbappl.js');
echo $this->Html->css('jquery.signaturepad.css');
?>
<style>
    #getDataFupbApp tbody tr th,.table tbody tr:hover td, .table tbody tr:hover th{background-color:unset !important} 
    #getDataFupbApp tbody tr:nth-child(even) td{background-color:unset !important;padding:unset ;}
    #getDataFupbApp  tbody tr td > a{color: darkslategray !important;font-size: 12px;padding: 2px;margin-right: 4px;}
    @media screen and (max-width: 1800px) {
    .col-md-4,.col-md-5,.col-md-6,.col-md-7,.col-md-8{float: left;width:100%;}
    .col-md-offset-2 {margin-left: 0;}
    

}

.tblDetail tr>td{padding:10px 10px !important}
</style>
<div class="page-header">
    <h3>Approval FUPB</h3>
</div>
<form name="fupbAppl" id="fupbAppl" method="post">
    <div class="row" style="display:none">
        <div class="col-md-4">
            <div class="panel panel-primary" style="min-width:450px;">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-8">
                            <span class=""><i class="fa fa-th-list fa-fw" aria-hidden="true"> </i> Filter By</span>
                        </div>
                        <div class="col-md-4 col-md-offset-0 text-right"></div>
                    </div>
                </div>
                <div class="panel-body" > 
                    
                </div>
                <div class="panel-footer"><button type="button" class="btn btn-info btn-xs" onclick="searchFupb()"><i class="fa fa-search" aria-hidden="true"></i> Search</button></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row">
                        <table id='getDataFupbApp' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;margin-bottom:0;"> 
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align:center;">No</th> 
                                    <th width="15%">No. FUPB</th>                  
                                    <th width="10%" style="text-align:center;">Tanggal</th>
                                    <th width="25%">Nama Project</th>
                                    <th width="10%" style="text-align:center;">Divisi</th>
                                    <th width="20%">Pengaju</th>
                                    <th width="10%" style="text-align:center;">Status Pengajuan</th>
                                    <th width="20%"></th>
                                </tr>
                            </thead> 
                            <tbody>
                                <tr>
                                    <td colspan="9" style="text-align:center;">-- Empty Data --</td>
                                </tr>
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example " id="linkHal1" style="display:none"></nav>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name='idCetakPDF' id="idCetakPDF">
</form>

<!-- mmodal return -->
<div class="modal fade" id="modalReturn" role="dialog" aria-labelledby="modalReturn" style="max-width: 30%; max-height: 91%; margin-left: 35%; margin-top: 2%;outline: 0;">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 6px;min-height: unset;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeUncheck()"><span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span></button>
                <h4 class="modal-title" id="myModalLabel">Dikembalikan</h4>
            </div>
            <div class="modal-body" style="height: 315px;max-height: 315px;overflow-y:auto;">
                <input type="hidden" id="txtidHisFupb" name="txtidHisFupb">
                <div class="form-group">
                    <textarea name="txtAlasanReturn" class="form-control"id="txtAlasanReturn" cols="32" rows="10" style="background:rgb(255, 239, 213);resize:none" placeholder="Alasan Dikembalikan"></textarea>
                </div>
                <button style="font-family:Arial !important;font-size:16px; font-weight:500;" type="button" class="btn btn-block btn-default btn-lg" id="tmblSaveReturn" ><i class="fa  fa-floppy-o fa-fw" aria-hidden="true"></i> Save Return FUPB</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
            </div>
        </div>
    </div>
</div>