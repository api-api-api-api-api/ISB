<?php
    echo $this->Html->Script('h1eflaporan.js');
?>
<style>
    .TableSpesifikasiKebutuhan tr td{padding:5px;}
    #tableListPengajuan tbody tr:nth-child(even) td{padding-top:0;padding-bottom:0}
</style>
<h1>REPORT EMPLOYEE RECRUITMENT FORM</h1><hr>
<form action="h1form"></form>
<div class="container-fluid">
    <div class='row'>
        <div class="col-xs-4" >
            <div class='row'>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="panel-title"><i class="fa fa-th-list fa-fw" aria-hidden="true"> </i> Filter By</h4>
                            </div>
                            <div class="col-md-4 col-md-offset-0 text-right"></div>
                        </div>
                    </div>
                    <div class="panel-body" style="padding:0 15px;">
                        <table class="tblFilter"style="margin:6px;">
                        <tr>
                                
                                <td width="50px" >Tahun</td>
                                <td width="8px">:</td>
                                <td >
                                    
                                        <select name="tahun" id="tahun" class="form-control"   style='font-size:11px !important;margin-bottom: 0;'>
                                        <option value="" selected="selected">All</option>
                                        <?php
                                            for ($t=date("Y")-5;$t<=date("Y")+10;$t++){
                                            if($t==date("Y")){
                                                    echo "<option value=$t >$t</option>\n";
                                                    }
                                                else{echo "<option value=$t>$t</option>\n";}
                                            }
                                        ?>
                                        </select>
                                    
                                </td>
                                
                            </tr>
                            <tr>
                                <td width="90px">Bulan</td>
                                <td width="8px">:</td>
                                <td width="100px">
                                        <select name="bulan" id="bulan" class="form-control"   style='font-size:11px !important;margin-bottom: 0;'>
                                        <option value="" selected="selected">All</option>
                                        <?php
                                            for($t=1;$t<=12;$t++){
                                                if($t==date("n")){
                                                echo "<option value=$t >".$this->Function->monthName($t)."</option>\n";
                                                }
                                                    else{echo "<option value=$t>".$this->Function->monthName($t)."</option>\n";}
                                                }	
                                        ?>
                                        </select>
                                </td>
                            </tr>                            
                        </table>   
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-primary" style="margin-top:6px;margin-bottom:6px;font-size:12px;" onclick="getData(1)"><i class="fa fa-search" aria-hidden="true"></i></i> Cari</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="panel panel-default" >
                    <div class="panel-heading" >List Pengajuan
                    </div>
                    <div class="panel-body table-responsive" style="padding-top:0;padding-bottom:0;" >   
                        <div class="row">
                            <table id="tableListPengajuan" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="2%">no</th>
                                        <th width="10%">Nomor Pengajuan</th>
                                        <th width="10%">Tanggal Penajuan</th>
                                        <th width="25%">Dasar Permintaan</th>
                                        <th width="35%">Spesifikasi Kebutuhan</th>
                                        <th width="20%">Status Pengajuan</th>
                                    </tr>
                                </thead>
                                <tbody>
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

<!-- Modal Pembatalan ERF -->
<div class="modal fade" role="dialog" id="modalPembatalanErf" style="max-width: 34%; max-height: 75%; margin-left: 33%; margin-top: 2%;outline: 0;">
  
  <div class="modal-dialog" role="document" >
      <div class="modal-content" style="border-radius: 6px;border-radius: 6px;min-height: unset;">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                  <span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span>
              </button>
              <h4 class="modal-title" id="myModalLabel">Pembatalan Permintaan Karyawan</h4>
          </div>     
          <div class="modal-body" style="max-height: 500px;overflow-y:auto;">
            <input type="hidden" name='idErf' id="idErf">
            <input type="hidden" name='nomorErf' id="nomorErf">
            <input type="hidden" name='pengaju' id="pengaju">
              <div class="panel panel-default" style="min-width:400px">
                <div class="panel-heading clearfix" style="background-color:#696969;color:#fff">
                    <div class="row">
                        <div class="col-md-5" style="line-height: 32px;">
                             Nomor Pengajuan : 
                        </div>
                        <div class="col-md-7 col-md-offset-0" >
                            <span class='form-control' id='txtNomorErf' style="font-size:14px;height: 34px;font-weight:700;font-style: italic;"></span>
                            
                        </div>
                    </div>
                </div>
                <div class="panel-body"  style="margin-bottom:unset;padding:0 15px;">
                    <div class="row">
                        <textarea name="ketPembatalan" id="ketPembatalan" class='form-control' cols="30" placeholder='Alasan pembatalan' rows="10"></textarea>
                    </div>  
                </div>
                
                
            </div>
            
                
          </div>
          <div class="modal-footer">
            <div class="row">
                <div class="col-md-6 text-left">
                    <button type="button" id="btnSimpanPembatalan" class="btn btn-primary  mr-auto"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-default ml-1" data-dismiss="modal" onclick="closeModal()"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
                </div>
              
            </div>
              
          </div>
      </div>
  
  </div>
</div>
<!-- End Modal Pembatalan ERF-->