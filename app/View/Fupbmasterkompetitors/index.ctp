<?php 
echo $this->Html->script('h1fupbmasterkompetitor.js');
?>
<style>
.panel-heading {line-height:32px;}
.pagination{margin:0}
</style>
<div class="page-header">
    <h3>MASTER PERUSAHAAN KOMPETITOR</h3>
</div>
<form name="masterkompetitor" id="masterkompetitor" method="post">
    <div class="row">
        <div class="col-md-5">
            <div class="form-inline">
            <div class="input-group">
                <input type="text" id="txtNamaKompetitor" class="form-control" onkeyup="getData(1)" placeholder="cari nama"  style="font-size:12px;">
                <span class="input-group-addon">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </span>
            </div>  
            </div>
            
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-5">         
            <div class="panel panel-default" style="min-width:650px">
                <div class="panel-heading clearfix" style="background-color:#696969;color:#fff">
                    <div class="row">
                        <div class="col-md-5">
                            <i class="fa fa-building  fa-2x" ></i> Tambah Perusahaan Kompetitor
                        </div>
                        <div class="col-md-7 col-md-offset-0" >
                            <div class="input-group">
                                <input type="text" id="txtInputKompetitor" class="form-control"  placeholder="input nama kompetitor" style="font-size:12px;">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary addTag" type="button"><i class="fa fa-plus-circle" aria-hidden="true"> </i> ADD</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body"  style="margin-bottom:unset;padding:0 15px;">
                    <div class="row">
                        <table id="tblKompetitor" cellpadding="0" cellspacing="0" width="100%" class="table " style="margin-bottom:unset;padding:0 15px;">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align:center;">No</th> 
                                    <th width="65%">Nama Perusahaan Kompetitor</th>                  
                                    <th width="30%"></th>
                                </tr>
                            </thead> 
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>  
                </div>
                <div class="panel-footer">
                    <nav aria-label="Page navigation example " id="linkHal1" style="display:none"></nav>
                </div>
            </div>
        </div>
    </div>
</form>