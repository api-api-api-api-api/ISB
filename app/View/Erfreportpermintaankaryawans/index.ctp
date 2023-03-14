<?php 
    echo $this->Html->script('h1erfreportpermintaankaryawan.js');
    echo $this->Html->script('bundle.min.js');
    echo $this->Html->script('editor.js');
    echo $this->Html->script('jquery.signaturepad.min.js');
    echo $this->Html->css('jquery.signaturepad.css');
    echo $this->Html->css('/css/editor'); 
?>
<style>
    table.table-bordered th:last-child, table.table-bordered td:last-child {
        border-right-width: 1;
    }
    #tableListPengajuan thead {position: -webkit-sticky;  position: sticky;  top: 0;  z-index: 2;}
    #tableListPengajuan>thead>tr>td, .table-bordered>thead>tr>th {
    border-bottom-width: 0;
}
    
</style>
<div class="container-fluid">
    <div class="row">
        <!-- Form Add -->
        <form id="h1form" name="h1form" method="POST">
        <textarea name="buffer" cols="50" rows="10" class="textBuff"></textarea>
            <h1 class="mt-4">REPORT PERMINTAAN KARYAWAN</h1><hr>
            <div class="col-md-12">
                <div class='row'>
                    <div class="col-md-4" >
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
                                            
                                            <td width="120px" >Tahun</td>
                                            <td width="8px">:</td>
                                            <td width="300px">
                                                
                                                    <select name="tahun" id="tahun" class="form-control"   style='font-size:11px !important;width:100px;'>
                                                    <?php
                                                        for ($t=date("Y")-5;$t<=date("Y")+10;$t++){
                                                        if($t==date("Y")){
                                                                echo "<option value=$t selected>$t</option>\n";
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
                                            <td width="300px">
                                                    <select name="bulan" id="bulan" class="form-control"   style='font-size:11px !important;width:100px;'>

                                                    <?php
                                                        for($t=1;$t<=12;$t++){
                                                            if($t==date("n")){
                                                            echo "<option value=$t selected>".$this->Function->monthName($t)."</option>\n";
                                                            }
                                                                else{echo "<option value=$t>".$this->Function->monthName($t)."</option>\n";}
                                                            }	
                                                    ?>
                                                    </select>
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td width="90px">Report Permintaan</td>
                                            <td width="8px">:</td>
                                            <td width="300px">
                                                <select name="reportPermintaan" id="reportPermintaan" class="form-control" style="min-width:250px;">
                                                    <option value="perbulan">Report Permintaan karyawan / bulan</option>
                                                    <option value="outstatnding">Report Pengajuan yang masih outstanding</option>
                                                    <option value="realisasi">Report Realisasi</option>
                                                    <option value="finish">Report Finish</option>
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
                    <div class="col-md-2"></div>
                    <div class='col-md-5'>
                        <div class='panel panel-info'>
                               <table class='table table-bordered'>
                                    <thead>
                                        <tr>
                                            <th colspan='2'><em>#Keterangan angka (1,2,3,4,5) Dasar Permintaan (Basic Request)</em></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="info">
                                            <td width="5%">1</td>
                                            <td>Rencana dan Anggaran Tahunan (RAT) HRD</td>
                                        </tr>
                                        <tr class="info">
                                            <td>2</td>
                                            <td>Penggantian karyawan yang mengundurkan diri </td>
                                        </tr>
                                        <tr class="info">
                                            <td>3</td>
                                            <td>Penggantian sementara karyawan yang cuti/berhalangan sementara (seijin Perusahaan) </td>
                                        </tr>
                                        <tr class="info">
                                            <td>4</td>
                                            <td>Pengembangan usaha/volume pekerjaan yang bertambah banyak (diluar RAT HRD) </td>
                                        </tr>
                                        <tr class="info">
                                            <td>5</td>
                                            <td>Dasar permintaan selain keempat kategori diatas</td>
                                        </tr>
                                    </tbody>
                               </table> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="panel panel-default" >
                        <div class="panel-heading" ><strong><h4>List Pengajuan</h4></strong>
                        </div>
                        <div class="panel-body table-responsive" style='height:350px;max-height: 350px;overflow-y:auto;padding:0 15px;;' >
                            <div class="row">
                                <table id="tableListPengajuan" cellpadding="0" cellspacing="0" width="100%" class="table table-bordered" style="">
                                    <thead>
                                        <tr class="active">
                                            <th width="5%"  rowspan="2" style="text-align:center;vertical-align:middle;">no</th>
                                            <th width="10%" rowspan="2" style="text-align:center;vertical-align:middle;">Tanggal</th>
                                            <th width="35%" rowspan="2" style="text-align:center;vertical-align:middle;">Pemohon</th>
                                            <th colspan='5' style="text-align:center;vertical-align:middle;">Dasar Permintaan</th>
                                            <th width="10%" rowspan="2" style="text-align:center;vertical-align:middle;border-right-width:1 !important;">Jumlah</th>
                                        </tr>
                                        <tr  class="active">
                                            <th width="5%">1</th>
                                            <th width="5%">2</th>
                                            <th width="5%">3</th>
                                            <th width="5%">4</th>
                                            <th width="5%">5</th>                                           
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot></tfoot>
                                </table> 
                            </div>
                            
                        </div>
                        <div class='panel-footer'><div class='row'><div class="col-md-12"><button type="button" class="btn btn-success btn-sm" onclick="cetakexcel('excel')"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Cetak Excel</button></div></div></div>
                    </div>
                </div>
            </div>
            
        </Form> 
    </div>
</div>