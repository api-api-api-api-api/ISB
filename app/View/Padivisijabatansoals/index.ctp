<?php
    echo $this->Html->script('h1padivisijabatansoal.js');
    echo $this->Html->script('bundle.min.js');       
?>
<style>
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: unset !important;
    }
    .tab{transition: transform .2s;}
	.tab:hover {cursor:pointer;transform: scale(1.01);
        background-image: linear-gradient(to right, #25aae1, #4481eb, #04befe, #3f86ed) !important;
        box-shadow: 0 4px 15px 0 rgba(65, 132, 234, 0.75); font-weight: 700;}
	.ativetab{background:#25aae1 !important;border-top:1px solid #ddd !important; color:white; font-weight: 700;}
</style>
<blockquote>MASTER DIVISI DAN JABATAN SOAL</blockquote>
<div class="row">
    <div class="col-md-5">
        <div class="form-group"><label class="control-label"> <i class="fa fa-search fa-fw"></i> Cari Data:  </label></div>
                <div class="row">
                
                    <div class="col-md-8">
                        <div  class="form-inline" style="margin-bottom:12px;">
                            <div class="form-group">
                                <input type="text" name="txtSrcDivisi" id="txtSrcDivisi" class="form-control" style="width:250px;margin-bottom:0;font-size:11px;" placeholder="Cari Divisi" onkeyup="if(event.keyCode === 13){getDataDivisi(1)}">
                            </div>
                            <button type="button"class='btn btn-default' style="margin-bottom:0" onclick='getDataDivisi(1)'> <i class="fa fa-search fa-fw"></i> CARI</button>
                        </div>
                    </div>
                    <div class="col-md-4 col-md-offset-0 text-right">
                        
                    </div>
                
        </div>
    </div>
</div>
<div class="row">
        
        <div class="col-md-5">             
                <div class="col-md-12">
                    <div class="row">
                    <div class="panel panel-default" >
                        <div class="panel-heading" >
                            <div class="row">
                                <div class="col-md-12">
                                <label class="control-label"><i class="fa fa-th-list fa-fw"></i>DATA DIVISI</label>
                                <div class="input-group">
                                        <input type="text" id="txtInputDivisi" name='txtInputDivisi' class="form-control"  placeholder="Input Nama Divisi" style="font-size:12px;">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" id='addDivisi' type="button" onclick=''><i class="fa fa-plus-circle" aria-hidden="true"> </i> TAMBAH DIVISI</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;" >
                            <div class="row">
                                
                            </div>  
                        </div>
                        <table  id='tableDivisiSoals' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;margin-bottom:0;"> 
                                    <thead>
                                        <tr class="active">
                                            <th width="3%" style="text-align:center;vertical-align:middle">No</th> 
                                            <th width="50%"  style="vertical-align:middle">Divisi</th>                  
                                            <th width="17%" style="text-align:center;vertical-align:middle">Action</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        <tr>
                                            <td colspan="5" style="text-align:center; background-color:#fff !important;"><div class="alert alert-info" role="alert" style="margin-bottom: 0;"><strong>Data Kosong</strong></div></td>
                                        </tr>
                                    </tbody>
                                </table>
                        <div class="panel-footer">
                            <nav aria-label="Page navigation example " id="linkHal1" style="display:block">...</nav>
                        </div>
                    </div>
                    </div>
                </div>
           
        </div>
        <div class="col-md-5">
            <div class="col-md-12">
                    <div class="row">
                    <div class="panel panel-info" >
                        <div class="panel-heading" >
                            <div class="row">
                                <div class="col-md-12">
                                <label class="control-label"><i class="fa fa-th-list fa-fw"></i>DATA JABATAN</label>
                                <input type="hidden" id='txtDivisiId' name='txtDivisiId'>
                                <div class="input-group">
                                        <input type="text" id="txtInputJabatan" class="form-control"  placeholder="Input Nama Jabatan" style="font-size:12px;">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" id="addJabatan" type="button"><i class="fa fa-plus-circle" aria-hidden="true"> </i> TAMBAH JABATAN</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;" >
                            <div class="row">
                                <table  id='tableJabatanSoals' cellpadding="0" cellspacing="0" width="100%" class="table" style="border-radius: 5px;margin-bottom:0;"> 
                                    <thead>
                                        <tr class="active">
                                            <th width="3%" style="text-align:center;vertical-align:middle">No</th> 
                                            <th width="50%"  style="vertical-align:middle">Jabatan</th>                  
                                            <th width="17%" style="text-align:center;vertical-align:middle">Action</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        <tr>
                                            <td colspan="5" style="text-align:center; background-color:#fff !important;"><div class="alert alert-info" role="alert" style="margin-bottom: 0;"><strong>Data Kosong</strong></div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>  
                        </div>
                        <div class="panel-footer">
                            <nav aria-label="Page navigation example " id="linkHal2" style="display:block">...</nav>
                        </div>
                    </div>
                    </div>
                </div>
        </div>
</div>
